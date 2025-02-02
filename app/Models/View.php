<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Apartment;

class View extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
