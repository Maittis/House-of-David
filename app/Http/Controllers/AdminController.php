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



class AdminController extends Controller
{

    use HasRoles;



    protected $twilioSMSService;

    public function __construct(TwilioSMSService $twilioSMSService)
    {
        $this->twilioSMSService = $twilioSMSService;
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






    // public function storeMember(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         // 'email' => 'required|string|email|max:255',
    //         'mobile_number' => 'required|unique:members,mobile_number'

    //     ]);

    //     Member::create($validatedData);

    //     return redirect()->route('admin.dashboard')->with('success', 'Member created successfully.');
    // }

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
            // 'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            // 'status' => 'required|in:active,inactive',
        ]);


        $member->update($validatedData);

        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    }

    // public function updateMember(Request $request, $id)
    // {
    //     $member = Member::findOrFail($id);

    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         // 'email' => 'required|email|unique:members,email,' . $member->id,
    //         'phone' => 'nullable|string|max:20',
    //         'address' => 'nullable|string',
    //         // 'status' => 'required|in:active,inactive',  // Uncomment and include this validation
    //     ]);

    //     // Explicitly set status to ensure it's always updated
    //     $member->update(array_merge($validatedData, ['status' => $request->input('status', 'active')]));

    //     return redirect()->route('admin.members.index')->with('success', 'Member updated successfully.');
    // }




    public function deleteMember(Member $member)
    {
        $member->delete();
        return redirect()->route('admin.members')->with('success', 'Member deleted successfully.');
    }




    // public function store(Request $request)
    // {
    //     $  $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         // 'email' => 'required|email|unique:members,email',
    //         'phone' => 'nullable|string|max:20',
    //         'address' => 'nullable|string',
    //     ]);

    //     // Mark attendance
    //     Attendance::create([
    //         'member_id' => $request->input('member_id'),
    //         'service_id' => $request->input('service_id'),
    //         'date' => now(),
    //     ]);

    //     // Update last attendance for the member
    //     $member = Member::find($request->input('member_id'));
    //     $member->last_attendance = now();
    //     $member->save();

    //     return redirect()->route('admin.attendance.index')->with('success', 'Attendance marked successfully.');
    // }

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
        // $members = Member::all();
        $members = Member::orderBy('name')->paginate(25);
        // Pass data to the view
        return view('admin.attendance.index', compact(
            'defaultService',
            'presentMembers',
            'absentMembers',
            'members'
        ));
    }



    // public function absentMembers()
    // {
    //     $defaultService = Service::first();

    //     // Fetch absent members for the default service with pagination (10 per page)
    //     $absentMembers = $defaultService
    //         ? Member::whereDoesntHave('attendances', function ($query) use ($defaultService) {
    //             $query->where('service_id', $defaultService->id)
    //                 ->whereDate('date', today());
    //         })->paginate(10) // Apply pagination
    //         : collect(); // If no service exists, return an empty collection

    //     return view('admin.attendance.absent', compact('defaultService', 'absentMembers'));
    // }


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
                $this->twilioSMSService->twiliosendSms($member->mobile_number, $request->sms_message);
            }

            return redirect()->route('admin.attendance.absent')->with('success', 'SMS sent to absent members!');
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

        // // Twilio SMS sending logic
        // $sid = env('TWILIO_SID');
        // $token = env('TWILIO_TOKEN');
        // $from = env('TWILIO_FROM');
        // $client = new \Twilio\Rest\Client($sid, $token);

        // try {
        //     $client->messages->create($member->mobile_number, [
        //         'from' => $from,
        //         'body' => $request->followup_message,
        //     ]);
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Failed to send follow-up SMS.');
        // }

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










// public function storeReply(Request $request)
// {
//     // Extract data from Twilio webhook
//     $data = $request->all();
//     $from = $data['From']; // Sender's phone number
//     $body = $data['Body']; // Message content

//     // Find the member by their mobile number
//     $member = Member::where('mobile_number', $from)->first();

//     if ($member) {
//         // Save the reply in the database
//         SmsReply::create([
//             'member_id' => $member->id,
//             'message' => $body,
//         ]);
//     }

//     // Return a response to Twilio
//     return response()->json(['status' => 'success']);
// }



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

// public function sendInspiration(Request $request)
// {
//     $request->validate([
//         'message' => 'required|string',
//     ]);

//     InspirationalMessage::create([
//         'content' => $request->message,
//     ]);

//     // Redirect back with a success message
//     return redirect()->back()->with('success', 'Message sent successfully!');
// }










}












