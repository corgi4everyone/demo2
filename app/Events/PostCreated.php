<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $user_id;
    public $course_id;
    public $title;
    public $content;
    public $created_at;
    public $comments;

    /**
     * Create a new event instance.
     */
    public function __construct($post)
    {
        //
        $this->id = $post->id;
        $this->user_id = $post->user_id;
        $this->course_id = $post->course_id;
        $this->title = $post->title;
        $this->content = $post->content;
        $this->comments = $post->comments? $post->comments->toArray() : [];
        $this->created_at = $post->created_at;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('posts'),
        ];
    }
}
