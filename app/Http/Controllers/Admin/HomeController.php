<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corporate;
use App\Models\Order;
use App\Models\Product;
use App\Models\Steganography;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view dashboard']);
    }
    public function index(Request $request)
    {
        if($request->start_date != '' && $request->end_date != ''){
            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);
            $orderSum = Order::whereBetween('created_at', [$start, $end])->sum('amount');
            $orderCount = Order::whereBetween('created_at', [$start, $end])->count();
            return view('page.admin-dashboard.home.index2', compact('orderSum', 'orderCount'));
        }

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
