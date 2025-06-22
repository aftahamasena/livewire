<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public $products;

    public function render()
    {
        $this->products = ProductModel::latest()->get();

        return view('livewire.product')->layout('components.layouts.app', ['title' => 'product']);
    }
}
