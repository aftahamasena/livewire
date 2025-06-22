<div class="container mt-5" style="max-width: 400px;">
    <h1 class="mb-4 text-center">Register</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="register" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" wire:model.defer="name"
                class="form-control @error('name') is-invalid @enderror" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" wire:model.defer="email"
                class="form-control @error('email') is-invalid @enderror" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" wire:model.defer="password"
                class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation"
                class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Register
        </button>
    </form>

    <p class="mt-3 text-center small">
        Already have an account?
        <a href="{{ route('login') }}">Login here</a>
    </p>
</div>
