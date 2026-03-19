<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
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

    public function update(AddressRequest $request, Item $item)
    {
        if ($item->purchase) {
            return redirect()->route('items.show', $item)->with('error', 'この商品はすでに購入されています。');
        }

        $validated = $request->validated();

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
