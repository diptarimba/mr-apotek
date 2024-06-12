<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;
use App\Models\Steganography;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $encDoc = Steganography::whereHas('user', function($query){
            $query->where('corporate_id', auth()->user()->corporate_id);
        })->count();

        $allUser = User::where('corporate_id', auth()->user()->corporate_id)->count();
        return view('page.corporate-dashboard.home.index', compact('encDoc', 'allUser'));
    }
}
