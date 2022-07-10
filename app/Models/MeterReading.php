<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenancy_id',
        'previous_units',
        'current_units',
        'communicated_at',
    ];

    /**
     * Relationship between the meter reading and the tenancy
     */
    public function tenancy ()
    {
        return $this->belongsTo(Tenancy::class, 'tenancy_id');
    }
}
