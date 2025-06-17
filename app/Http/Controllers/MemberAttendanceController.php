<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Attendance;
use Carbon\Carbon;

class MemberAttendanceController extends Controller
{
    /**
     * Mark attendance for the authenticated member.
     * Requires location to be enabled on client side.
     */
    public function markAttendance(Request $request)
    {
        $user = Auth::user();

        // Check if user is linked to a member record
        $member = Member::where('mobile_number', $user->phone ?? $user->mobile_number ?? null)->first();

        if (!$member) {
            return response()->json(['error' => 'You are not registered as a member.'], 403);
        }

        // Check if attendance already marked today
        $today = Carbon::today()->toDateString();
        $existingAttendance = Attendance::where('member_id', $member->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'Attendance already marked for today.'], 200);
        }

        // Save attendance record
        Attendance::create([
            'member_id' => $member->id,
            'date' => $today,
        ]);

        // Update last_attendance on member
        $member->last_attendance = $today;
        $member->save();

        return response()->json(['message' => 'Attendance marked successfully.'], 200);
    }
}
