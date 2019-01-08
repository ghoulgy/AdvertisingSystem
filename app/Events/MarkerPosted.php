<?php

namespace App\Events;

use App\Marker;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MarkerPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Marker
     *
     * @var Marker
     */
    public $marker;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($marker)
    {
        $this->marker = $marker;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new channel('markers');
    }

    public function broadcastAs() {
        return 'MarkersUpdate';
    }

    public function broadcastWith() {
        return [
          'lng' => $this->marker->lng,
          'lat' => $this->marker->lat,
          'type' => $this->marker->type,
          'description' => $this->marker->description,
          'title' => $this->marker->title,
          'user_id' => $this->marker->user_id
        ];
  }
}
