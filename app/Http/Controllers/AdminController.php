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

class AdminController extends Controller
{



    protected $twilioSMSService;

    // Inject the TwilioSMSService
    public function __construct(TwilioSMSService $twilioSMSService)
    {
        $this->twilioSMSService = $twilioSMSService;
    }



    public function dashboard()
    {
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
            'mobile_number' => 'required|unique:members,mobile_number'
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
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($validatedData);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }






    public function deleteMember(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members')->with('success', 'Member deleted successfully.');
    }





    // public function recordAttendance(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'member_id' => 'required|exists:members,id',
    //         'service_id' => 'required|exists:services,id',
    //         'date' => 'required|date',
    //     ]);

    //     // Check if the attendance for this member, service, and date already exists
    //     $existingAttendance = Attendance::where('member_id', $request->member_id)
    //         ->where('service_id', $request->service_id)
    //         ->whereDate('date', $request->date)
    //         ->first();

    //     if ($existingAttendance) {
    //         return redirect()->back()->with('error', 'Attendance already recorded for this member on this date.');
    //     }

    //     // Create the attendance record
    //     Attendance::create([
    //         'member_id' => $request->member_id,
    //         'service_id' => $request->service_id,
    //         'date' => $request->date,
    //     ]);

    //     return redirect()->back()->with('success', 'Attendance recorded successfully!');
    // }








    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'service_id' => 'required|exists:services,id',
        ]);

        // Mark attendance
        Attendance::create([
            'member_id' => $request->input('member_id'),
            'service_id' => $request->input('service_id'),
            'date' => now(),
        ]);

        // Update last attendance for the member
        $member = Member::find($request->input('member_id'));
        $member->last_attendance = now();
        $member->save();

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance marked successfully.');
    }










    // public function showAttendanceForm(Request $request)
    // {
    //     // Get the search term from the request, default to an empty string if not provided
    //     $search = $request->input('search', '');

    //     // Query members based on the search term
    //     $members = Member::where(function ($query) use ($search) {
    //         $query->where('name', 'LIKE', "%{$search}%")
    //               ->orWhere('mobile_number', 'LIKE', "%{$search}%");
    //     })->paginate(10);

    //     // Fetch all services for selection
    //     $services = Service::all();

    //     return view('admin.attendance.list', compact('services', 'members', 'search'));
    // }

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
        $members = Member::all();

        // Pass data to the view
        return view('admin.attendance.index', compact(
            'defaultService',
            'presentMembers',
            'absentMembers',
            'members'
        ));
    }












    public function absentMembers()
    {
        $defaultService = Service::first();

        // Fetch absent members for the default service
        $absentMembers = $defaultService
            ? Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
                $query->where('service_id', $defaultService->id)
                    ->whereDate('date', today());
            })->get()
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










// public function sendSms(Request $request)
// {
//     // Twilio configuration
//     $sid = env('TWILIO_SID');
//     $token = env('TWILIO_TOKEN');
//     $from = env('TWILIO_FROM');
//     $client = new Client($sid, $token);

//     if ($request->has('member_id')) {
//         // Send SMS to a specific member
//         $member = Member::findOrFail($request->input('member_id'));

//         // Default message for individual SMS
//         $message = "Dear {$member->name}, we noticed you missed today's service. We hope to see you soon!";

//         try {
//             // Send SMS
//             $client->messages->create($member->mobile_number, [
//                 'from' => $from,
//                 'body' => $message,
//             ]);
//             Log::info("SMS sent to {$member->mobile_number}: {$message}");
//         } catch (\Exception $e) {
//             Log::error("Failed to send SMS to {$member->mobile_number}: {$e->getMessage()}");
//             return redirect()->back()->with('error', 'Failed to send SMS to the member.');
//         }

//         return redirect()->route('admin.attendance.index')->with('success', 'SMS sent successfully to the member!');
//     } elseif ($request->has('sms_message')) {
//         // Send SMS to all absent members
//         $request->validate([
//             'sms_message' => 'required|string|max:160', // Validate custom message
//         ]);

//         $defaultService = Service::first();

//         if (!$defaultService) {
//             return redirect()->back()->with('error', 'No default service found to determine absent members.');
//         }

//         // Fetch absent members for the default service
//         $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
//             $query->where('service_id', $defaultService->id)
//                   ->whereDate('date', today());
//         })->get();

