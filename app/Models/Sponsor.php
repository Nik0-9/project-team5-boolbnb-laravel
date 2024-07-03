<?php

namespace App\Models;
use App\Models\Apartment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = ['name','price','duration'];

    public function apartments(){
        return $this->belongsToMany(Apartment::class, 'apartment_sponsor')
        ->withPivot('star_date','end_date','apartment_id','sponsor_id');
    }
}
