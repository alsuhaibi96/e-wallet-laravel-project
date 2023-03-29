<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    /** log ing user based on the role */
    public function loginUser(Request $request)
    {

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            
            $id=Auth::id();
 
            $user=User::where('id',$id)->first();
    
           
        if($user->hasRole(2)){
            return 'weolcome normal';
            
        }
        else
        return view('home');
        }
}

public function login()
{
    return view('auth.login');
}
}
