<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }
}