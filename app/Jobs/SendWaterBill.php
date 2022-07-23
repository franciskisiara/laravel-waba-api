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
use Illuminate\Support\Facades\Log;

class SendWaterBill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The meter reading instance.
     *
     * @var \App\Models\MeterReading
     */
    private $meterReading;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MeterReading $meterReading)
    {
        $this->meterReading = $meterReading;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bill = json_decode($this->meterReading->bill);
        $message = "Water bill kshs $bill->total_charge";

        $notification = (new AT)->send([
            'to' => $this->reading->tenancy->tenant->phone,
            'message' => $message,
        ]);

        $messageId = $notification['data']->SMSMessageData->Recipients[0]->messageId;

        Log::info(json_encode($notification));

        $this->meterReading->update([
            'bill_delivery_id' => $messageId,
            'bill_description' => $message,
        ]);
    }
}
