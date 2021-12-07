<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Deskripsi;
use App\Models\DetailRevisi;
use App\Models\Invoice;
use App\Models\Kecamatan;
use App\Models\KodePos;
use App\Models\Kota;
use App\Models\Project;
use App\Models\Provinsi;
use App\Models\Revisi;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ProjectController extends Controller
{
    public function index(Request $request){
        $project = Project::all();
        $data = [
            'isProject' => 'active',
            'project' => $project
        ];

        return view('project.index', $data);
    }

    public function add(Request $request){

         if ($request->isMethod('POST')){
            $rules = [
                'nama_project'=>'required',
                'nama_perusahaan'=>'required',
                'telp'=>'required',
                'tanggal'=>'required',
                'provinsi'=>'required',
                'kota'=>'required',
                'kecamatan' => 'required',
                'kodepos'=>'required',
                'alamat'=>'required',
            ];
            $errMessage = [
                'nama_project.required'=>'Nama Project wajib diisi',
                'nama_perusahaan.required'=>'Nama Perusahaan wajib diisi',
                'telp.required'=>'Telp wajib diisi',
                'tanggal.required'=>'Tanggal wajib diisi',
                'provinsi.required'=>'Provinsi wajib diisi',
                'kota.required'=>'Kota wajib diisi',
                'kecamatan.required'=>'Kecamatan wajib diisi',
                'kodepos.required'=>'Kode pos wajib diisi',
                'alamat.required'=>'Alamat wajib diisi'
            ];
            $post = $request->validate($rules, $errMessage);
            // dd($post);

            $project = new Project();
            $project->nama_project = $post['nama_project'];
            $project->nama_perusahaan = $post['nama_perusahaan'];
            $project->telp = $post['telp'];
            $project->tanggal = $post['tanggal'];
            $project->provinsi = $post['provinsi'];
            $project->kota = $post['kota'];
            $project->kecamatan = $post['kecamatan'];
            $project->kodepos = $post['kodepos'];
            $project->alamat = $post['alamat'];
            $project->save();

            return redirect()->route('project')->with(['success'=>'Project berhasil disimpan']);
        }

        $provinsi = Provinsi::orderBy('nama')->get();
        $data = [
            'title'=>'Tambah Project',
            'isProject'=>'active',
            'provinsi'=>$provinsi
        ];
        return view('project.form', $data);
    }

    public function edit(Request $request, $id)
    {
        $project = Project::find($id);
        if ($request->isMethod('POST')){
            $rules = [
                'nama_project'=>'required',
                'nama_perusahaan'=>'required',
                'telp'=>'required',
                'tanggal'=>'required',
                'provinsi'=>'required',
                'kota'=>'required',
                'kecamatan' => 'required',
                'kodepos'=>'required',
                'alamat'=>'required'
            ];
            $errMessage = [
                'nama_project.required'=>'Nama Project wajib diisi',
                'nama_perusahaan.required'=>'Nama Perusahaan wajib diisi',
                'telp.required'=>'Telp wajib diisi',
                'tanggal.required'=>'Tanggal wajib diisi',
                'provinsi.required'=>'Provinsi wajib diisi',
                'kota.required'=>'Kota wajib diisi',
                'kecamatan.required'=>'Kecamatan wajib diisi',
                'kodepos.required'=>'Kode pos wajib diisi',
                'alamat.required'=>'Alamat wajib diisi'
            ];

            $post = $request->validate($rules, $errMessage);

            $project->nama_project = $post['nama_project'];
            $project->nama_perusahaan = $post['nama_perusahaan'];
            $project->telp = $post['telp'];
            $project->tanggal = $post['tanggal'];
            $project->provinsi = $post['provinsi'];
            $project->kota = $post['kota'];
            $project->kecamatan = $post['kecamatan'];
            $project->kodepos = $post['kodepos'];
            $project->alamat = $post['alamat'];
            
            if ($project->isDirty()){
                $project->save();
                return redirect()->route('project')->with(['success'=>'Update berhasil disimpan']);
            }
            return redirect()->route('project')->with(['warning'=>'Tidak ada perubahan pada Project']);
        }
        $provinsi = Provinsi::orderBy('nama')->get();
        $kota = Kota::where('provinsi_id', $project->provinsi)->orderBy('nama')->get();
        $kecamatan = Kecamatan::where('kota_id', $project->kota)->orderBy('nama')->get();
        $kodepos = KodePos::where('kecamatan_id', $project->kecamatan)->orderBy('kode')->get();

        #Replace desa_id to name desa
        for($i=0; $i<count($kodepos); $i++){
            $namaDesa = Desa::where('id', $kodepos[$i]['desa_id'])->get();
            $kodepos[$i]['desa_id'] = $namaDesa[0]->nama;
        }   

        $data = [
            'title'=>'Edit Project',
            'isProject'=>'active',
            'provinsi'=>$provinsi,
            'kota'=>$kota,
            'kecamatan'=>$kecamatan,
            'kodepos'=>$kodepos,
            'project'=>$project
        ];
        return view('project.form', $data);
    }

    public function getKota(Request $request)
    {
        $kota = Kota::where('provinsi_id', $request->provinsi)->orderBy('nama')->get();
        if (!$kota->isEmpty()){
            $data = [
                'status'=>200,
                'kota'=>$kota
            ];
        }else{
            $data = [
                'status'=>500,
            ];
        }
        return $data;
    }

    public function getKecamatan(Request $request)
    {
        $kecamatan = Kecamatan::where('kota_id', $request->kota)->orderBy('nama')->get();
        if (!$kecamatan->isEmpty()){
            $data = [
                'status'=>200,
                'kecamatan'=>$kecamatan
            ];
        }else{
            $data = [
                'status'=>500,
            ];
        }
        return $data;
    }

    public function getKodepos(Request $request)
    {
        $kodepos = KodePos::where('kecamatan_id', $request->kecamatan)->orderBy('kode')->get();
        
        #Replace desa_id to name desa
        for($i=0; $i<count($kodepos); $i++){
            $namaDesa = Desa::where('id', $kodepos[$i]['desa_id'])->get();
            $kodepos[$i]['desa_id'] = $namaDesa[0]->nama;
        }        

        if (!$kodepos->isEmpty()){
            $data = [
                'status'=>200,
                'kodepos'=>$kodepos
            ];
        }else{
            $data = [
                'status'=>500,
            ];
        }
        return $data;
    }

    public function show(Request $request)
    { 
        $project = Project::find($request->id);
        if ($project->exists()){
            $provinsi = Provinsi::where('id', $project->provinsi)->get();
            $kota = Kota::where('id', $project->kota)->get();
            $kecamatan = Kecamatan::where('id', $project->kecamatan)->get();
            $kodepos = KodePos::where('id', $project->kodepos)->get();
            $desa = Desa::where('id', $kodepos[0]->desa_id)->get();             

            $data = [
                'status'=>'200',
                'data'=>$project
            ];

           $data['data']['provinsi'] = $provinsi[0]->nama;
           $data['data']['kota'] = $kota[0]->nama;
           $data['data']['kecamatan'] = $kecamatan[0]->nama;
           $data['data']['kodepos'] = $kodepos[0]->kode. ' - '.$desa[0]->nama;
         
        }else{
            $data = [
                'status'=>'404'
            ];
        }
        return $data;
    }

    public function delete(Request $request){
       
        $idInvoices = Invoice::where('project_id', $request->id_project)->get('id');
        if(count($idInvoices)==0){
            Project::find($request->id_project)->delete();
            return redirect()->route('project')->with(['success'=>'Data Project berhasil dihapus!']);
        }else{
            $idRevisis = Array();
            $revisis = Revisi::all();
            foreach($idInvoices as $invoice){ 
                foreach($revisis as $revisi){
                    if($invoice->id == $revisi->invoice_id){
                        array_push($idRevisis,$revisi->id);   
                        Revisi::where('id',$revisi->id)->delete();
                    }                       
                }
                Invoice::where('id', $invoice->id)->delete();
                Deskripsi::where('invoice_id',$invoice->id)->delete();
            }

            foreach($idRevisis as $d){
                DetailRevisi::where('revisi_id', $d)->delete();
            }

            Project::find($request->id_project)->delete();
            return redirect()->route('project')->with(['success'=>'Data Project berhasil dihapus!']);
        }
        
    }

}
