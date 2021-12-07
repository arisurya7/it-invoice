<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revisi extends Model
{
    public function deskripsi(){
        return $this->hasMany('App\Models\DetailRevisi');
    }
}
