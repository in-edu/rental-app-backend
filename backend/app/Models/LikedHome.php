<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikedHome extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'home_id'];



    public function user()
    {
        return $this->hasMany(User::class);
    }
}