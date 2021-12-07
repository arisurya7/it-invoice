<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(Request $request){
        
        $users = User::where('role','!=','Admin')->get();
        $data = [
            'isUsers' => 'active',
            'users' => $users
        ];

        return view('users.index', $data);
    }

    public function add(Request $request){
     
        if ($request->isMethod('POST')){
            $rules = [
                'firstname'=>'required',
                'lastname'=>'required',
                'username'=>'required|min:3|unique:users',
                'email'=>'required|email:dns|unique:users',
                'password'=>'required|min:5|max:255',
                'confirm_password'=>'required|required_with:password|same:password',
                'role' => 'required',
                'foto' => 'image|file|max:5120'
            ];
            $errMessage = [
                'firstname.required'=>'First Name wajib diisi',
                'lastname.required'=>'Last Name wajib diisi',
                'username.required'=>'Username wajib diisi',
                'email.required'=>'Email wajib diisi',
                'password.required'=>'Password wajib diisi',
                'confirm_password.required'=>'Konfirmasi Password wajib diisi',
                'role.required'=>'Role wajib diisi'
            ];
            $post = $request->validate($rules, $errMessage);

            $user = new User();
            $user->firstname = $post['firstname'];
            $user->lastname = $post['lastname'];
            $user->username = $post['username'];
            $user->email = $post['email'];
            $user->password = Hash::make($post['password']);
            $user->role = $post['role'];
            if($request->file('foto')){
                $user->foto = $request->file('foto')->store('profile-img');
            }
            $user->save();

            return redirect()->route('users')->with(['success'=>'User berhasil ditambahkan']);
        }

        $data = [
            'title'=>'Tambah User',
            'isUsers'=>'active',
        ];
        return view('users.form',$data);
    }

    public function edit(Request $request, $id){
        $user = User::find($id);
        if ($request->isMethod('POST')){
            $rules = [
                'firstname'=>'required',
                'lastname'=>'required',
                'username'=>'required',
                'email'=>'required',
                'role' => 'required',
                'foto' => 'image|file|max:5120'
            ];
            $errMessage = [
                'firstname.required'=>'First Name wajib diisi',
                'lastname.required'=>'Last Name wajib diisi',
                'username.required'=>'Username wajib diisi',
                'email.required'=>'Email wajib diisi',
                'role.required'=>'Role wajib diisi'
            ];
          
            $post = $request->validate($rules, $errMessage);
            
            $user->firstname = $post['firstname'];
            $user->lastname = $post['lastname'];
            $user->username = $post['username'];
            $user->email = $post['email'];
            $user->role = $post['role'];
            if($request->file('foto')){
                $user->foto = $request->file('foto')->store('profile-img');
            }
            
            if ($user->isDirty()){
                if($user->isDirty('username')){
                    $validateUsername = $request->validate(['username'=>'min:3|unique:users']);
                    $user->username = $validateUsername['username'];
                }

                if($user->isDirty('email')){
                    $validateEmail = $request->validate(['email'=>'unique:users']);
                    $user->email = $validateEmail['email'];
                }
               
                $user->save();
                return redirect()->route('users')->with(['success'=>'Update data user berhasil disimpan']);
            }
            return redirect()->route('users')->with(['warning'=>'Tidak ada perubahan pada data user']);
        }

        $data = [
            'title'=>'Edit User',
            'isUsers'=>'active',
            'user'=>$user
        ];
        return view('users.form', $data);
    }

    public function show(Request $request){
        $user = User::find($request->id);
        if ($user->exists()){             
            $data = [
                'status'=>'200',
                'data'=>$user
            ];
        }else{
            $data = [
                'status'=>'404'
            ];
        }
        return $data;
    }

    public function delete(Request $request){
        User::find($request->id_user)->delete();
        return redirect()->route('users')->with(['success'=>'Data User berhasil dihapus!']);
    }

    public function changepassword(Request $request,$id){
        $user = User::find($id);
        if($request->isMethod('POST')){
            $post = $request->validate([
                'old_password'=>'required',
                'new_password'=>'required|min:5|max:255',
                'confirm_new_password'=>'required|required_with:new_password|same:new_password',
            ]);
           
            if(Hash::check($post['old_password'], $user->password)){
                $user->password = Hash::make($post['new_password']);
                $user->save();
                return redirect()->route('users')->with(['success'=>'Password user berhasil dirubah']);
            }else{
                return redirect()->route('users.changepassword', ['id'=>$user->id])->with(['error'=>'Password Lama salah!']);
            }
        }
        $data = [
            'title' => 'Change Password',
            'isUsers' => 'active',
            'user'=>$user
        ];
        return view('users.changepassword',$data);
    }
    
}