//         foreach ($absentMembers as $member) {
//             try {
//                 // Send SMS
//                 $client->messages->create($member->mobile_number, [
//                     'from' => $from,
//                     'body' => $request->sms_message,
//                 ]);
//                 Log::info("SMS sent to {$member->mobile_number}: {$request->sms_message}");
//             } catch (\Exception $e) {
//                 Log::error("Failed to send SMS to {$member->mobile_number}: {$e->getMessage()}");
//             }
//         }

//         return redirect()->route('admin.attendance.absent')->with('success', 'SMS sent successfully to all absent members!');
//     }

//     // If no valid input is provided, redirect back with an error
//     return redirect()->back()->with('error', 'No valid data provided for sending SMS.');
// }









// public function sendSms(Request $request)
// {
//     // Twilio credentials from the .env file
//     $sid = env('TWILIO_SID');
//     $token = env('TWILIO_TOKEN');
//     $from = env('TWILIO_FROM');
//     $client = new Client($sid, $token);

//     try {
//         // Test phone number and message
//         $to = '+260976652858'; // Replace with the recipient's phone number
//         $message = "Hello, this is a test message from Twilio.";

//         // Send SMS
//         $client->messages->create($to, [
//             'from' => $from,
//             'body' => $message,
//         ]);

//         // Log success
//         Log::info("Test SMS sent to {$to}: {$message}");

//         return response()->json(['success' => 'SMS sent successfully!']);
//     } catch (\Exception $e) {
//         // Log error
//         Log::error("Failed to send SMS: {$e->getMessage()}");

//         return response()->json(['error' => 'Failed to send SMS. Check the logs for more details.']);
//     }
// }






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

        // Twilio SMS sending logic
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $from = env('TWILIO_FROM');
        $client = new \Twilio\Rest\Client($sid, $token);

        try {
            $client->messages->create($member->mobile_number, [
                'from' => $from,
                'body' => $request->followup_message,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send follow-up SMS.');
        }

        return redirect()->route('admin.followup.index')->with('success', 'Follow-up SMS sent successfully!');
    }






// public function sendSMStoAbsentMembersForService(TwilioSMSService $twilioSMSService, Request $request, $serviceId)
// {
//     // Validate input
//     $request->validate([
//         'message' => 'required|string|max:160', // Limit to 160 characters
//         'members' => 'required|array',          // Ensure 'members' is an array
//     ]);

//     // Fetch selected members
//     $members = Member::whereIn('id', $request->members)->get();

//     if ($members->isEmpty()) {
//         return redirect()->route('admin.dashboard')->with('error', 'No members selected for SMS.');
//     }

//     $message = $request->message;

//     // Keep track of successes and failures
//     $successCount = 0;
//     $failureCount = 0;

//     foreach ($members as $member) {
//         try {
//             // Send SMS via TwilioSMSService
//             $twilioSMSService->sendSMS([$member->mobile_number], $message);
//             Log::info("SMS sent to {$member->mobile_number}");
//             $successCount++;
//         } catch (\Exception $e) {
//             Log::error("Failed to send SMS to {$member->mobile_number}: " . $e->getMessage());
//             $failureCount++;
//         }
//     }

//     // Check if there were any failures
//     if ($failureCount > 0) {
//         $message = "{$successCount} SMS sent successfully. {$failureCount} SMS failed to send.";
//         return redirect()->route('admin.dashboard')
//             ->with('success', $message)
//             ->with('error', 'Some SMS messages failed to send. Check logs for details.');
//     } else {
//         // Redirect back with a success message if all messages were sent successfully
//         return redirect()->route('admin.dashboard')
//             ->with('success', "{$successCount} SMS sent successfully.");
//     }
// }









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










public function storeReply(Request $request)
{
    // Extract data from Twilio webhook
    $data = $request->all();
    $from = $data['From']; // Sender's phone number
    $body = $data['Body']; // Message content

    // Find the member by their mobile number
    $member = Member::where('mobile_number', $from)->first();

    if ($member) {
        // Save the reply in the database
        SmsReply::create([
            'member_id' => $member->id,
            'message' => $body,
        ]);
    }

    // Return a response to Twilio
    return response()->json(['status' => 'success']);
}



// public function twiliosendSms($to, $message)
// {
//     try {
//         $sid = env('TWILIO_SID');
//         $token = env('TWILIO_TOKEN');
//         $from = env('TWILIO_FROM');

//         $client = new \Twilio\Rest\Client($sid, $token);

//         $client->messages->create($to, [
//             'from' => $from,
//             'body' => $message,
//         ]);

//         return true;
//     } catch (\Exception $e) {
//         Log::error('Error sending SMS to ' . $to . ': ' . $e->getMessage());
//         return false;
//     }
// }









}

