<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class SentMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * Create a new event instance.
     */
    public function __construct(protected $message, protected User $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channel = [];
        if($this->user->role == 'administrator'){
            $channel[]= new PrivateChannel('chat.'. ($this->user->id));
        }
        \Log::info(json_encode($channel));

        return $channel;
    }

    public function broadcastAs(){
        return 'chat-app';
    }

    public function broadcastWith(){
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'role' => $this->user->role,
            'message'=> $this->message,  
        ];

    }
}