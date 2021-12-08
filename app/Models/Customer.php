<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function kodepos(){
        return $this->belongsTo('App\Models\KodePos','id_kodepos');
    }

    public function project(){
        return $this->hasMany('App\Models\Project','id');
    }
}
