<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use App\Models\Steganography;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $countEncrypted = Steganography::count();
        $countCorporate = Corporate::count();
        $countAllUserCorporate = User::where('corporate_id', '!=', null)->count();
        return view('page.admin-dashboard.home.index', compact('countEncrypted', 'countCorporate', 'countAllUserCorporate'));
    }
}
