<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AddController extends Controller
{
    public function addUser(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->back()
                ->with('success', 'User created successfully.');
        } catch (Exception $e) {
            Log::error('Failed To Add User: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed To Add User',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
