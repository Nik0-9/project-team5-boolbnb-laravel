<?php

namespace App\Models;
use App\Models\Apartment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function apartments(){
        return $this->belongsToMany(Apartment::class)->withTimestamps();
    }
}
