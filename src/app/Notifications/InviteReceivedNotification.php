<?php

namespace App\Notifications;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InviteReceivedNotification extends Notification
{
    use Queueable;

    private $invite;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
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
            'title' => 'New channel invite',
            'message' => "{$this->invite->inviter->name} invited you to join the channel: {$this->invite->channel->name}.",
            'avatar' => $this->invite->inviter->profile_photo_url
        ];
    }
}
