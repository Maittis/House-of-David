<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Attendance;
use App\Models\Service;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;
use App\Services\TwilioSMSService;
use Illuminate\Support\Facades\Log;
use App\Models\SmsReply;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\InspirationalMessage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inquiry;
use App\Models\InquiryReply;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsAppService;




class AdminController extends Controller
{
    // Add method to show contact inquiries
    public function showContacts()
    {
        $contacts = \App\Models\Contact::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    use HasRoles;




protected $twilioSMSService;
protected $whatsappService;

public function __construct(TwilioSMSService $twilioSMSService, WhatsAppService $whatsappService)
{
    $this->twilioSMSService = $twilioSMSService;
    $this->whatsappService = $whatsappService;
}







    public function dashboard()
    {


        $inspirationalMessages = InspirationalMessage::latest()->take(5)->get();



        // Count total members
        $totalMembers = Member::count();

        // Calculate the number of members present today (distinct by member ID)
        $presentToday = Attendance::whereDate('date', now())
            ->distinct('member_id')
            ->count('member_id');

        // Calculate the number of absent members (total members minus present members)
        $absentToday = max(0, $totalMembers - $presentToday);

        // Calculate the number of new members this month
        $newMembersThisMonth = Member::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Fetch the default service (assuming the first service is the default)
        $defaultService = Service::first();

        // Calculate the number of members absent for the default service today
        $absentTodayForService = $defaultService
            ? Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)
                    ->whereDate('date', today());
            })->count()
            : 0;

        // Fetch the list of members absent for the default service today
        $absentMembers = $defaultService
            ? Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)
                    ->whereDate('date', today());
            })->get()
            : collect();

        // Find the first absent member who needs follow-up, sorted by last attendance date
        $followUpNeeded = $absentMembers->sortBy('last_attendance')->first();

        // Fetch all members (if needed for other parts of the dashboard)
        $members = Member::all();

        // Fetch all services (if needed for other parts of the dashboard)
        $services = Service::all();



        // Pass the data to the view
        return view('admin.dashboard', compact(
            'totalMembers',
            'inspirationalMessages',
            'presentToday',
            'absentToday',
            'newMembersThisMonth',
            'defaultService',
            'absentTodayForService',
            'absentMembers',
            'followUpNeeded',
            'members',
            'services'
        ));
    }






    public function members()
    {
        $members = Member::withCount('attendances')->paginate(10); // Paginate with 10 items per page
        return view('admin.members', compact('members'));
    }






    public function createMember()
    {
        return view('admin.members.create');
    }






    public function storeMember(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'mobile_number' => 'required|unique:members,mobile_number',
            'gender' => 'nullable|string|in:male,female,other',
        ]);

        Member::create($validatedData);


        return redirect()->route('admin.dashboard')->with('success', 'Member created successfully.');
    }



    public function editMember(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }





    public function updateMember(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);


        $member->update($validatedData);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }




    public function deleteMember(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members')->with('success', 'Member deleted successfully.');
    }




    public function storeAttendance(Request $request)
    {
        $request->validate([
            'member_ids' => 'required|array|min:1', // Ensure at least one member is selected
            'member_ids.*' => 'exists:members,id',
            'service_id' => 'required|exists:services,id',
        ]);

        // Process each selected member
        foreach ($request->input('member_ids') as $member_id) {
            Attendance::create([
                'member_id' => $member_id,
                'service_id' => $request->input('service_id'),
                'date' => now(),
            ]);

            $member = Member::find($member_id);
            $member->last_attendance = now();
            $member->save();
        }

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance marked successfully for selected members.');
    }

    public function index()
    {
        $totalMembers = Member::count();

        // Fetch the default service (you can customize this logic if needed)
        $defaultService = Service::first();

        // Fetch members present today for the default service
        $presentToday = $defaultService
            ? Attendance::where('service_id', $defaultService->id)
                ->whereDate('date', today())
                ->distinct('member_id')
                ->pluck('member_id')
            : collect();

        // Paginate the present members
        $presentMembers = Member::whereIn('id', $presentToday)->paginate(10); // 10 members per page

        // Fetch absent members for the default service
        $absentMembers = $defaultService
            ? Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)
                    ->whereDate('date', today());
            })->get()
            : collect();

        // Fetch all members for the attendance marking form
        $members = Member::orderBy('name')->paginate(25);
        // Fetch all services for the dropdown
        $services = Service::all();

        // Pass data to the view
        return view('admin.attendance.index', compact(
            'defaultService',
            'presentMembers',
            'absentMembers',
            'members',
            'services'
        ));
    }

    public function absentMembers()
    {
        $defaultService = Service::first();

        // Fetch absent members for the default service with pagination
        $absentMembers = $defaultService
            ? Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)
                    ->whereDate('date', today());
            })->paginate(10) // Set to 10 items per page
            : collect();

        return view('admin.attendance.absent', compact('defaultService', 'absentMembers'));
    }

    public function getAbsentMembersForService($serviceId)
    {
        $service = Service::findOrFail($serviceId);

        // Fetch absent members for the specified service
        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId);
        })->get();

        return view('admin.attendance.absent', compact('service', 'absentMembers'));
    }

    public function saveAttendanceForService(Request $request, $serviceId)
    {
        // First, find the service
        $service = Service::findOrFail($serviceId);

        // Get the list of members who were present from the form submission
        $membersPresent = $request->input('members', []);

        // Record attendance for present members
        foreach ($membersPresent as $memberId) {
            $member = Member::findOrFail($memberId);
            $service->members()->attach($member, ['date' => now()]);
        }

        // Optionally, handle members who were absent
        // For example, you could send SMS or log absences here

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Attendance recorded successfully');
    }

    private function updateAbsentMembersForService($serviceId)
    {
        // Fetch members who didn't attend this specific service in the last week
        $attendedMembers = Attendance::where('service_id', $serviceId)
                                     ->whereDate('date', '>=', now()->subWeek())
                                     ->pluck('member_id');

        // Find members who are not in the list of attendees
        $absentMembers = Member::whereNotIn('id', $attendedMembers)->get();

        // Here you could save or update the list of absent members for this service in your database if you want to persist this information
        // For simplicity, we're not storing this, but you could if needed
    }

    public function viewAbsentMembersForService($serviceId)
    {
        $service = Service::findOrFail($serviceId);

        // Fetch members who haven't attended the specific service today
        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($serviceId) {
            $query->where('service_id', $serviceId)
                  ->whereDate('date', today());
        })->get();

        return view('admin.attendance.absent', compact('absentMembers', 'service'));
    }

    public function sendSms(Request $request)
    {
        if ($request->has('member_id')) {
            $member = Member::findOrFail($request->input('member_id'));
            $message = "Dear {$member->name}, we noticed you missed today's service. We hope to see you soon!";

            // Send via WhatsApp if requested
            if ($request->input('via') === 'whatsapp') {
                if ($this->whatsappService->sendMessage($member->mobile_number, $message)) {
                    return redirect()->route('admin.attendance.index')->with('success', 'WhatsApp message sent successfully!');
                }
                return redirect()->back()->with('error', 'Failed to send WhatsApp message.');
            }

            // Default to SMS via Twilio
            if ($this->twilioSMSService->twiliosendSms($member->mobile_number, $message)) {
                return redirect()->route('admin.attendance.index')->with('success', 'SMS sent successfully!');
            }
            return redirect()->back()->with('error', 'Failed to send SMS.');
        }

        if ($request->has('sms_message')) {
            $request->validate(['sms_message' => 'required|string|max:160']);

            $defaultService = Service::first();
            if (!$defaultService) {
                return redirect()->back()->with('error', 'No default service found.');
            }

            $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)->whereDate('date', today());
            })->get();

            foreach ($absentMembers as $member) {
                // Send via WhatsApp if requested
                if ($request->input('via') === 'whatsapp') {
                    $this->whatsappService->sendMessage($member->mobile_number, $request->sms_message);
                } else {
                    $this->twilioSMSService->twiliosendSms($member->mobile_number, $request->sms_message);
                }
            }

            return redirect()->route('admin.attendance.absent')->with('success', 'Messages sent to absent members!');
        }

        return redirect()->back()->with('error', 'No valid data provided for SMS.');
    }

    public function followupReplies()
    {
        // Fetch all replies grouped by member
        $replies = SmsReply::with('member')->get();

        return view('admin.followup.index', compact('replies'));
    }

    public function sendFollowUp(Request $request, $id)
    {
        $request->validate([
            'followup_message' => 'required|string|max:160',
        ]);

        $reply = SmsReply::findOrFail($id);
        $member = $reply->member;

        $replies = DB::table('sms_replies')->orderBy('created_at', 'desc')->get();
        return response()->json($replies);

        return redirect()->route('admin.followup.index')->with('success', 'Follow-up SMS sent successfully!');
    }

    public function sendAbsentSMS(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:160',
        ]);

        $message = $request->input('message');

        // Fetch absent members
        $absentMembers = Member::whereDoesntHave('attendances', function ($query) {
            $query->whereDate('date', today());
        })->get();

        if ($absentMembers->isEmpty()) {
            return redirect()->back()->with('error', 'No absent members to send SMS to.');
        }

        foreach ($absentMembers as $member) {
            $this->sendSms($member->mobile_number, $message);
        }

        return redirect()->back()->with('success', 'SMS sent to all absent members successfully!');
    }

    public function newMembers()
    {
        // Fetch members created within the last month
        $newMembers = Member::where('created_at', '>=', now()->subMonth())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('admin.new-members', compact('newMembers'));
    }

    public function sendWelcomeMessage($id)
    {
        $member = Member::findOrFail($id);
        $message = "Welcome, {$member->name}! We're glad you joined us. We encourage you to attend our next service. Here's a link: [Service Details]";
        // Replace [Service Details] with actual service information or link.

        // Assuming you have a WhatsApp API or similar service integrated. If not, you might need to set this up.
        // Here's a placeholder for sending a message via WhatsApp:
        $whatsappUrl = "https://wa.me/{$member->mobile_number}?text=" . urlencode($message);

        // Log or store this action if necessary
        Log::info("Welcome message sent to member {$member->name}");

        // Redirect back with a message or open WhatsApp in a new tab
        return redirect()->back()->with('success', 'Welcome message sent to ' . $member->name . ' via WhatsApp.');
    }

    public function showInquiries()
    {
        $inquiries = Inquiry::latest()->get();

        return view('admin.inquiries', compact('inquiries'));
    }

    public function replyInquiry(Request $request, Inquiry $inquiry)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $inquiry->reply()->create([
            'reply' => $request->input('reply'),
        ]);

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }

    public function deleteInquiry($id)
    {
        $inquiry = Inquiry::findOrFail($id); // Fetch the inquiry
        $inquiry->delete(); // Delete the inquiry

        return redirect()->back()->with('success', 'Inquiry deleted successfully.');
    }

    public function generateWeeklyReport()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($startOfWeek, $endOfWeek) {
            $query->whereBetween('attendance_date', [$startOfWeek, $endOfWeek]);
        })->get();

        return response()->json($absentMembers);
    }

    public function generateMonthlyReport()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('attendance_date', [$startOfMonth, $endOfMonth]);
        })->get();

        return response()->json($absentMembers);
    }

    // Reporting & Analytics methods

    public function attendanceTrends(Request $request)
    {
        // Example: Weekly attendance trends
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $attendanceData = Attendance::selectRaw('date, count(*) as count')
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.attendance-trends', compact('attendanceData', 'startDate', 'endDate'));
    }

    public function demographicReports(Request $request)
    {
        // Example: Age group distribution
        $ageGroups = [
            'Under 18' => 0,
            '18-25' => 0,
            '26-35' => 0,
            '36-50' => 0,
            '51+' => 0,
        ];

        $members = Member::all();

        foreach ($members as $member) {
            $age = $member->age ?? 0;
            if ($age < 18) {
                $ageGroups['Under 18']++;
            } elseif ($age <= 25) {
                $ageGroups['18-25']++;
            } elseif ($age <= 35) {
                $ageGroups['26-35']++;
            } elseif ($age <= 50) {
                $ageGroups['36-50']++;
            } else {
                $ageGroups['51+']++;
            }
        }

        // Gender ratio
        $genderCounts = [
            'Male' => Member::where('gender', 'male')->count(),
            'Female' => Member::where('gender', 'female')->count(),
        ];

        return view('admin.reports.demographics', compact('ageGroups', 'genderCounts'));
    }

    public function growthMetrics(Request $request)
    {
        // Example: New vs returning visitors (members)
        $newMembers = Member::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $totalMembers = Member::count();
        $returningMembers = $totalMembers - $newMembers;

        return view('admin.reports.growth-metrics', compact('newMembers', 'returningMembers', 'totalMembers'));
    }

    public function exportReport(Request $request)
    {
        $format = $request->query('format', 'csv'); // default to csv

        // Example data to export - you can customize this to export actual report data
        $data = Member::select('id', 'name', 'gender', 'age', 'created_at')->get()->toArray();

        if ($format === 'excel') {
            $fileName = 'members_report_' . now()->format('Ymd_His') . '.xlsx';
            return Excel::download(new \App\Exports\ArrayExport($data), $fileName);
        } elseif ($format === 'pdf') {
            $pdf = PDF::loadView('admin.reports.export-pdf', ['data' => $data]);
            return $pdf->download('members_report_' . now()->format('Ymd_His') . '.pdf');
        } else {
            // CSV export
            $fileName = 'members_report_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$fileName\"",
            ];

            $callback = function () use ($data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, array_keys($data[0] ?? []));
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }
}
// </create_file>
