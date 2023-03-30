<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;

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
    public function login()
    {
        return view('auth.login');
    }
   

    /** log ing user based on the role */
    public function loginUser(LoginRequest $request)
    {
    //     Validator::validate($request->all(), [
    //         'email' => ['email', 'required', 'min:3', 'max:50'],
    //         'password' => ['required', 'min:5']

    //     ], [
    //         'email.required' => 'هذا الحقل مطلوب',
    //         'password.required' => 'هذا الحقل مطلوب',

    //     ]);
    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

    //         $id = Auth::id();

    //         $user = User::where('id', $id)->first();


    //         if ($user->hasRole(2)) {
    //             return redirect('userDashboard');
    //         } else if ($user->hasRole(1)) {
    //             return redirect('home');
    //         }
    //     }
    // }
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect()->to('login')
                ->withErrors(trans('auth.failed'));
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
          $id=Auth::id();

           $user=User::where('id',$id)->first();


    if($user->hasRole('normal-user')){
           return redirect('user/dashboard');

        }
        else if($user->hasRole('Admin'))
        {
            return redirect('/');

        }
    }

    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended();
    }
}
