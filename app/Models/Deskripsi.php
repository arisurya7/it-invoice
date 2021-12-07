<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deskripsi extends Model
{
    //
    public function invoice(){
        return $this->belongsTo('App\Models\Invoice');
    }
}
