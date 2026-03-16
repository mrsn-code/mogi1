<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show(Item $item) {
        $user = auth()->user();
        return view('purchase.show', compact('item', 'user'));
    }
}
