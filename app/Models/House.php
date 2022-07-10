<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_number', 'apartment_id', 'tenant_id',
    ];

    /**
     * Relationship between a house and an apartment
     */
    public function apartment () 
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

    /**
     * Relationship between a house and the current tenant
     */
    public function tenant () 
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Relationship between a house and the tenancies
     */
    public function tenancies () 
    {
        return $this->hasMany(Tenancy::class, 'house_id');
    }
}
