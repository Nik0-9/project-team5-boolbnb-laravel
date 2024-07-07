<?php

namespace App\Models;
use App\Models\Apartment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['name','surname','email','body','apartment_id'];
    
    public function apartment(){
        return $this->belongsTo(Apartment::class);
    } 
}

