<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/index';
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest:admin', ['except' => 'logout']);
        //$this->username = config('admin.global.username');
    }

    /**
     * rewrite login view
     */
    public function login()
    {
        return view('admin.login.index');
    }


    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|max:255',
            'password' => 'required'
        ]);

        $rs = $this->guard()->attempt($credentials);
        if ($rs) {
            return redirect()->route('admin_success');
        } else {
            return back();
        }
    }

    public function success()
    {
        //dd(auth()->guard('admin')->user());
        return view('admin.dashboard.index');
    }

    /**
     * redefine auth guard
     * @return mixed
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }


    public function logout(Request $request){

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/admin/login');

    }
}
