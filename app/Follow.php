<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function followee_user()
    {
        return $this->belongsTo('App\User', 'followee_id');
    }

    public function follower_user()
    {
        return $this->belongsTo('App\User', 'follower_id');
    }
}
