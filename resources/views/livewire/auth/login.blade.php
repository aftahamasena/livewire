<div>
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="mb-0"><i class="fas fa-sign-in-alt"></i> Login</h4>
        </div>
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errorMessage)
                <div class="alert alert-danger">{{ $errorMessage }}</div>
            @endif

            <form wire:submit="login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" wire:model="email" class="form-control" required>
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" wire:model="password" class="form-control" required>
                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" id="remember" wire:model="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="mb-0">Don't have an account?
                    <a href="/register" class="text-decoration-none">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
