<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'house_id',
        'user_id',
    ];

    /**
     * Relationship between the tenant and the house
     */
    public function house ()
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    /**
     * Relationship between the tenant and the client/user
     */
    public function user ()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship between the tenant and the meter readings
     */
    public function readings ()
    {
        return $this->hasMany(MeterReading::class, 'tenant_id');
    }
}
