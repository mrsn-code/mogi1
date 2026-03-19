<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    public function edit(Item $item)
    {
        if ($item->purchase) {
            return redirect()->route('items.show', $item)->with('error', 'この商品はすでに購入されています。');
        }

        $user = Auth::user();

        $shippingAddress = [
            'zipcode' => session('purchase_shipping.zipcode', $user->zipcode),
            'address'     => session('purchase_shipping.address', $user->address),
            'building'    => session('purchase_shipping.building', $user->building),
        ];

        return view('purchase.address_edit', compact('item', 'shippingAddress'));
    }

    public function update(Request $request, Item $item)
    {
        if ($item->purchase) {
            return redirect()->route('items.show', $item)->with('error', 'この商品はすでに購入されています。');
        }

        $validated = $request->validate([
            'zipcode' => ['required', 'string', 'max:20'],
            'address'     => ['required', 'string', 'max:255'],
            'building'    => ['nullable', 'string', 'max:255'],
        ]);

        session([
            'purchase_shipping' => [
                'zipcode' => $validated['zipcode'],
                'address'     => $validated['address'],
                'building'    => $validated['building'] ?? null,
            ]
        ]);

        return redirect()->route('purchase.show', $item)->with('success', '配送先を変更しました。');
    }
}
