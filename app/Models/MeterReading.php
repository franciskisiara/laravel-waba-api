<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'initial_reading',
        'current_reading',
        'communicated_at',
    ];

    /**
     * Relationship between the meter reading and the tenant
     */
    public function tenant ()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
