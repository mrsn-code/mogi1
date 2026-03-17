<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();
        $tab = $request->query('tab', 'sell'); 

        if ($tab === 'buy') {
            $items = $user->purchasedItems()->latest()->get();
        } else {
            $tab = 'sell';
            $items = $user->sellingItems()->latest()->get();
        }

        return view('items.mypage', compact('user', 'tab', 'items'));
    }
}