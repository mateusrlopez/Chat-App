<?php

namespace App\Notifications;

use App\Models\FriendshipRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FriendshipRequestReceivedNotification extends Notification
{
    use Queueable;

    private $friendshipRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(FriendshipRequest $friendshipRequest)
    {
        $this->friendshipRequest = $friendshipRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New friend request',
            'message' => "You have received a new friend request by: {$this->friendshiRequest->sender->name}",
            'avatar' => $this->friendshipRequest->sender->profile_photo_url
        ];
    }
}
