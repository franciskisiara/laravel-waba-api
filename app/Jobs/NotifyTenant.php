<?php

namespace App\Jobs;

use App\Library\SMS\AT;
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
        $currentUnits = $this->reading->current_units;
        $previousUnits = $this->reading->previous_units;

        $consumption = $currentUnits - $previousUnits;

        $house = $this->reading->tenancy->house;
        $tenantPhone = $house->tenant->phone;
        $apartment = $house->apartment;
        
        $bill = $consumption <= $apartment->flat_rate_limit
            ? $apartment->flat_rate
            : $consumption * $apartment->unit_rate;

        (new AT)->send([
            'to' => "+$tenantPhone",
            'message' => "Water bill ksh $bill"
        ]);
    }
}
