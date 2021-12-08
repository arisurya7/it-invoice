<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\KodePos;
use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        $customer = Customer::with(['kodepos.provinsi', 'kodepos.kota'])->get();
        $data = [
            'isCustomer' => 'active',
            'customer' => $customer
        ];
        return view('customer.index', $data);
    }

    public function add(Request $request){

         if ($request->isMethod('POST')){
            $rules = [
                'nama_customer'=>'required',
                'telp'=>'required',
                'email'=>'required',
                'provinsi'=>'required',
                'kota'=>'required',
                'kecamatan' => 'required',
                'kodepos'=>'required',
                'alamat'=>'required',
            ];
            $errMessage = [
                'nama_customer.required'=>'Nama Customer wajib diisi',
                'telp.required'=>'Telp wajib diisi',
                'email.required'=>'Email wajib diisi',
                'provinsi.required'=>'Provinsi wajib diisi',
                'kota.required'=>'Kota wajib diisi',
                'kecamatan.required'=>'Kecamatan wajib diisi',
                'kodepos.required'=>'Kode pos wajib diisi',
                'alamat.required'=>'Alamat wajib diisi'
            ];
            $post = $request->validate($rules, $errMessage);

            $customer = new Customer();
            $customer->nama_customer = $post['nama_customer'];
            $customer->telp = $post['telp'];
            $customer->email = $post['email'];
            $customer->id_kodepos = $post['kodepos'];
            $customer->alamat = $post['alamat'];
            $customer->save();

            return redirect()->route('customer')->with(['success'=>'Customer berhasil ditambahkan']);
        }

        $provinsi = Provinsi::orderBy('nama')->get();
        $data = [
            'title'=>'Tambah Customer',
            'isCustomer'=>'active',
            'provinsi'=>$provinsi
        ];
        return view('customer.form', $data);
    }

    public function edit(Request $request, $id)
    {
        $customer = Customer::with(['kodepos.provinsi', 'kodepos.kota','kodepos.kecamatan'])->find($id);
        if ($request->isMethod('POST')){
            $rules = [
                'nama_customer'=>'required',
                'telp'=>'required',
                'email'=>'required',
                'kodepos'=>'required',
                'alamat'=>'required'
            ];
            $errMessage = [
                'nama_customer.required'=>'Nama Customer wajib diisi',
                'telp.required'=>'Telp wajib diisi',
                'email.required'=>'Email wajib diisi',
                'kodepos.required'=>'Kode pos wajib diisi',
                'alamat.required'=>'Alamat wajib diisi'
            ];

            $post = $request->validate($rules, $errMessage);

            $customer->nama_customer = $post['nama_customer'];
            $customer->telp = $post['telp'];
            $customer->email = $post['email'];
            $customer->id_kodepos = $post['kodepos'];
            $customer->alamat = $post['alamat'];
            
            if ($customer->isDirty()){
                $customer->save();
                return redirect()->route('customer')->with(['success'=>'Update berhasil disimpan']);
            }
            return redirect()->route('customer')->with(['warning'=>'Tidak ada perubahan pada Customer']);
        }

        $provinsi = Provinsi::orderBy('nama')->get();
        $kota = Kota::where('provinsi_id', $customer->kodepos->provinsi_id)->orderBy('nama')->get();
        $kecamatan = Kecamatan::where('kota_id', $customer->kodepos->kota_id)->orderBy('nama')->get();
        $kodepos = KodePos::where('kecamatan_id', $customer->kodepos->kecamatan_id)->orderBy('kode')->get();

        #Replace desa_id to name desa
        for($i=0; $i<count($kodepos); $i++){
            $namaDesa = Desa::where('id', $kodepos[$i]['desa_id'])->get();
            $kodepos[$i]['desa_id'] = $namaDesa[0]->nama;
        }   

        $data = [
            'title'=>'Edit Customer',
            'isCustomer'=>'active',
            'provinsi'=>$provinsi,
            'kota'=>$kota,
            'kecamatan'=>$kecamatan,
            'kodepos'=>$kodepos,
            'customer'=>$customer
        ];
        return view('customer.form', $data);
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
        $customer = Customer::find($request->id);
        if ($customer->exists()){        
            $data = [
                'status'=>'200',
                'data'=>$customer
            ];

           $data['data']['provinsi'] = Customer::find($request->id)->kodepos->provinsi->nama;
           $data['data']['kota'] = Customer::find($request->id)->kodepos->kota->nama;
           $data['data']['kecamatan'] = Customer::find($request->id)->kodepos->kecamatan->nama;
           $data['data']['kodepos'] = Customer::find($request->id)->kodepos->kode. ' - '.Customer::find($request->id)->kodepos->desa->nama;
         
        }else{
            $data = [
                'status'=>'404'
            ];
        }
        return $data;
    }

    public function delete(Request $request){
        Customer::find($request->id_customer)->delete();
        return redirect()->route('customer')->with(['success'=>'Data Customer berhasil dihapus!']);
    }
}
