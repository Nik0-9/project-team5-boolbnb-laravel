<?php

namespace App\Models;
use App\Models\Apartment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function apartments(){
        return $this->belongsToMany(Apartment::class)
        ->withPivot('start_date', 'end_date', 'price')
        ->withTimestamps();
    }
}
