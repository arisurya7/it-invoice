<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    public function kodepos(){
        return $this->hasMany('App\Models\KodePos');
    }

    public function kota(){
        return $this->hasMany('App\Models\Kota');
    }

    public function customer(){
        return $this->hasMany('App\Models\Customer');
    }
}
