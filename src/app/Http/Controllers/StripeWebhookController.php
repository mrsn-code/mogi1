<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

class StripeWebhookController extends Controller
{
     public function handle(Request $request) {
        Log::info('stripe api webhook reached');

        $payload = $request->getContent();
        $sigHeader = $request->server('HTTP_STRIPE_SIGNATURE');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            Log::error('Stripe webhook verify failed', [
                'message' => $e->getMessage(),
            ]);
            return response('Invalid webhook', Response::HTTP_BAD_REQUEST);
        }

        Log::info('Stripe webhook received', [
            'type' => $event->type,
        ]);

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $itemId = $session->metadata->item_id ?? null;
                $userId = $session->metadata->user_id ?? null;

                Log::info('Checkout completed', [
                    'session_id' => $session->id,
                    'item_id' => $itemId,
                    'user_id' => $userId,
                    'payment_method' => $session->metadata->selected_payment_method ?? null,
                ]);

                if ($itemId && $userId) {
                    $updated = Item::where('id', $itemId)
                        ->whereNull('buyer_id')
                        ->update([
                            'buyer_id' => $userId,
                        ]);

                    Log::info('buyer_id updated', [
                        'item_id' => $itemId,
                        'user_id' => $userId,
                        'updated_rows' => $updated,
                        'buyer_id_after' => Item::find($itemId)?->buyer_id,
                    ]);
                }

                break;

            case 'checkout.session.async_payment_succeeded':
                $session = $event->data->object;
                Log::info('Async payment succeeded', [
                    'session_id' => $session->id,
                ]);
                break;

            case 'checkout.session.async_payment_failed':
                $session = $event->data->object;
                Log::info('Async payment failed', [
                    'session_id' => $session->id,
                ]);
                break;

            default:
                Log::info('Unhandled Stripe event', [
                    'type' => $event->type,
                ]);
                break;
        }

        return response('ok', 200);
    }
}