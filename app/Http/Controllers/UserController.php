<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request) {
        try {
            $request->validate([
                'name' => 'required',
                'username' => 'required',
                'password' => 'required',
                'email' => 'required',
                'phone' => 'required'
            ]);

            $user = User::create(array_merge($request->all(), [
                'password' => bcrypt($request->password),
                'picture' => asset('assets-dashboard/images/placeholder.png')
            ]));
            $user->assignRole('admin');

            return response()->json($user, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

    }
}
