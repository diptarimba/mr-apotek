<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use App\Models\Order;
use App\Models\Product;
use App\Models\Steganography;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();
        $sumOrderToday = Order::whereDate('created_at','>=', $today)->sum('amount');
        $lastDay = now()->subDay()->startOfDay();
        $sumOrderLastDay = Order::whereDate('created_at', '<', $today)->whereDate('created_at', '>=', $lastDay)->sum('amount');
        $lastMonth = now()->subMonth()->startOfMonth();
        $sumOrderLastMonth = Order::whereDate('created_at', '>=', $lastMonth)->sum('amount');

        $productCount = Product::count();
        $orderCount = Order::count();
        return view('page.admin-dashboard.home.index', compact('sumOrderToday', 'sumOrderLastDay', 'sumOrderLastMonth', 'productCount', 'orderCount'));
    }
}
