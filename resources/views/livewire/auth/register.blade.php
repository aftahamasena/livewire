<div>
    <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0"><i class="fas fa-user-plus"></i> Register</h4>
        </div>
        <div class="card-body p-4">
            @if ($errorMessage)
                <div class="alert alert-danger">{{ $errorMessage }}</div>
            @endif

            <form wire:submit="register">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" wire:model="name" class="form-control" required>
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

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

                <div class="mb-3">
                    <label for="passwordConfirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="passwordConfirmation" wire:model="passwordConfirmation" class="form-control" required>
                    @error('passwordConfirmation') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Register
                    </button>
                </div>
            </form>

            <hr class="my-4">

            <div class="text-center">
                <p class="mb-0">Already have an account?
                    <a href="/login" class="text-decoration-none">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
