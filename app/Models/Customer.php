<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function provinsi(){
        return $this->belongsTo('App\Models\Provinsi','id_provinsi');
    }

    public function kota(){
        return $this->belongsTo('App\Models\Kota','id_kota');
    }

    public function kecamatan(){
        return $this->belongsTo('App\Models\Kecamatan','id_kecamatan');
    }

    public function project(){
        return $this->hasMany('App\Models\Project','id');
    }
}
