<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegistered extends Notification implements ShouldQueue
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
    public function __construct(User $user)
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
        $adminUrl = url('/admin/users');
        
        return (new MailMessage)
            ->subject('New User Registration - Action Required')
            ->greeting('Hello Admin,')
            ->line('A new user has registered on the system and is awaiting your approval.')
            ->line('**User Details:**')
            ->line('- **Name:** ' . $this->user->name)
            ->line('- **Email:** ' . $this->user->email)
            ->line('- **Registration Date:** ' . $this->user->created_at->format('F j, Y \a\t g:i a'))
            ->action('Review User', url($adminUrl . '/' . $this->user->id))
            ->line('Please log in to the admin panel to approve or reject this user.');
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
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
        ];
    }
}
