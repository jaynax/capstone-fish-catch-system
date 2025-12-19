<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserApproved extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $loginUrl = url('/login');
        
        return (new MailMessage)
            ->subject('Your Account Has Been Approved')
            ->greeting('Hello ' . $this->user->name . ',')
            ->line('We are pleased to inform you that your account has been approved by the administrator.')
            ->line('You can now log in to your account and access all the features of our platform.')
            ->action('Log In', $loginUrl)
            ->line('If you have any questions or need assistance, please contact our support team.')
            ->line('Thank you for joining us!');
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
            'message' => 'Your account has been approved.',
        ];
    }
}
