<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\Activity;
class AuthController extends Controller
{
 public function showLogin(){return view('auth.login');}
 public function login(Request $request){$data=$request->validate(['email'=>'required|email','password'=>'required|string']); if(Auth::attempt($data,$request->boolean('remember'))){if(!auth()->user()->is_active){Auth::logout();return back()->withErrors(['email'=>'This account has been deactivated.'])->onlyInput('email');}$request->session()->regenerate(); Activity::record('login','authentication','User logged in'); return redirect()->intended(route('dashboard'));} return back()->withErrors(['email'=>'The provided credentials do not match our records.'])->onlyInput('email');}
 public function logout(Request $request){Activity::record('logout','authentication','User logged out'); Auth::logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return redirect()->route('login');}
}
