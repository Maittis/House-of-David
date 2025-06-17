<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $presentToday = Member::whereDate('last_attendance', now()->toDateString())->count();
        $absentMembers = $totalMembers - $presentToday;
        $newMembers = Member::whereMonth('created_at', now()->month)->count();
        $members = Member::latest()->paginate(10);

        return view('dashboard', compact('totalMembers', 'presentToday', 'absentMembers', 'newMembers', 'members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        Member::create($request->all());

        return redirect()->route('dashboard')->with('status', 'Member added successfully.');
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);

        $member->update($request->all());

        return redirect()->route('dashboard')->with('status', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('dashboard')->with('status', 'Member deleted successfully.');
    }
}
