<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Arr;
use App\Models\User;
// use App\Models\RequestPayment;
use Carbon\Carbon;

class HomeController extends Controller
{
    
    public function index()
    {


        if(User::where('confirmed','1')->first() ){
            if (auth()->check()) {
                return view('dashboard.index');

            } else {
                return redirect()->to('login/');
            }
        }else{
            return redirect()->to('login/')->withErrors([
                'invalido' => 'Usuario no confirmado.',
            ]);
        }
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function authenticate(Request $request)
    {
        dd(__FUNCTION__, $request->all());
    }

}
 
