<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{

    public function index(Request $request) {
        $tab = $request->query('tab', 'index');
        $keyword = $request->query('keyword', '');

        if ($tab === 'mylist' && !Auth::check()) {
            return redirect()->route('login');
        }

        if ($tab === 'mylist' && Auth::check()) {
            $query = Auth::user()->likedItems()->latest();
        } else {
            $query = Item::query()->latest();

            if (Auth::check()) {
                $query->where('user_id', '!=', Auth::id());
            }
        }

        if ($keyword !== '') {
            $query->where('item_name', 'like', '%' . $keyword . '%');
        }

        $items = $query->get();

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
    public function store(ExhibitionRequest $request) {

        $validated = $request->validated();

        if ($request->hasFile('item_img')) {
            $imagePath = $request->file('item_img')->store('items', 'public');
        }

        $item = Item::create([
            'user_id' => Auth::id(),
            'item_name' => $validated['item_name'],
            'brand_name' => $validated['brand_name'],
            'description' => $validated['description'],
            'item_img' => $imagePath,
            'condition' => $validated['condition'],
            'price' => $validated['price'],
        ]);

    
        $item->categories()->sync($validated['categories']);

        return redirect()->route('mypage')->with('success', '商品を出品しました。');
    }
}
