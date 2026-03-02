<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    protected $user;
    protected $data;

    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    /*
     * Insert to notification table data column
     */
    public function toDatabase($notifiable)
    {
        return $this->data;
    }

    /*
     * Broadcasted to broadcast driver
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'user_id' => $this->user->id,
            'message' => 'A new post has been created.',
            'data' => $this->data,
        ]);
    }
    
    public function broadcastAs()
    {
        return 'PostNotification';
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->user->id),
        ];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'message' => 'A new post has been created.',
            'post_data' => $this->data,
        ];
    }

    /*
     * Mailed to mail driver
     */
    
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Post Notification')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new post has been created on the platform.')
            ->action('View Post', $this->data['link'] ?? '')
            ->line('Thank you for staying with us!');
    }
}
