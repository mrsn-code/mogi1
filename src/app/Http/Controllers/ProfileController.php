<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        return view('items.profile', compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();

        // $validated = $request->validated();

        $user->name = $request['name'];
        $user->zipcode = $request['zipcode'] ?? null;
        $user->address = $request['address'] ?? null;
        $user->building = $request['building'] ?? null;


        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'プロフィールを更新しました');
    }
}
