<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Item $item) {
        $user = auth()->user();

        $alreadyLiked = $item->likedUsers()->where('user_id', $user->id)->exists();

        if ($alreadyLiked) {
            $item->likedUsers()->detach($user->id);
        } else {
            $item->likedUsers()->attach($user->id);
        }

        return back();
    }
}
