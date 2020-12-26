<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Kontak;
use Session;
use Validator;

class LoginController extends Controller
{
    public function login(){
        return view('auth.login');
    }
    
    public function cek(Request $req){
        $this->validate($req,[
        'username'=>'required',
        'password'=>'required'
        ]);
        $proses = Kontak::where('username',$req->username)->where('password',md5($req->password));
        if($proses->count()>0){
            $data = $proses->first();
            if($data->level == 'admin'){
                Session::put('id', $data->id);
                Session::put('email', $data->email);
                Session::put('phone', $data->phone);
                Session::put('level', $data->level);
                Session::put('username', $data->username);
                Session::put('password', $data->password);
                Session::put('login_status', true);
                return redirect('dashboard');
            }else{
                Session::put('id', $data->id);
                Session::put('email', $data->email);
                Session::put('phone', $data->phone);
                Session::put('level', $data->level);
                Session::put('username', $data->username);
                Session::put('password', $data->password);
                Session::put('login_status', true);
                return redirect('index');
            }
        } else {
            return redirect('login');
        }
    }

    public function register(){
        return view('auth.register');
    }

    public function store(Request $request){
        $count1 = Kontak::where('email',$request->email);
        $count2 = Kontak::where('username',$request->username);
        if($count1->count()<1 && $count2->count()<1){
            Kontak::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'level' => 'user',
                'username' => $request->username,
                'password' => md5($request->password),
            ]);
            return redirect('login');
        }else{
            Session::flash('message', 'Email dan Username sudah tersedia');
            return redirect()->back();
        }
        }

    public function logout(){
        Session::flush();
        return redirect('login');
    }
}
