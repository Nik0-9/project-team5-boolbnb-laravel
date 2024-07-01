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


class Apartment extends Model
{
    use HasFactory;

    protected $guarded = ['street', 'street_number', 'city','cap'];

    public static function generateSlug($name)
    {
        $slug = Str::slug($name, '-');
        $count = 1;
        while (Apartment::where('slug', $slug)->first()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }
        return $slug;
    }

    public static function addressFormatted($address){
        $formatted = Str::slug(trim($address), '%20');
        return $formatted;
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
        return $this->belongsToMany(Sponsor::class)->withTimestamps();
    }

}



