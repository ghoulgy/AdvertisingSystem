<?php

namespace App\Events;

use App\MarkerDemand;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MarkerDemandPosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /**
     * Marker
     *
     * @var MarkerDemand
     */
    public $markerdemand;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($markerdemand)
    {
        $this->markerdemand = $markerdemand;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new channel('markersDemand');
    }

    public function broadcastAs() {
        return 'MarkersDemandUpdate';
    }

    public function broadcastWith() {
        return [
          'lng' => $this->markerdemand->lng,
          'lat' => $this->markerdemand->lat,
          'title' => $this->markerdemand->title,
          'type' => $this->markerdemand->type,
          'need' => $this->markerdemand->need,
          'description' => $this->markerdemand->description,
          'user_id' => $this->markerdemand->user_id
        ];
  }
}
