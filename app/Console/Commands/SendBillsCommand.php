<?php

namespace App\Console\Commands;

use App\Library\SMS\AT;
use App\Models\MeterReading;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendBillsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'waba:send-bills';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out water bills to tenants';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        MeterReading::whereNotNull('bill')
            ->where('bill_delivery_status', 'pending')
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->with(['tenancy.tenant'])
            ->chunk(10, function ($readings) use(&$invoices) {
                foreach ($readings as $reading) {
                    $bill = json_decode($reading->bill);
                    $message = "Water bill kshs $bill->total_charge";

                    $result = (new AT)->send([
                        'to' => $reading->tenancy->tenant->phone,
                        'message' => $message,
                    ]);

                    $messageId = $result['data']->SMSMessageData->Recipients[0]->messageId;

                    Log::info(json_encode($messageId));

                    $reading->update([
                        'bill_delivery_id' => $messageId,
                        'bill_description' => $message,
                    ]);
                }
            });
    }
}
