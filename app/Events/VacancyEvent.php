<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VacancyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $company;
    /**
     * @var string
     */
    public $description;

    /**
     * Create a new event instance.
     *
     * @param string $name
     * @param string $company
     * @param string $description
     */
    public function __construct(string $name, string $company, string $description)
    {
        $this->name = $name;
        $this->company = $company;
        $this->description = $description;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
