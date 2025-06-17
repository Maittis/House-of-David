<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationReceipt extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $donation;

    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $currencySymbols = [
            'ZMW' => 'ZK',
            'USD' => '$',
        ];

        $currencySymbol = $currencySymbols[$this->donation->currency] ?? '';

        return (new MailMessage)
                    ->subject('Donation Receipt')
                    ->greeting('Thank you for your donation!')
                    ->line('Receipt Number: ' . $this->donation->receipt_number)
                    ->line('Amount: ' . $currencySymbol . number_format($this->donation->amount, 2))
                    ->line('Donation Type: ' . ucfirst($this->donation->type))
                    ->line('Payment Method: ' . ucfirst($this->donation->payment_method))
                    ->line('Status: ' . ucfirst($this->donation->status))
                    ->line('Date: ' . $this->donation->created_at->format('F j, Y'))
                    ->line('Thank you for supporting our ministry!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
