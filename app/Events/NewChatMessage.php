<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Broadcast to general live-chat channel AND specific live room channel
        $channels = [
            new Channel('live-chat'), // For admin viewing all chats
        ];
        
        // If message belongs to a specific live room, also broadcast to that room's channel
        if ($this->chatMessage->live_setting_id) {
            $channels[] = new Channel('live-chat.' . $this->chatMessage->live_setting_id);
        }
        
        return $channels;
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new-message';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->chatMessage->id,
            'username' => $this->chatMessage->username,
            'message' => $this->chatMessage->message,
            'live_setting_id' => $this->chatMessage->live_setting_id,
            'sent_at' => $this->chatMessage->sent_at->toISOString(),
            'created_at' => $this->chatMessage->created_at->toISOString(),
        ];
    }
}
