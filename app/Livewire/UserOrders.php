<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class UserOrders extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function render()
    {
        $orders = Order::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->with(['orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.user-orders', [
            'orders' => $orders
        ]);
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->statusFilter = '';
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            'pending' => 'bg-warning',
            'processing' => 'bg-info',
            'completed' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}
