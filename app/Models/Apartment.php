<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'caretaker_id',
        'flat_rate_limit',
        'flat_rate',
        'unit_rate',
    ];

    /**
     * Relationship between the apartment and the caretaker
     */
    public function caretaker () 
    {
        return $this->belongsTo(User::class, 'caretaker_id');
    }
}
