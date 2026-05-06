<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function register(): View
    {
        return view('auth.register');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'captcha' => 'required|string|size:6',
        ]);

        $captchaInput = strtoupper((string) $request->captcha);
        $captchaCode = strtoupper((string) session('login_captcha_code'));

        if ($captchaCode === '' || $captchaInput === '' || !hash_equals($captchaCode, $captchaInput)) {
            return redirect('login')
                ->withErrors(['captcha' => 'Captcha tidak valid, silakan coba lagi'])
                ->withInput($request->only('email'));
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            session()->forget('login_captcha_code');
            return redirect()->intended('admin')
                        ->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")
            ->with('error', 'Oppes! You have entered invalid credentials')
            ->withInput($request->only('email'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = $this->create($data)->assignRole("user");

        Auth::login($user);

        return redirect("admin")->withSuccess('Great! You have Successfully logged in');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function admin()
    {
        if(Auth::check()){
            return view('admin');
        }

        return redirect("login")->withSuccess('Opps! You do not have access');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'username' => $data['username'],
        'email' => $data['email'],
        'role_id' => '4',
        'password' => Hash::make($data['password'])
      ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
