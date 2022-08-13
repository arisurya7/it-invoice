<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Deskripsi;
use App\Models\DetailRevisi;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Revisi;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request){
        $project = Project::with(['customer'])->get();
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
                'customer'=>'required',
                'tanggal'=>'required',
            ];
            $errMessage = [
                'nama_project.required'=>'Nama Project wajib diisi',
                'customer.required'=>'Nama Customer wajib dipilih',
                'telp.required'=>'Telp wajib diisi',
                'tanggal.required'=>'Tanggal wajib diisi',
            ];
            $post = $request->validate($rules, $errMessage);
            // dd($post);

            $project = new Project();
            $project->nama_project = $post['nama_project'];
            $project->customer_id = $post['customer'];
            $project->tanggal = $post['tanggal'];
            $project->save();

            return redirect()->route('project')->with(['success'=>'Project berhasil ditambahkan']);
        }

        $customer = Customer::orderBy('nama_customer')->get();
        $data = [
            'title'=>'Tambah Project',
            'isProject'=>'active',
            'customer'=>$customer
        ];
        return view('project.form', $data);
    }

    public function edit(Request $request, $id)
    {
        $project = Project::find($id);
        $customer = Customer::all();
        if ($request->isMethod('POST')){
            $rules = [
                'nama_project'=>'required',
                'customer'=>'required',
                'tanggal'=>'required',
            ];
            $errMessage = [
                'nama_project.required'=>'Nama Project wajib diisi',
                'customer.required'=>'Nama Customer wajib diisi',
                'tanggal.required'=>'Tanggal wajib diisi',
            ];

            $post = $request->validate($rules, $errMessage);

            $project->nama_project = $post['nama_project'];
            $project->customer_id = $post['customer'];
            $project->tanggal = $post['tanggal'];
            
            if ($project->isDirty()){
                $project->save();
                return redirect()->route('project')->with(['success'=>'Update berhasil disimpan']);
            }
            return redirect()->route('project')->with(['warning'=>'Tidak ada perubahan pada Project']);
        }

        $data = [
            'title'=>'Edit Project',
            'isProject'=>'active',
            'customer'=>$customer,
            'project'=>$project
        ];
        return view('project.form', $data);
    }

    public function show(Request $request)
    { 
        $project = Project::find($request->id);
        if ($project->exists()){           
            $data = [
                'status'=>'200',
                'data'=>$project
            ];

           $data['data']['nama_customer'] = $project->customer->nama_customer;
           $data['data']['telp'] = $project->customer->telp;
           $data['data']['email'] = $project->customer->email;

        }else{
            $data = [
                'status'=>'404'
            ];
        }
        return $data;
    }

    public function delete(Request $request){
        Project::find($request->id_project)->delete();
        return redirect()->route('project')->with(['success'=>'Data Project berhasil dihapus!']);
    }

}
