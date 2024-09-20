<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Car;
use App\Models\User;

class CarUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $car;
    /**
     * Create a new event instance.
     */
    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('cars.'.$this->car->user_id);
    }

    public function broadcastWith()
    {
        return [
            'car_id'=> $this->car->id,
            'car_name'=> $this->car->car_name,
            'car_model'=> $this->car->model,
        ];
    }
}
