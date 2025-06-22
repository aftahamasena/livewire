<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Home extends Component
{
    public $cart = [];
    public $showOrderModal = false;
    public $successMessage = null;
    public $errorMessage = null;
    public $orderQuantity = [];

    public function mount()
    {
        $this->cart = session('cart', []);
        $this->initializeOrderQuantity();
    }

    public function initializeOrderQuantity()
    {
        $products = Product::all();
        foreach ($products as $product) {
            if (!isset($this->orderQuantity[$product->id])) {
                $this->orderQuantity[$product->id] = 1;
            }
        }
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.home', [
            'products' => $products,
        ]);
    }

    public function addToCart($productId)
    {
        try {
            $product = Product::find($productId);
            if (!$product) {
                $this->errorMessage = 'Produk tidak ditemukan.';
                return;
            }

            $quantity = $this->orderQuantity[$productId] ?? 1;

            if ($quantity < 1) {
                $this->errorMessage = 'Jumlah minimal adalah 1.';
                return;
            }

            if ($quantity > $product->stock) {
                $this->errorMessage = 'Jumlah melebihi stok yang tersedia.';
                return;
            }

            // Add to cart
            if (isset($this->cart[$productId])) {
                $this->cart[$productId]['quantity'] += $quantity;
            } else {
                $this->cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'stock' => $product->stock
                ];
            }

            // Update session
            session(['cart' => $this->cart]);

            $this->successMessage = 'Produk berhasil ditambahkan ke keranjang!';
            $this->errorMessage = null;

            Log::info('Product added to cart: ' . $product->name . ' x' . $quantity);
        } catch (\Exception $e) {
            $this->errorMessage = 'Error: ' . $e->getMessage();
            Log::error('Error in addToCart: ' . $e->getMessage());
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            session(['cart' => $this->cart]);
            $this->successMessage = 'Produk dihapus dari keranjang.';
        }
    }

    public function updateCartQuantity($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            if ($quantity < 1) {
                $quantity = 1;
            }

            $product = Product::find($productId);
            if ($quantity > $product->stock) {
                $this->errorMessage = 'Jumlah melebihi stok yang tersedia.';
                return;
            }

            $this->cart[$productId]['quantity'] = $quantity;
            session(['cart' => $this->cart]);
        }
    }

    public function addOrder()
    {
        if (empty($this->cart)) {
            $this->errorMessage = 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.';
            return;
        }

        try {
            $user = Auth::user();
            $total = 0;

            // Calculate total and validate stock
            foreach ($this->cart as $productId => $item) {
                $product = Product::find($productId);
                if (!$product) {
                    $this->errorMessage = 'Produk tidak ditemukan: ' . $item['name'];
                    return;
                }

                if ($item['quantity'] > $product->stock) {
                    $this->errorMessage = 'Stok tidak cukup untuk: ' . $product->name;
                    return;
                }

                $total += $product->price * $item['quantity'];
            }

            // Debug: Log the total calculation
            Log::info('Total calculated in addOrder: ' . $total);
            Log::info('Cart contents: ' . json_encode($this->cart));

            // Create order - menggunakan total_price bukan total_amount
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total, // Ubah dari total_amount ke total_price
                'status' => 'pending',
                'order_date' => now(),
            ]);

            // Debug: Log the created order
            Log::info('Order created with total_price: ' . $order->total_price);

            // Create order items
            foreach ($this->cart as $productId => $item) {
                $product = Product::find($productId);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ]);

                // Update product stock
                $product->decrement('stock', $item['quantity']);
            }

            // Clear cart
            $this->cart = [];
            session()->forget('cart');

            $this->successMessage = 'Order berhasil dibuat! Total: Rp' . number_format($total, 0, ',', '.');
            $this->errorMessage = null;

            Log::info('Order created successfully: ' . $order->id . ' with total: ' . $total);

        } catch (\Exception $e) {
            $this->errorMessage = 'Error: ' . $e->getMessage();
            Log::error('Error in addOrder: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }


    public function placeOrder()
    {
        // Debug: Pastikan method dipanggil
        $this->successMessage = 'placeOrder method dipanggil!';
        Log::info('=== PLACE ORDER METHOD CALLED ===');
        Log::info('Cart contents: ' . json_encode($this->cart));

        // If cart is empty, just return
        if (empty($this->cart)) {
            $this->errorMessage = 'Keranjang kosong.';
            Log::warning('Cart is empty in placeOrder');
            return;
        }

        try {
            $user = Auth::user();
            Log::info('User: ' . $user->id . ' - ' . $user->name);

            $total = 0;

            // Calculate total and validate stock
            foreach ($this->cart as $productId => $item) {
                $product = Product::find($productId);
                if (!$product) {
                    $this->errorMessage = 'Produk tidak ditemukan: ' . $item['name'];
                    Log::error('Product not found: ' . $productId);
                    return;
                }

                if ($item['quantity'] > $product->stock) {
                    $this->errorMessage = 'Stok tidak cukup untuk: ' . $product->name;
                    Log::error('Insufficient stock for: ' . $product->name);
                    return;
                }

                $total += $product->price * $item['quantity'];
                Log::info('Product: ' . $product->name . ' - Qty: ' . $item['quantity'] . ' - Price: ' . $product->price);
            }

            Log::info('Total calculated: ' . $total);

            // Create order - menggunakan string langsung
            Log::info('Creating order...');
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', // Gunakan string langsung
                'total_price' => $total,
            ]);

            Log::info('Order created with ID: ' . $order->id);

            // Create order items and update stock
            foreach ($this->cart as $productId => $item) {
                $product = Product::find($productId);

                Log::info('Creating order item for product: ' . $product->name);
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                Log::info('Order item created: ' . $orderItem->id);

                // Decrease stock
                $product->decrement('stock', $item['quantity']);
                Log::info('Stock decreased for: ' . $product->name . ' by ' . $item['quantity']);
            }

            // Clear cart
            $this->cart = [];
            session()->forget('cart');

            $this->showOrderModal = false;
            $this->successMessage = 'Order berhasil dibuat! Order ID: ' . $order->id;
            $this->errorMessage = null;

            Log::info('Order completed successfully: ' . $order->id);
        } catch (\Exception $e) {
            $this->errorMessage = 'Error: ' . $e->getMessage();
            Log::error('Error in placeOrder: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    public function createOrder()
    {
        // Simple method to test order creation
        try {
            if (empty($this->cart)) {
                $this->errorMessage = 'Keranjang kosong.';
                return;
            }

            $user = Auth::user();
            $total = 0;

            // Calculate total
            foreach ($this->cart as $productId => $item) {
                $product = Product::find($productId);
                $total += $product->price * $item['quantity'];
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', // Gunakan string langsung
                'total_price' => $total,
            ]);

            // Create order items
            foreach ($this->cart as $productId => $item) {
                $product = Product::find($productId);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Decrease stock
                $product->decrement('stock', $item['quantity']);
            }

            // Clear cart
            $this->cart = [];
            session()->forget('cart');

            $this->showOrderModal = false;
            $this->successMessage = 'Order berhasil dibuat! Order ID: ' . $order->id;

        } catch (\Exception $e) {
            $this->errorMessage = 'Error: ' . $e->getMessage();
            Log::error('Error in createOrder: ' . $e->getMessage());
        }
    }

    public function closeOrderModal()
    {
        $this->showOrderModal = false;
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    public function clearCart()
    {
        $this->cart = [];
        session()->forget('cart');
        $this->successMessage = 'Keranjang berhasil dikosongkan.';
    }

    public function getCartTotal()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getCartCount()
    {
        return count($this->cart);
    }

    public function testMethod()
    {
        $this->successMessage = 'Test method called successfully!';
        Log::info('Test method called');
    }

    public function testCheckout()
    {
        $this->successMessage = 'Test checkout method called!';
        Log::info('Test checkout method called');

        // Test jika cart ada isi
        if (!empty($this->cart)) {
            $this->successMessage .= ' Cart has ' . count($this->cart) . ' items.';
        } else {
            $this->errorMessage = 'Cart is empty!';
        }
    }

    public function simplePlaceOrder()
    {
        $this->dispatch('showAlert', 'Simple placeOrder called!');
        $this->successMessage = 'Simple placeOrder method called!';
        Log::info('Simple placeOrder called');
    }

    public function checkoutTest()
    {
        $this->dispatch('showAlert', 'Checkout test method called!');
        $this->successMessage = 'Checkout test method called!';
        Log::info('Checkout test method called');

        // If this works, then call the real placeOrder
        $this->placeOrder();
    }
}
