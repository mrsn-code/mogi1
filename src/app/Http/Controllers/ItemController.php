<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    public function index(Request $request) {
        $tab = $request->query('tab');

        if ($tab === 'mylist' && !Auth::check()) {
            return redirect()->route('login');
        }

        if ($tab === 'mylist' && Auth::check()) {
            $items = Auth::user()->favoriteItems()->latest()->get();
        } else {
            $items = Item::latest()->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function mypage() {
        $user = Auth::user();
        return view('items.mypage', compact('user'));
    }

    public function show(Item $item)
    {
        return view('items.detail', compact('item'));
    }

    // public function profile() {
    //     $user = Auth::user();
    //     return view('items.profile', compact('user'));
    // }
}
