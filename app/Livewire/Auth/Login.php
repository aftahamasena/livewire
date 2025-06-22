<?php

namespace App\Livewire\Auth;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $remember = false;
    public $intendedUrl;
    public $errorMessage = null;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ];

    public function mount()
    {
        // Ambil intended URL jika ada
        $this->intendedUrl = session()->get('url.intended', '/');
    }

    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            session()->regenerate();
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === Role::admin) {
                // Admin selalu redirect ke admin panel
                return redirect('/admin');
            } else {
                // User biasa redirect ke home
                return redirect('/');
            }
        } else {
            $this->errorMessage = 'Invalid email or password.';
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
