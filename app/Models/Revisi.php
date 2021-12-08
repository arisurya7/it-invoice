<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    public function detailrevisi(){
        return $this->hasMany('App\Models\DetailRevisi','id');
    }

    public function invoice(){
        return $this->belongsTo('App\Models\Invoice','invoice_id');
    }
}
