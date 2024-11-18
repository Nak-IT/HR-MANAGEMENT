<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestoreCompletedNotification extends Notification
{
    use Queueable;

    protected $statusMessage;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($statusMessage)
    {
        $this->statusMessage = $statusMessage;
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
        return (new MailMessage)
                    ->subject('Restore Completed Successfully')
                    ->line('ដំណើរការ restoreបានបញ្ចប់ដោយជោគជ័យ។')
                    ->line('ព័ត៌មានលម្អិត៖ ' . $this->statusMessage)
                    ->line('សូមអរគុណសម្រាប់ការប្រើប្រាស់កម្មវិធីនេះដើម្បីrestore!')
                    ->salutation('សូមគោរពជូន,')  // Custom salutation in Khmer
                    ->line('From HR Management Application'); // Custom footer message
    }
}
