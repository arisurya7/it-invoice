<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    public function kodepos(){
        return $this->hasMany('App\Models\KodePos');
    }

    public function kecamatan(){
        return $this->hasMany('App\Models\Kecamatan');
    }

    public function customer(){
        return $this->hasMany('App\Models\Customer');
    }

    public function provinsi(){
        return $this->belongsTo('App\Models\Provinsi');
    }

}
