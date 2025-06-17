<?php

namespace App\Jobs;

use App\Models\Member;
use App\Models\Attendance;
use App\Services\TwilioSMSService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendAbsentMemberWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $twilioSMSService;

    public function __construct(TwilioSMSService $twilioSMSService)
    {
        $this->twilioSMSService = $twilioSMSService;
    }

    public function handle()
    {
        $twoWeeksAgo = Carbon::now()->subWeeks(2)->startOfDay();

        // Find members who have not attended any service since two weeks ago
        $absentMembers = Member::whereDoesntHave('attendances', function ($query) use ($twoWeeksAgo) {
            $query->where('date', '>=', $twoWeeksAgo);
        })->get();

        foreach ($absentMembers as $member) {
            $message = "Dear {$member->name}, we noticed you have been absent for two weeks. We miss you at our services! Please let us know if you need any assistance.";

            // Send WhatsApp message via Twilio (assuming TwilioSMSService supports WhatsApp)
            $this->twilioSMSService->sendWhatsAppMessage($member->mobile_number, $message);
        }
    }
}
