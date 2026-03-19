<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        return view('items.profile', compact('user'));
    }

    public function update(ProfileRequest $request) {
        $user = Auth::user();
        $validated = $request->validated();

        if ($request->hasFile('icon_img')) {

            if ($user->icon_img && Storage::disk('public')->exists($user->icon_img)) {
                Storage::disk('public')->delete($user->icon_img);
            }

            $imagePath = $request->file('icon_img')->store('users', 'public');

            $user->icon_img = $imagePath;
        }

        $user->name = $validated['name'];
        $user->zipcode = $validated['zipcode'];
        $user->address = $validated['address'];
        $user->building = $request->building ?? null;

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'プロフィールを更新しました');
    }
}