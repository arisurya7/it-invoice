<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    public function kodepos(){
        return $this->hasMany('App\Models\KodePos');
    }

    public function kecamatan(){
        return $this->belongsTo('App\Models\Kecamatan');
    }
}
