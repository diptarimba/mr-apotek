<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $corporate = Corporate::find(auth()->user()->corporate_id);
        $data = [
            'url' => route('corporate.company.post'),
            'home' => route('corporate.dashboard'),
            'title' => 'Profile Company'
         ];
        return view('page.corporate-dashboard.profile.index', compact('corporate', 'data'));
    }

    public function update(Request $request)
    {
        $corporate = Corporate::find(auth()->user()->corporate_id);
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/corporate', $image->hashName(), 'public');
            $request->merge(['picture' => asset('storage/public/picture/' . $image->hashName())]);
        }

        $corporate->update($request->all());

        return back()->with('success', 'Corporate updated successfully');
    }
}
