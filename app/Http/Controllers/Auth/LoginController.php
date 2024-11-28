<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:publisher')->except('logout');
    }
    /**
     * show user login form
     */
    public function index()
    {
        return view('auth.login', ['url' => 'user']);
    }
    /**
     * user login action
     */
    public function userLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1], $request->get('remember'))) {

            $request->session()->regenerate();

            flash()->addSuccess('Your account login successful.');
            return redirect()->intended('/user/dashboard-user');
        }

        flash()->addWarning('Your email and password are invalid.');
        return back()->withInput($request->only('email', 'remember'));
    }

    public function showAdminLoginForm()
    {
        return view('auth.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1], $request->get('remember'))) {
            
            $request->session()->regenerate();
            flash()->addSuccess('Your account login successful.');
            return redirect()->intended('/admin/dashboard');
        }
        flash()->addWarning('Your email and password are invalid.');
        return back()->withInput($request->only('email', 'remember'));
    }    

    public function showPublisherLoginForm()
    {
        return view('auth.login', ['url' => 'publisher']);
    }

    public function publisherLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
        if (Auth::guard('publisher')->attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1], $request->get('remember'))) {
            $request->session()->regenerate();
            flash()->addSuccess('Your account login successful.');
            return redirect()->intended('/publisher/dashboard-publisher');
        }
        flash()->addWarning('Your email and password are invalid.');
        return back()->withInput($request->only('email', 'remember'));
    }    

    /**
     * logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash()->addSuccess('Logout successful.');

        return redirect('/');
    }
}