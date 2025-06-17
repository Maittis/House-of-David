<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Member;
use App\Notifications\DonationReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::with('member')->latest()->paginate(10);
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        $members = Member::orderBy('name')->get();
        return view('donations.create', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'nullable|exists:members,id',
            'guest_email' => 'nullable|email',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:ZMW,USD',
            'payment_method' => 'required|in:cash,qr,mobile,bank',
            'type' => 'required|in:donation,offering,tithe,project',
            'transaction_id' => 'nullable|string|unique:donations'
        ]);

        $donation = Donation::create([
            'receipt_number' => 'DON-' . Str::upper(Str::random(8)),
            'member_id' => $validated['member_id'] ?? null,
            'guest_email' => $validated['guest_email'] ?? null,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'payment_method' => $validated['payment_method'],
            'type' => $validated['type'],
            'transaction_id' => $validated['transaction_id'] ?? uniqid('txn_'),
            'status' => $validated['payment_method'] === 'cash' ? 'pending' : 'verified',
            'recorded_by' => auth()->id()
        ]);

        // Send receipt if payment is verified and member exists or guest email provided
        if ($donation->status === 'verified') {
            if ($donation->member) {
                $donation->member->notify(new DonationReceipt($donation));
            } elseif ($donation->guest_email) {
                \Notification::route('mail', $donation->guest_email)->notify(new DonationReceipt($donation));
            }
        }

        return redirect()->route('donations.index')->with('success', 'Donation recorded!');
    }

    public function show($id)
    {
        $donation = Donation::with('member', 'recorder')->findOrFail($id);
        return view('donations.show', compact('donation'));
    }

    public function weeklyReport()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $report = Donation::selectRaw('type, SUM(amount) as total_amount, COUNT(*) as count')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('type')
            ->get();

        $total = $report->sum('total_amount');

        $methods = Donation::selectRaw('payment_method, SUM(amount) as total')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('payment_method')
            ->get();

        return view('donations.weekly_report', compact(
            'report',
            'total',
            'methods',
            'startOfWeek',
            'endOfWeek'
        ));
    }

    public function monthlyReport()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $report = Donation::selectRaw('type, SUM(amount) as total_amount, COUNT(*) as count')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('type')
            ->get();

        $total = $report->sum('total_amount');

        $methods = Donation::selectRaw('payment_method, SUM(amount) as total')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('payment_method')
            ->get();

        return view('donations.monthly_report', compact(
            'report',
            'total',
            'methods',
            'startOfMonth',
            'endOfMonth'
        ));
    }

    public function verifyQrPayment(Request $request)
    {
        $request->validate(['transaction_id' => 'required|string']);

        $donation = Donation::where('transaction_id', $request->transaction_id)
            ->firstOrFail();

        $donation->update([
            'status' => 'verified',
            'verified_at' => now()
        ]);

        // Send receipt after verification
        $donation->member->notify(new DonationReceipt($donation));

        return response()->json(['success' => true]);
    }
}
