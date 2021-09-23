<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialProperty extends Model
{
    use HasFactory;
    protected $fillable = ['street', 'city', 'square_footage', 'price', 'rooms_number', 'parking_spaces', 'category', 'user_id', 'info', 'name',];



    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function fileUploads()
    {
        return $this->hasMany(Fileupload::class);
    }
}
