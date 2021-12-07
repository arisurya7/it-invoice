<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Deskripsi;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\KodePos;
use App\Models\Revisi;
use App\Models\DetailRevisi;
use App\Models\Kecamatan;
use App\Models\Project;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {       
        $invoice = Invoice::all();
        $project = Project::all();
        $data = [
            'isInvoice'=>'active',
            'invoice'=>$invoice,
            'project'=>$project,
        ];
        return view('invoice.index', $data);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('POST')){
            $rules = [
                'project'=>'required',
                'telp'=>'required',
                'tanggal'=>'required',
                'perihal'=>'required',
                'alamat'=>'required',
                'provinsi'=>'required',
                'kota'=>'required',
                'kecamatan' => 'required',
                'kodepos'=>'required',
                'metode_pembayaran'=>'required',
                'bank'=>'required',
                'cabang_bank'=>'required',
                'no_rekening'=>'required',
                'penerima'=>'required',
                'total'=>'required',
                'termin'=>'required',
                'deskripsi.*'=>'required',
                'ammount.*'=>'required',
            ];
            $errMessage = [
                'project.required'=>'Project wajib diisi',
                'telp.required'=>'Telp wajib diisi',
                'tanggal.required'=>'Tanggal wajib diisi',
                'perihal.required'=>'Perihal wajib diisi',
                'alamat.required'=>'Alamat wajib diisi',
                'provinsi.required'=>'Provinsi wajib diisi',
                'kota.required'=>'Kota wajib diisi',
                'kecamatan.required'=>'Kecamatan wajib diisi',
                'kodepos.required'=>'Kode pos wajib diisi',
                'metode_pembayaran.required'=>'Metode pembayaran wajib diisi',
                'bank.required'=>'Bank wajib diisi',
                'cabang_bank.required'=>'Cabang bank wajib diisi',
                'no_rekening.required'=>'No Rekening wajib diisi',
                'penerima.required'=>'Penerima wajib diisi',
                'total.required'=>'Total wajib diisi',
                'termin.required'=>'Termin wajib diisi',
                'deskripsi.*.required'=>'Deskripsi wajib diisi',
                'ammount.*.required'=>'Jumlah wajib diisi',
            ];
            $post = $request->validate($rules, $errMessage);
            // dd($post);

            // no invoice
            $tanggal = $post['tanggal'];
            $tahun = date('Y', strtotime($tanggal));
            $bulan = date('m', strtotime($tanggal));
            $romanArr = ['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
            $roman = $bulan=='10' ? (int)$bulan : (int)str_replace('0','',$bulan);
            $count = Invoice::where('nomor_invoice','like','%'.$roman.'%')->count() + 1;
            if (strlen((string)$count)==1){
                $zero = '000';
            }else if (strlen((string)$count)==2){
                $zero = '00';
            }else if (strlen((string)$count)==3){
                $zero = '0';
            }else {
                $zero = '';
            }
            $nomorInvoice = $tahun.$bulan.'/'.$romanArr[$roman-1].'-'.$zero.$count;
            // dd($nomorInvoice);

            $invoice = new Invoice();
            $invoice->nomor_invoice = $nomorInvoice;
            $invoice->project_id = $post['project'];
            $invoice->tanggal = $post['tanggal'];
            $invoice->perihal = $post['perihal'];
            $invoice->metode_pembayaran = $post['metode_pembayaran'];
            $invoice->bank = $post['bank'];
            $invoice->cabang_bank = $post['cabang_bank'];
            $invoice->no_rekening = $post['no_rekening'];
            $invoice->penerima = $post['penerima'];
            $invoice->total = $post['total'];
            $invoice->termin = $post['termin'];
            $invoice->status = 'Draft';
            $invoice->save();

            foreach($post['deskripsi'] as $key=>$desk){
                $deskripsi = new Deskripsi();
                $deskripsi->invoice_id = $invoice->id;
                $deskripsi->deskripsi = $desk;
                $deskripsi->ammount = $post['ammount'][$key];
                $deskripsi->save();
            }
            return redirect()->route('invoice')->with(['success'=>'Invoice berhasil disimpan']);
        }
        $project = Project::orderBy('nama_project')->get();
        $data = [
            'title'=>'Tambah Invoice',
            'isInvoice'=>'active',
            'project'=>$project
        ];
        
        return view('invoice.form', $data);
    }

    public function edit(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if ($request->isMethod('POST')){
            $rules = [
                'project'=>'required',
                'telp'=>'required',
                'tanggal'=>'required',
                'perihal'=>'required',
                'alamat'=>'required',
                'provinsi'=>'required',
                'kota'=>'required',
                'kodepos'=>'required',
                'kecamatan'=>'required',
                'metode_pembayaran'=>'required',
                'bank'=>'required',
                'cabang_bank'=>'required',
                'no_rekening'=>'required',
                'penerima'=>'required',
                'total'=>'required',
                'termin'=>'required',
                'deskripsi.*'=>'required',
                'ammount.*'=>'required',
            ];
            $errMessage = [
                'project.required'=>'Nama Project wajib diisi',
                'telp.required'=>'Telp wajib diisi',
                'tanggal.required'=>'Tanggal wajib diisi',
                'perihal.required'=>'Perihal wajib diisi',
                'alamat.required'=>'Alamat wajib diisi',
                'provinsi.required'=>'Provinsi wajib diisi',
                'kota.required'=>'Kota wajib diisi',
                'kecamatan.required'=>'Kecamatan wajib diisi',
                'kodepos.required'=>'Kode pos wajib diisi',
                'metode_pembayaran.required'=>'Metode pembayaran wajib diisi',
                'bank.required'=>'Bank wajib diisi',
                'cabang_bank.required'=>'Cabang bank wajib diisi',
                'no_rekening.required'=>'No Rekening wajib diisi',
                'penerima.required'=>'Penerima wajib diisi',
                'total.required'=>'Total wajib diisi', 
                'termin.required'=>'Termin wajib diisi',
                'deskripsi.*.required'=>'Deskripsi wajib diisi',
                'ammount.*.required'=>'Jumlah wajib diisi',
            ];
            $old = $invoice;
            $post = $request->validate($rules, $errMessage);
            // $invoice->nomor_invoice = $nomorInvoice;
            $invoice->project_id = $post['project'];
            $invoice->tanggal = $post['tanggal'];
            $invoice->perihal = $post['perihal'];
            $invoice->metode_pembayaran = $post['metode_pembayaran'];
            $invoice->bank = $post['bank'];
            $invoice->cabang_bank = $post['cabang_bank'];
            $invoice->no_rekening = $post['no_rekening'];
            $invoice->penerima = $post['penerima'];
            $invoice->total = $post['total'];
            $invoice->termin = $post['termin'];
            
            if ($invoice->isDirty()){

                if($invoice->isDirty('total')){
                    Deskripsi::where('invoice_id', $invoice->id)->delete();
                    foreach($post['deskripsi'] as $key=>$item){
                        $desc = new Deskripsi();
                        $desc->invoice_id = $invoice->id;
                        $desc->deskripsi = $item;
                        $desc->ammount = $post['ammount'][$key];
                        $desc->save();
                    }
                }

                $invoice->save();
                $revisi = new Revisi();
                $revisi->invoice_id = $old->id;
                $revisi->nomor_invoice = $old->nomor_invoice;
                $revisi->project_id = $old->project_id;
                $revisi->tanggal = $old->tanggal;
                $revisi->perihal = $old->perihal;
                $revisi->metode_pembayaran = $old->metode_pembayaran;
                $revisi->bank = $old->bank;
                $revisi->cabang_bank = $old->cabang_bank;
                $revisi->no_rekening = $old->no_rekening;
                $revisi->penerima = $old->penerima;
                $revisi->total = $old->total;
                $revisi->termin = $old->termin;
                $revisi->status = $old->status;
                $revisi->save();

                foreach($old->deskripsi as $key=>$item){
                    $detail = new DetailRevisi();
                    $detail->revisi_id = $revisi->id;
                    $detail->deskripsi = $item->deskripsi;
                    $detail->ammount = $item->ammount;
                    $detail->save();
                }

                return redirect()->route('invoice')->with(['success'=>'Revisi berhasil disimpan']);
            }
            return redirect()->route('invoice')->with(['warning'=>'Tidak ada perubahan pada invoice']);
        }
        
        $project = Project::orderBy('nama_project')->get();
        $projectedit = Invoice::find($id)->project;
        $provinsi = Provinsi::find($projectedit->provinsi);
        $kota = Kota::find($projectedit->kota);
        $kecamatan = Kecamatan::find($projectedit->kecamatan);
        $kodepos = KodePos::find($projectedit->kodepos);
        $projectedit->provinsi = $provinsi->nama;
        $projectedit->kota = $kota->nama;
        $projectedit->kecamatan = $kecamatan->nama;
        $projectedit->kodepos = $kodepos->kode;
        $data = [
            'title'=>'Revisi Invoice',
            'isInvoice'=>'active',
            'project'=>$project,
            'projectedit'=>$projectedit,
            'invoice'=>$invoice
        ];
        return view('invoice.form', $data);
    }

    public function status(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->status = $request->status;
        $invoice->save();
        return redirect()->route('invoice')->with(['success'=>'Status berhasil diupdate menjadi '.$request->status]);
    }

    public function revisi(Request $request)
    {
        $revisi = Revisi::find($request->id);
        $project = Project::orderBy('nama_project')->get();
        $projectedit = Project::find($revisi->project_id);
        $provinsi = Provinsi::find($projectedit->provinsi);
        $kota = Kota::find($projectedit->kota);
        $kecamatan = Kecamatan::find($projectedit->kecamatan);
        $kodepos = KodePos::find($projectedit->kodepos);
        $projectedit->provinsi = $provinsi->nama;
        $projectedit->kota = $kota->nama;
        $projectedit->kecamatan = $kecamatan->nama;
        $projectedit->kodepos = $kodepos->kode;
        
        $data = [
            'title'=>'Lihat Detail Revisi',
            'isInvoice'=>'active',
            'project'=>$project,
            'projectedit'=>$projectedit,
            'invoice'=>$revisi
        ];
        return view('invoice.form', $data);
    }

    public function getDetailProject(Request $request){
        $project = Project::where('id',$request->project)->get();
        $provinsi = Provinsi::where('id',$project[0]->provinsi)->get('nama');
        $kota = Kota::where('id',$project[0]->kota)->get('nama');
        $kecamatan = Kecamatan::where('id',$project[0]->kecamatan)->get('nama');
        $kodepos = KodePos::where('id',$project[0]->kodepos)->get('kode');
        $project[0]->provinsi = $provinsi[0]->nama;
        $project[0]->kota = $kota[0]->nama;
        $project[0]->kecamatan = $kecamatan[0]->nama;
        $project[0]->kodepos = $kodepos[0]->kode;
        
        if(!$project->isEmpty()){
            $data = [
                'status'=>200,
                'project'=>$project
            ];
        }else{
            $data = [
                'status'=>500
            ];
        }
        return $data;
    }
    

    public function show(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $project = Invoice::find($request->id)->project;

        if ($invoice->exists()){
            $deskripsi = Deskripsi::where('invoice_id', $request->id)->get();
            $provinsi = Provinsi::where('id', $project->provinsi)->get();
            $kota = Kota::where('id', $project->kota)->get();
            $kecamatan = Kecamatan::where('id', $project->kecamatan)->get();
            $kodepos = KodePos::where('id', $project->kodepos)->get();
            $desa = Desa::where('id', $kodepos[0]->desa_id)->get();             

            $data = [
                'status'=>'200',
                'invoice'=>$invoice,
                'project'=>$project,
                'deskripsi'=>$deskripsi,
            ];

           $data['project']['provinsi'] = $provinsi[0]->nama;
           $data['project']['kota'] = $kota[0]->nama;
           $data['project']['kecamatan'] = $kecamatan[0]->nama;
           $data['project']['kodepos'] = $kodepos[0]->kode. ' - '.$desa[0]->nama;
         
        }else{
            $data = [
                'status'=>'404'
            ];
        }
        return $data;
    }

    public function showRevisi(Request $request)
    {
        $revisi = Revisi::where('invoice_id', $request->id)->orderby('id', 'desc')->get();
        if ($revisi->isEmpty()){
            $data = [
                'status'=>404,
            ];
        }else{
            $data = [
                'status'=>200,
                'data'=>$revisi
            ];
        }
        return $data;
    }

    public function delete(Request $request){
        $data = Revisi::where('invoice_id', $request->id_invoice)->get('id');
        Revisi::where('invoice_id',$request->id_invoice)->delete();
        Invoice::find($request->id_invoice)->delete();
        Deskripsi::where('invoice_id',$request->id_invoice)->delete();
        foreach($data as $d){
            DetailRevisi::where('revisi_id',$d->id)->delete();
        }
        return redirect()->route('invoice')->with(['success'=>'Data invoice berhasil dihapus!']);

    }

    public function exportpdf($id){
        $invoice = Invoice::find($id);
        $project = Invoice::find($id)->project;
        $print_date = date('Y-m-d');
        $month = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November','Desember'];
        $letter_date = date('d', strtotime($invoice->tanggal)).' '.$month[(int)date('m', strtotime($invoice->tanggal))-1].' '.date('Y', strtotime($invoice->tanggal));
        $print_date = date('d', strtotime($print_date)).' '.$month[(int)date('m', strtotime($print_date))-1].' '.date('Y', strtotime($print_date));
        $descriptions = Deskripsi::where('invoice_id', $id)->get();
        $invoice->tanggal = date("d/m/Y", strtotime($invoice->tanggal));
        $pdf = PDF::loadView('invoice.pdf',['invoice'=>$invoice, 'project'=>$project, 'descriptions'=>$descriptions, 'letterdate'=>$letter_date, 'print_date'=>$print_date])->setpaper('A4','potrait');
        return $pdf->stream('Invoice '.$invoice->nomor_invoice.'.pdf');
    }
            

}
