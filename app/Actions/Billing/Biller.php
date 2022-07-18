<?php
namespace App\Actions\Billing;

use App\Models\Tenancy;

class Biller
{   
    private $tenancy;
    private $reading;
    private $apartment;

    private $unitRate;
    private $flatRate;
    private $flatRateLimit;

    public $consumption;
    public $previousMeterReading;

    public function __construct(Tenancy $tenancy, $reading)
    {
        $this->tenancy = $tenancy;
        $this->reading = $reading;

        $this->initialise();
    }

    private function initialise () 
    {
        $this->apartment = $this->tenancy->house->apartment;
        $this->previousMeterReading = $this->tenancy->readings()->latest()->first();
        $this->consumption = $this->reading - $this->previousMeterReading->current_units;

        $this->unitRate = $this->apartment->unit_rate;
        $this->flatRate = $this->apartment->flat_rate;
        $this->flatRateLimit = $this->apartment->flat_rate_limit;
    }

    public function calculate ()
    {
        $doUnitCharge = $this->consumption > $this->flatRateLimit;
        
        return [
            'flat_rate' => "$this->flatRate if consumption <= $this->flatRateLimit",
            'unit_rate' => "@$this->unitRate if consumption > $this->flatRateLimit",
            'flat_charge' => $doUnitCharge ? 0 : $this->flatRate,
            'unit_charge' => !$doUnitCharge ? 0 : "$this->consumption units @$this->unitRate",   
            'total_charge' => $doUnitCharge ? number_format($this->consumption * $this->unitRate, 2) : $this->flatRate,
        ];
    }
}