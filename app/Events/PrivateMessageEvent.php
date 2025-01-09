<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PrivateMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiverId;

    public function __construct($message, $receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('private-chat.' . $this->receiverId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'path_file' => $this->message->path_file,
            'image_path' => $this->message->image_path,
        ];
    }
}
