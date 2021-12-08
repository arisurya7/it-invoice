<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    public function invoice(){
        return $this->hasMany('App\Models\Invoice');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer','customer_id');
    }
}
