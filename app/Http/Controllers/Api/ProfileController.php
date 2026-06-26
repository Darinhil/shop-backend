<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json($request->user());
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
