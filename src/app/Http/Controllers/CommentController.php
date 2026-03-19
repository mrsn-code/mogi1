<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item) {
        $item->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request['comment'],
        ]);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'コメントを投稿しました。');
    }
}
// class CommentController extends Controller
// {
//     public function store(Request $request, Item $item) {
//         $validated = $request->validate([
//             'body' => ['required', 'string', 'max:1000'],
//         ]);

//         $item->comments()->create([
//             'user_id' => auth()->id(),
//             'body' => $validated['body'],
//         ]);

//         return redirect()
//             ->route('items.show', $item)
//             ->with('success', 'コメントを投稿しました。');
//     }
// }
