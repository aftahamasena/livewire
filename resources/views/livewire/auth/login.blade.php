<div class="container mt-5" style="max-width: 400px;">
    <h1 class="mb-4 text-center">Login</h1>

    <form wire:submit.prevent="login" class="needs-validation" novalidate>
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

        <button type="submit" class="btn btn-primary w-100">
            Login
        </button>
    </form>

    <p class="mt-3 text-center small">
        Don't have an account?
        <a href="{{ route('register') }}">Register here</a>
    </p>
</div>
