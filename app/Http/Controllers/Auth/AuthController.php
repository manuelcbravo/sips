<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Auth;
use App;
use Session, URL, Redirect;

class AuthController extends Controller
{
    public function customLogin(Request $request)
    {
        $remember = false;
        
        if($request->remember){
            $remember = true;
        }

        // dd($request->all(), $remember);

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $credentials = $request->only('email', 'password');
        
        $user = User::where('email', $request->email)->first();

        if($user && $user->activado == 0){
            return response()->json([
                'login' => false,
                 'mensaje' => 'Usuario desactivado.'],
            200);
        }

        if (Auth::attempt($credentials, $remember)) {

            App::setLocale('es');
            session()->put('locale', 'es');
            return response()->json([
                'login' => true,
                'url' => session('link')],
                200);

        }

         return response()->json([
            'login' => false,
             'mensaje' => 'Credenciales invalidas.'],
             200);
    }

    public function LogOut(Request $request) {

        $request->user()->tokens($request->tokenID)->delete();


        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

}
