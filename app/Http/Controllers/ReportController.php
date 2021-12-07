<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(Request $request){
        if($request->isMethod('POST')){
            $invoice = Invoice::filter(request(['filter_project','filter_status', 'filter_begin_date', 'filter_last_date']))->get();
        }else{
            $invoice = NULL;
        }
        $filter = [
            'project'=>$request->filter_project,
            'status'=>$request->filter_status,
            'begin_date'=>$request->filter_begin_date,
            'last_date' =>$request->filter_last_date
        ];
        $project= Project::all();
        $data = [
            'isReport'=>'active',
            'invoice'=>$invoice,
            'project'=>$project,
            'filter'=>$filter
        ];
        return view('report.index', $data);
    }

    public function printpdf(Request $request){
        $invoice = Invoice::filter(request(['filter_project','filter_status', 'filter_begin_date', 'filter_last_date']))->get();
        $filter = [
            'project'=>Project::where('id',$request->filter_project)->get('nama_project'),
            'customer'=>Project::where('id',$request->filter_project)->get('nama_perusahaan'),
            'status'=>$request->filter_status,
            'begin_date'=>$request->filter_begin_date,
            'last_date' =>$request->filter_last_date
        ];
        $grandTotal = 0;
        foreach($invoice as $item){
            $grandTotal += $item->total;
        }
        $pdf = PDF::loadView('report.pdf',['invoice'=>$invoice, 'filter'=>$filter, 'grandTotal'=>$grandTotal])->setpaper('A4','landscape');
        return $pdf->stream('Report Invoice.pdf');
    }
}
