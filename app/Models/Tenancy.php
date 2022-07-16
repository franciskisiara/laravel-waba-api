<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'house_id',
        'tenant_id',
    ];

    /**
     * Relationship between the tenancy and the house
     */
    public function house ()
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    /**
     * Relationship between the tenancy and the tenant/user
     */
    public function tenant ()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Relationship between the tenancy and the meter readings
     */
    public function readings ()
    {
        return $this->hasMany(MeterReading::class, 'tenancy_id');
    }
}
