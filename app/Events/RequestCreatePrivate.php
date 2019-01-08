<?php

namespace App\Events;

use App\UserRequest;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RequestCreatePrivate implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('Api.User.' . $this->request->sender->id),
            new PrivateChannel('Api.User.' . $this->request->receiver->id),
        ];
    }
}
