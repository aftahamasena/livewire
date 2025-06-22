<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role;

class Register extends Component
{
    public $name;
    public $email;
    public $password;
    public $passwordConfirmation;
    public $errorMessage = null;

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ];

    public function register()
    {
        $this->validate();

        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => Role::user,
            ]);

            session()->flash('success', 'Registration successful. You can now login.');
            return redirect()->route('login');
        } catch (\Exception $e) {
            $this->errorMessage = 'Registration failed. Please try again.';
        }
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
