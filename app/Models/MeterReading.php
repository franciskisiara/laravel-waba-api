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
        'bill',
        'bill_description',
        'bill_delivery_id',
        'bill_delivery_status',
    ];

    /**
     * Relationship between the meter reading and the tenancy
     */
    public function tenancy ()
    {
        return $this->belongsTo(Tenancy::class, 'tenancy_id');
    }
}
