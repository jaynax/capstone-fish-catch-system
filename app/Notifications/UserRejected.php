<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRejected extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The rejection reason, if any.
     *
     * @var string|null
     */
    public $reason;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\User  $user
     * @param  string|null  $reason
     * @return void
     */
    public function __construct($user, $reason = null)
    {
        $this->user = $user;
        $this->reason = $reason;
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
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Your Account Application Has Been Reviewed')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('We regret to inform you that your account application has been reviewed and we are unable to approve it at this time.');

        if ($this->reason) {
            $mail->line('**Reason for rejection:** ' . $this->reason);
        }

        $mail->line('If you believe this is a mistake or would like to appeal this decision, please contact our support team.') 
             ->line('Thank you for your interest in our platform.');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'message' => 'Your account has been rejected.',
            'reason' => $this->reason,
        ];
    }
}
