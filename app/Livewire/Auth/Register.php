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
    public $password_confirmation;

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ];

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => Role::user,
        ]);

        session()->flash('success', 'Registration successful. You can now login.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.app', ['title' => 'Register']);
    }
}
