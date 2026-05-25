<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Message;
use App\Models\User;

class MessageReceivedNotification extends Notification
{
    use Queueable;

    public $message;
    public $sender;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message, User $sender)
    {
        $this->message = $message;
        $this->sender = $sender;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        $content = $this->message->content;
        if (empty($content) && !empty($this->message->image)) {
            $content = 'Sent an image';
        }

        // Truncate message if too long
        if (strlen($content) > 50) {
            $content = substr($content, 0, 47) . '...';
        }

        return [
            'message' => "New message from {$this->sender->name}: \"{$content}\"",
            'url' => url('/chat/' . $this->sender->id),
            'sender_id' => $this->sender->id,
            'message_id' => $this->message->id,
        ];
    }
}
