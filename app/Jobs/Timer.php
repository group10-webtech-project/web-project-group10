<?php

namespace App\Jobs;

use App\Events\GameEnded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Timer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use Queueable;

    public $room;
    /**
     * Create a new job instance.
     */
    public function __construct($room)
    {
        $this->room = $room;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if($this->room->active)
        {
            $this->room->active = false;
            $this->room->save();
            GameEnded::dispatch($this->room);
        }

    }
}
