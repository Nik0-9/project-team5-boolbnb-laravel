<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Apartment extends Model
{
    use HasFactory;

    protected $guarded = ['visible'];

    public static function generateSlug($name){
        $slug = Str::slug($name, '-');
        $count = 1;
        while(Apartment::where('slug', $slug )->first()) {
            $slug= Str::slug($name) . '-' . $count;
            $count++;
        }
        return $slug;
    }

}



