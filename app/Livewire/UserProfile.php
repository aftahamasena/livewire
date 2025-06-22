<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserProfile extends Component
{
    public $name;
    public $email;
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;
    public $successMessage = null;
    public $errorMessage = null;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->save();

            $this->successMessage = 'Profile updated successfully!';
            $this->errorMessage = null;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error updating profile: ' . $e->getMessage();
            $this->successMessage = null;
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
            'confirmPassword' => 'required',
        ]);

        try {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!Hash::check($this->currentPassword, $user->password)) {
                $this->errorMessage = 'Current password is incorrect.';
                return;
            }

            $user->password = Hash::make($this->newPassword);
            $user->save();

            $this->currentPassword = '';
            $this->newPassword = '';
            $this->confirmPassword = '';
            $this->successMessage = 'Password updated successfully!';
            $this->errorMessage = null;
        } catch (\Exception $e) {
            $this->errorMessage = 'Error updating password: ' . $e->getMessage();
            $this->successMessage = null;
        }
    }
}
