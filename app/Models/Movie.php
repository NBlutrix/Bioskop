<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    
        protected $fillable = [
        'title',
        'description',
        'poster',
        'release_date'
    ];

        public function genres() { return $this->belongsToMany(Genre::class); }
        public function ratings() { return $this->hasMany(Rating::class); }
        public function comments() { return $this->hasMany(Comment::class); }
}


