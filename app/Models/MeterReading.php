<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenancy_id',
        'previous_units',
        'current_units',
        'consumed_units',
        'communication_status',
        'bill',
    ];

    /**
     * Interact with the meter readings communication status
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function communicationStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (is_null($value)) {
                    return 'pending';
                } else {
                    return (bool) $value ? 'delivered' : 'failed';
                }
            },
        );
    }

    /**
     * Relationship between the meter reading and the tenancy
     */
    public function tenancy ()
    {
        return $this->belongsTo(Tenancy::class, 'tenancy_id');
    }
}
