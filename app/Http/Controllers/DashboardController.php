<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $invoice = Invoice::all();
        if($request->isMethod('POST')){
            if($request->filter_month){
                $invoice = $invoice->filter(function ($value) use ($request) { 
                    return substr($value->tanggal,5,2) == $request->filter_month; 
                });
            }
            if($request->filter_year){
                $invoice = $invoice->filter(function ($value) use ($request) { 
                    return substr($value->tanggal,0,4) == $request->filter_year; 
                });
            }
        }

        $data = [
            'isDashboard'=>'active',
            'countStatusFinal'=>$invoice->where('status','Final')->count(),
            'countStatusDraft'=>$invoice->where('status','Draft')->count(),
            'countStatusCancel'=>$invoice->where('status','Cancel')->count(),
            'invoice'=>$invoice
        ];
        return view('dashboard', $data);
    }

    public function showStatus(Request $request)
    {   
        
        $invoice = Invoice::all();
        if($request->month){
            $invoice = $invoice->filter(function ($value) use ($request) { 
                return substr($value->tanggal,5,2) == $request->month; 
            });
        }
        if($request->year){
            $invoice = $invoice->filter(function ($value) use ($request) { 
                return substr($value->tanggal,0,4) == $request->year; 
            });
        }

        if($request->status){
            $invoice = $invoice->filter(function ($value) use ($request) { 
                return $value->status == $request->status; 
            });
        }
        
        if ($invoice->isEmpty()){
            $data = [
                'status'=>404,
            ];
        }else{
            $data = [
                'status'=>200,
                'data'=>$invoice
            ];
        }
        return $data;
    }
}
