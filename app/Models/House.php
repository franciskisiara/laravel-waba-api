<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_number', 'apartment_id'
    ];

    /**
     * Relationship between a house and an apartment
     */
    public function apartment () 
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

    /**
     * Relationship between a house and the tenant
     */
    public function tenants () 
    {
        return $this->belongsToMany(User::class, 'tenants', 'user_id', 'house_id');
    }

    /**
     * Relationship between a house and the meter readings
     */
    public function readings ()
    {
        return $this->hasMany(MeterReading::class, 'house_id');
    }
}
