<?php

namespace App\Jobs;

use App\Models\MeterReading;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTenant implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The podcast instance.
     *
     * @var \App\Models\MeterReading
     */
    public $reading;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MeterReading $reading)
    {
        $this->reading = $reading;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apartment = $this->reading->tenant->house->apartment;

        $initial = $this->reading->initial_reading;
        $current = $this->reading->current_reading;

        $units = $current - $initial;

        dd($apartment);
        // $apartment = $this->reading->tenant->house->apartment;
    }
}
