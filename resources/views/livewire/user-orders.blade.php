<div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-list"></i> My Orders</h2>
                    <a href="/" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Continue Shopping
                    </a>
                </div>

                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Search Order ID:</label>
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search order...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Filter by Status:</label>
                                <select wire:model.live="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button wire:click="clearSearch" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear Filters
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">Order #{{ $order->id }}</h6>
                                        <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                    </div>
                                    <div>
                                        <span class="badge {{ $this->getStatusBadgeClass($order->status) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6>Order Items:</h6>
                                        @foreach($order->orderItems as $item)
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <strong>{{ $item->product->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        Quantity: {{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <strong>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</strong>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-4">
                                        <div class="text-end">
                                            <h6>Total:</h6>
                                            <h4 class="text-primary">Rp{{ number_format($order->total_price, 0, ',', '.') }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <h4>No Orders Found</h4>
                        <p class="text-muted">You haven't placed any orders yet.</p>
                        <a href="/" class="btn btn-primary">
                            <i class="fas fa-shopping-cart"></i> Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
