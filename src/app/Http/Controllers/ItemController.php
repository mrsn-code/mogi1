<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{

    public function index(Request $request) {
        $tab = $request->query('tab', 'index');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                return redirect()->route('login');
            }

            $query = Auth::user()->likedItems()->latest();

            if (!empty($keyword)) {
                $query->where('item_name', 'like', '%' . $keyword . '%');
            }

            $items = $query->get();
        } else {
            $query = Item::query()->latest();

            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }

            if (!empty($keyword)) {
                $query->where('item_name', 'like', '%' . $keyword . '%');
            }

            $items = $query->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    public function show(Item $item)
    {
        $item->load([
            'categories',
            'comments.user',
        ])->loadCount([
            'likedUsers',
            'comments',
        ]);
        return view('items.detail', compact('item'));
    }

    #出品画面の作成/表示
    public function create() {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    #出品画面の保存
    public function store(Request $request) {
        $validated = $request->validate([
        'item_name' => ['nullable', 'required', 'string', 'max:255'],
        'brand_name' => ['nullable', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'condition' => ['required', 'string'],
        'price' => ['required', 'integer', 'min:1'],
        'item_img' => ['nullable', 'image', 'max:2048'],
        'categories' => ['required', 'array'],
        'categories.*' => ['integer', 'exists:categories,id'],
        ]);

        $imagePath = null;

        if ($request->hasFile('item_img')) {
            $imagePath = $request->file('item_img')->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => Auth::id(),
            'item_name' => $validated['item_name'],
            'brand_name' => $validated['brand_name'] ?? null,
            'description' => $validated['description'],
            'condition' => $validated['condition'],
            'price' => $validated['price'],
            'item_img' => $imagePath ?? null,
        ]);

    
        $item->categories()->sync($validated['categories']);

        return redirect()->route('mypage')->with('success', '商品を出品しました。');
    }
}
