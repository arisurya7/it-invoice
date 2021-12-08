<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    public function kodepos(){
        return $this->hasMany('App\Models\KodePos');
    }

    public function desa(){
        return $this->hasMany('App\Models\Desa');
    }

    public function kota(){
        return $this->belongsTo('App\Models\Kota');
    }
}
