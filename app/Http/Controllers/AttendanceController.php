<?php

namespace App\Http\Controllers;

use App\Services\TextMeSMSService;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use Carbon\Carbon;
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AbsentMemberNotification;


class AttendanceController extends Controller
{
    protected $smsService;

    public function __construct(TextMeSMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function sendSms(Request $request)
    {
        if ($request->has('member_id')) {
            $member = Member::findOrFail($request->input('member_id'));
            $message = "Dear {$member->name}, we noticed you missed today's service. Hope to see you soon!";

            try {
                $response = $this->smsService->sendSMS($member->mobile_number, $message);
                return redirect()->back()->with('success', 'SMS sent successfully to the member!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send SMS: ' . $e->getMessage());
            }
        } elseif ($request->has('sms_message')) {
            $request->validate(['sms_message' => 'required|string|max:160']);
            $defaultService = Service::first();

            if (!$defaultService) {
                return redirect()->back()->with('error', 'No default service found to determine absent members.');
            }

            $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)->whereDate('date', today());
            })->get();

            foreach ($absentMembers as $member) {
                try {
                    $this->smsService->sendSMS($member->mobile_number, $request->sms_message);
                } catch (\Exception $e) {
                    Log::error("Failed to send SMS to {$member->mobile_number}: {$e->getMessage()}");
                }
            }

            return redirect()->route('admin.attendance.absent')->with('success', 'SMS sent successfully to all absent members!');
        }

        return redirect()->back()->with('error', 'No valid data provided for sending SMS.');
    }




 // Make sure to import the Service model

public function index()
{
    $members = Member::paginate(10); // Adjust pagination as needed
    $services = Service::all(); // Fetch all services
    $defaultService = Service::first(); // First service as default

    return view('admin.attendance.index', [
        'members' => $members,
        'services' => $services, // Ensure this is passed
        'defaultService' => $defaultService,
    ]);
}



    public function showAbsentMembers($serviceId)
    {
        $service = Service::find($serviceId);
        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId)
                  ->whereDate('date', today());
        })->get();

        return view('admin.attendance.absent', compact('service', 'absentMembers'));
    }

    public function generateReport(Request $request)
    {
        $type = $request->query('type');

        if ($type == 'weekly') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($type == 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        } else {
            return back()->with('error', 'Invalid report type.');
        }

        $absentMembers = Member::whereDoesntHave('attendances', function($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        })->get();

        return view('admin.reports.absent-members', [
            'absentMembers' => $absentMembers,
            'type' => $type,
            'service' => Service::first()
        ]);
    }

    // New method to send absence alerts to leaders
    public function sendAbsenceAlertsToLeaders()
    {
        $defaultService = Service::first();

        if (!$defaultService) {
            Log::error('No default service found for absence alerts.');
            return;
        }

        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
            $query->where('service_id', $defaultService->id)->whereDate('date', today());
        })->get();

        $leaders = Member::whereHas('roles', function ($query) {
            $query->where('name', 'leader');
        })->get();

        foreach ($leaders as $leader) {
            try {
                Notification::route('mail', $leader->email)
                    ->notify(new AbsentMemberNotification($absentMembers));
            } catch (\Exception $e) {
                Log::error("Failed to send absence alert to leader {$leader->email}: {$e->getMessage()}");
            }
        }
    }
}
