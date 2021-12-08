<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function kodepos(){
        return $this->belongsTo('App\Models\KodePos','id_kodepos');
    }
}
