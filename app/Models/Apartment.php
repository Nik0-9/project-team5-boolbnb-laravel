<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\View;
use App\Models\Message;
use App\Models\Image;
use App\models\Service;
use App\Models\Sponsor;
use Illuminate\Database\Eloquent\SoftDeletes;


class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['services'];

    public static function generateSlug($name)
    {
        $slug = Str::slug($name, '-');
        $count = 1;
    
        do {
            $newSlug = ($count > 1) ? "{$slug}-{$count}" : $slug;
            $existingSlug = Apartment::withTrashed()->where('slug', $newSlug)->exists();
            $count++;
        } while ($existingSlug);
    
        return $newSlug;
    }
    


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function images(){
        return $this->hasMany(Image::class);
    }
    public function services(){
        return $this->belongsToMany(Service::class)->withTimestamps();
    }

    public function sponsors(){
        return $this->belongsToMany(Sponsor::class)
        ->withPivot('start_date', 'end_date', 'price', 'name')
        ->withTimestamps();
    }

}



