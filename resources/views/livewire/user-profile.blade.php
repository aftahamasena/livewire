<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4"><i class="fas fa-user-circle"></i> My Profile</h2>

                @if ($successMessage)
                    <div class="alert alert-success">{{ $successMessage }}</div>
                @endif
                @if ($errorMessage)
                    <div class="alert alert-danger">{{ $errorMessage }}</div>
                @endif

                <div class="row">
                    <!-- Profile Information -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-user"></i> Profile Information</h5>
                            </div>
                            <div class="card-body">
                                <form wire:submit="updateProfile">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" id="name" wire:model="name" class="form-control" required>
                                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" wire:model="email" class="form-control" required>
                                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Profile
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-lock"></i> Change Password</h5>
                            </div>
                            <div class="card-body">
                                <form wire:submit="updatePassword">
                                    <div class="mb-3">
                                        <label for="currentPassword" class="form-label">Current Password</label>
                                        <input type="password" id="currentPassword" wire:model="currentPassword" class="form-control" required>
                                        @error('currentPassword') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">New Password</label>
                                        <input type="password" id="newPassword" wire:model="newPassword" class="form-control" required>
                                        @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                        <input type="password" id="confirmPassword" wire:model="confirmPassword" class="form-control" required>
                                        @error('confirmPassword') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key"></i> Change Password
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Account Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Member Since:</strong> {{ Auth::user()->created_at->format('d M Y') }}</p>
                                        <p><strong>Role:</strong> <span class="badge bg-primary">{{ ucfirst(Auth::user()->role->value) }}</span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Total Orders:</strong> {{ Auth::user()->orders()->count() }}</p>
                                        <p><strong>Last Login:</strong> {{ Auth::user()->updated_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
