<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    public function show(Item $item) {
        $user = auth()->user();

        $shippingAddress = [
            'zipcode' => session('purchase_shipping.zipcode', $user->zipcode),
            'address'     => session('purchase_shipping.address', $user->address),
            'building'    => session('purchase_shipping.building', $user->building),
        ];

        return view('purchase.show', compact('item', 'user', 'shippingAddress'));
    }
    public function store(Item $item) {
        if ($item->purchase) {
            return redirect()->route('items.show', $item)->with('error', 'この商品はすでに購入されています。');
        }

        $user = Auth::user();

        $shippingZipCode = session('purchase_shipping.zipcode', $user->zipcode);
        $shippingAddress    = session('purchase_shipping.address', $user->address);
        $shippingBuilding   = session('purchase_shipping.building', $user->building);

        if (!$shippingZipCode || !$shippingAddress) {
            return redirect()->route('purchase.show', $item)->with('error', '配送先を入力してください。');
        }

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_zipcode' => $shippingZipCode,
            'shipping_address' => $shippingAddress,
            'shipping_building' => $shippingBuilding,
        ]);

        // 購入後は一時保存した配送先を削除
        session()->forget('purchase_shipping');

        return redirect()->route('items.show', $item)->with('success', '商品を購入しました。');
    }
}
