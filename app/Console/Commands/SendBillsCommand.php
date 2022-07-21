<?php

namespace App\Console\Commands;

use App\Library\SMS\AT;
use App\Models\MeterReading;
use Illuminate\Console\Command;

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
            ->whereNull('communication_status')
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth(),
            ])
            ->with(['tenancy.tenant'])
            ->chunk(10, function ($readings) use(&$invoices) {
                foreach ($readings as $reading) {
                    $bill = json_decode($reading->bill);
                    
                    $result = (new AT)->send([
                        'to' => $reading->tenancy->tenant->phone,
                        'message' => "Water bill kshs $bill->total_charge",
                    ]);

                    dd($result);
                }
            });

        
    }
}
