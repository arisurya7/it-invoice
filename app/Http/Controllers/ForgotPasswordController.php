<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Mail\ResetPassword;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    //
    public function index(){
        return view('auth.forgotpassword');
    }

    public function validatepassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);
        $token = Str::random(64);
        $url = config('app.url')."/"."resetpassword"."/".$token;
  
        DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);

        $user = User::where('email', $request->email)->first();
        $name = $user->firstname.' '.$user->lastname;
        Mail::to($request->email)->send(new ResetPassword($name, $url));
        if(Mail::failures() != 0) {
            return back()->with('success', 'Success! link reset password telah dikirim ke email anda');
        }
        return back()->with('failed', 'Failed! terdapat beberapa issue dari email provider');
    }

    public function resetpassword($token){
        $passwordReset = DB::table('password_resets')->where('token',$token)->first();
        if($passwordReset){
            return view('auth.resetpassword',['token' => $token, 'email'=>$passwordReset->email]);
        }
        return redirect('forgotpassword')->with('failed', 'Failed! link reset password sudah expired');
    }

    public function updatepassword(Request $request){
        
        $request->validate([
            'password'=>'required|min:5|max:255',
            'confirm_password'=>'required|required_with:password|same:password'
        ]);

        $dataToken = DB::table('password_resets')->where('token',$request->token)->first();
        $user = User::where('email',$dataToken->email)->first();
        if(!$user) return redirect('forgotpassword')->with('failed', 'Failed! email tidak terdaftar');

        $user->password = Hash::make($request->password);
        $user->update();

        DB::table('password_resets')->where('email', $user->email)->delete();
        return redirect('login')->with('success', 'Success! password anda berhasil dirubah');

    }
}
