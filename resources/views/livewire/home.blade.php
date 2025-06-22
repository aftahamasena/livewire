<div>
    <div class="container py-4">
        <!-- Header with Logout Button -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Daftar Produk</h2>
            </div>
            <div class="col-md-4 text-end">
                <div class="btn-group" role="group">
                    <a href="/profile" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <a href="/orders" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-list"></i> Orders
                    </a>
                    <form method="POST" action="/logout" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                @if ($successMessage)
                    <div class="alert alert-success">{{ $successMessage }}</div>
                @endif
                @if ($errorMessage)
                    <div class="alert alert-danger">{{ $errorMessage }}</div>
                @endif

                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                @if($product->picture)
                                    <img src="{{ $product->picture_url }}"
                                         class="card-img-top"
                                         alt="{{ $product->name }}"
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                    <p class="card-text"><strong>Harga:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="card-text"><strong>Stok:</strong> {{ $product->stock }}</p>

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <label class="form-label mb-0">Jumlah:</label>
                                        <input type="number"
                                               min="1"
                                               max="{{ $product->stock }}"
                                               wire:model="orderQuantity.{{ $product->id }}"
                                               class="form-control"
                                               style="width: 80px;"
                                               @if($product->stock < 1) disabled @endif />
                                    </div>

                                    <button class="btn btn-primary"
                                            wire:click="addToCart({{ $product->id }})"
                                            @if($product->stock < 1) disabled @endif>
                                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-shopping-cart"></i> Keranjang Belanja
                            @if($this->getCartCount() > 0)
                                <span class="badge bg-primary">{{ $this->getCartCount() }}</span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(empty($cart))
                            <p class="text-muted">Keranjang kosong</p>
                        @else
                            @foreach($cart as $productId => $item)
                                <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                                    <div>
                                        <h6 class="mb-0">{{ $item['name'] }}</h6>
                                        <small class="text-muted">
                                            Rp{{ number_format($item['price'], 0, ',', '.') }} x {{ $item['quantity'] }}
                                        </small>
                                    </div>
                                    <div class="d-flex align-items-center gap-1">
                                        <input type="number"
                                               min="1"
                                               max="{{ $item['stock'] }}"
                                               value="{{ $item['quantity'] }}"
                                               class="form-control form-control-sm"
                                               style="width: 60px;"
                                               wire:change="updateCartQuantity({{ $productId }}, $event.target.value)" />
                                        <button class="btn btn-sm btn-danger" wire:click="removeFromCart({{ $productId }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong>Rp{{ number_format($this->getCartTotal(), 0, ',', '.') }}</strong>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success" wire:click="addOrder">
                                    <i class="fas fa-check"></i> Checkout
                                </button>
                                <button class="btn btn-outline-danger" wire:click="clearCart">
                                    <i class="fas fa-trash"></i> Kosongkan Keranjang
                                </button>
                                <button class="btn btn-warning" wire:click="testCheckout">
                                    <i class="fas fa-bug"></i> Test Checkout
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Confirmation Modal -->
        @if ($showOrderModal)
            <div class="modal fade show d-block" tabindex="-1" style="background:rgba(0,0,0,0.5); z-index: 1050;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Order</h5>
                            <button type="button" class="btn-close" wire:click="closeOrderModal"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Detail Order:</h6>
                            @foreach($cart as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $item['name'] }} x {{ $item['quantity'] }}</span>
                                    <span>Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total Order:</strong>
                                <strong>Rp{{ number_format($this->getCartTotal(), 0, ',', '.') }}</strong>
                            </div>
                            <p class="text-muted mt-3">Pastikan semua detail order sudah benar sebelum melanjutkan.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeOrderModal">Batal</button>
                            <button type="button" class="btn btn-warning" wire:click="testCheckout">
                                <i class="fas fa-bug"></i> Test
                            </button>
                            <button type="button" class="btn btn-success" wire:click="placeOrder" onclick="console.log('Checkout button clicked!')">
                                <i class="fas fa-check"></i> Konfirmasi Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
