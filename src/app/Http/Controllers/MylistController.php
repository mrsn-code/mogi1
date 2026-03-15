<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MylistController extends Controller
{
    public function index()
    {
        $items = Auth::user()->likedItems()->latest()->get();

        return view('items.mylist', compact('items'));
    }
}
