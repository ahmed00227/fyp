<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chat implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $chatId,$message,$sender;
    public function __construct($chatId,$message,$sender)
    {
        $this->chatId = $chatId;
        $this->message = $message;
        $this->sender = $sender;
    }

     public function broadcastOn()
     {
         return new Channel('Chat-'.$this->chatId);
     }

    public function broadcastAs()
    {
        return 'chat';
    }
}
