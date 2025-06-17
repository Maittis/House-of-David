<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AbsentMemberNotification extends Notification
{
    use Queueable;

    protected $absentMembers;

    /**
     * Create a new notification instance.
     *
     * @param  \Illuminate\Support\Collection  $absentMembers
     * @return void
     */
    public function __construct($absentMembers)
    {
        $this->absentMembers = $absentMembers;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $count = $this->absentMembers->count();

        $mailMessage = (new MailMessage)
            ->subject('Absent Members Alert')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("There are currently {$count} members absent from today's service.")
            ->line('List of absent members:');

        foreach ($this->absentMembers as $member) {
            $mailMessage->line("- {$member->name} (Phone: {$member->mobile_number})");
        }

        $mailMessage->line('Please follow up with them accordingly.')
                    ->line('Thank you for your leadership!');

        return $mailMessage;
    }
}
