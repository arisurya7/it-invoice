<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodePos extends Model
{
    public function customer(){
        return $this->hasMany('App\Models\Customer','id');
    }

    public function provinsi(){
        return $this->belongsTo('App\Models\Provinsi','provinsi_id');
    }

    public function kota(){
        return $this->belongsTo('App\Models\Kota','kota_id');
    }

    public function kecamatan(){
        return $this->belongsTo('App\Models\kecamatan','kecamatan_id');
    }

    public function desa(){
        return $this->belongsTo('App\Models\Desa','desa_id');
    }
}
