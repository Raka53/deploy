<?php
namespace App\Http\Controllers;

use App\Models\hrd;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function showRegistrationForm()
    {
      $data = hrd::orderBy('name','asc')->get();
        return view('auth.register', compact('data'));
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'hrd_id' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:it,manager,spv,staff,NSMT'],
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'hrd_id' => $credentials['hrd_id'],
            'email' => $credentials['email'],
            'password' => bcrypt($credentials['password']),
        ]);

        $role = Role::where('name', $credentials['role'])->first();

        $user->assignRole($role);

        Alert::success('Success', 'Berhasil Registrasi.')->persistent(true);
        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
