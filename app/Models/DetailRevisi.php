<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRevisi extends Model
{
    public function revisi(){
        return $this->belongsTo('App\Models\Revisi','revisi_id');
    }
}
