<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommentBroadCast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;
    public $message;
    public $username;
    public $userPic;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $room, $userName, $userPic)
    {
        $this->message = $message;
        $this->room = $room;
        $this->userPic = $userPic;
        $this->username = $userName;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('liveComments.'. $this->room);
    }

}
