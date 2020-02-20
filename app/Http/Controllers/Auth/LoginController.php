<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

    public  function __construct () {

    }

    public function init(){
        return view("auth.login");
    }
    public  function  showLoginForm(){
        return redirect("/logeo");
    }
    public function iniciarsesion(LoginFormRequest $request){
        if(Auth::attempt(['usuario'=>$request->usuario,'password'=>$request->password],false)){
            return response()->json('Has Iniciado Sesión',200);
        }else{
            return response()->json([
                'errors'=>[
                    'login'=>[
                        'Los datos que Ingresastes son incorrectos'
                    ]
                ]
            ],422);
        }

    }
    public function reload(Request $request){
        if($request->ajax()){
            return $request->url();
        }else{
            return redirect()->route("admin");
        }

    }
    public function cerraSession(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('logeo');
    }
}
