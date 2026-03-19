<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Webhook;

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
    public function checkout(Item $item, PurchaseRequest $request) {
        $validated = $request->validated();
        $user = $request->user();

        $zipCode = $validated['zipcode'] ?? $user->zipcode ?? '';
        $address = $validated['address'] ?? $user->address ?? '';
        $building = $validated['building'] ?? $user->building ?? '';

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodTypes = match ($validated['payment_method']) {
            'card' => ['card'],
            'konbini' => ['konbini'],
        };

        $sessionParams = [
            'mode' => 'payment',
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int) $item->price,
                    'product_data' => [
                        'name' => (string) $item->item_name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'item_id' => (string) $item->id,
                'user_id' => (string) auth()->id(),
                'selected_payment_method' => (string) $validated['payment_method'],
                'zipcode' => (string) ($zipCode ?? ''),
                'address' => (string) ($address ?? ''),
                'building' => (string) ($building ?? ''),
            ],
            'success_url' => config('app.url') . '/purchase/success?session_id={CHECKOUT_SESSION_ID}',
        ];

        if ($validated['payment_method'] === 'konbini') {
            $sessionParams['payment_method_options'] = [
                'konbini' => [
                    'expires_after_days' => 3,
                ],
            ];
        }

        $session = Session::create($sessionParams);

        return redirect($session->url);
    }


    public function success() {
        return view('purchase.success');
    }
}