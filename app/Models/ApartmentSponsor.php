<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentSponsor extends Model
{
    use HasFactory;
    protected $table='apartment_sponsor';
    protected $fillable = ['start_date','end_date','price', 'name', 'apartment_id', 'sponsor_id'];
    public function apartments()
    {
        return $this->belongsTo(Apartment::class);
    }
    
    public function sponsors()
    {
        return $this->belongsTo(Sponsor::class);
    }
    
}
