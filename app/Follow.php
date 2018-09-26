<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function folowee_user()
    {
        return $this->belongsTo('App\User', 'folowee_id');
    }

    public function folower_user()
    {
        return $this->belongsTo('App\User', 'folower_id');
    }
}
