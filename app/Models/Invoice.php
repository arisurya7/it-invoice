<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function deskripsi(){
        return $this->hasMany('App\Models\Deskripsi');
    }

    public function revisiCount($id){
        $count = Revisi::where('invoice_id', $id)->count();
        return $count;
    }

    public function project(){
        return $this->belongsTo('App\Models\Project');
    }

    public function scopeFilter($query, array $filters){
        $query->when($filters['filter_project'] ?? false, function($query, $project){
            return $query->where('project_id', '=', $project);          
        });

        $query->when($filters['filter_status'] ?? false, function($query, $status){
            return $query->where('status', '=', $status);       
        });

        $query->when($filters['filter_begin_date'] ?? false, function($query, $begin_date){
            return $query->where('tanggal', '>=', $begin_date);       
        });

        $query->when($filters['filter_last_date'] ?? false, function($query, $last_date){
            return $query->where('tanggal', '<=', $last_date);       
        });
    }
}
