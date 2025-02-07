<?php

namespace App\Http\Controllers;

use App\Services\TwilioSMSService;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use App\Models\Service;


class AttendanceController extends Controller
{
    protected $smsService;

    public function twiliosendSms($to, $message)
    {
        // $this->smsService = $smsService;
    }

    public function sendSms(Request $request)
    {
        if ($request->has('member_id')) {
            // Send SMS to a specific member
            $member = Member::findOrFail($request->input('member_id'));

            // Default message
            $message = "Dear {$member->name}, we noticed you missed today's service. Hope to see you soon!";

            try {
                $response = $this->smsService->sendSMS($member->mobile_number, $message);
                return redirect()->back()->with('success', 'SMS sent successfully to the member!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send SMS: ' . $e->getMessage());
            }
        } elseif ($request->has('sms_message')) {
            // Send SMS to all absent members
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
                    // Log errors for individual members
                    Log::error("Failed to send SMS to {$member->mobile_number}: {$e->getMessage()}");
                }
            }

            return redirect()->route('admin.attendance.absent')->with('success', 'SMS sent successfully to all absent members!');
        }

        return redirect()->back()->with('error', 'No valid data provided for sending SMS.');
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
}
