<?php

namespace App\Models;
use App\Models\Apartment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'apartment_id',
        'email',
        'name',
        'surname',
        'body'
    ];
    
    public function apartment(){
        return $this->belongsTo(Apartment::class);
    } 
}

