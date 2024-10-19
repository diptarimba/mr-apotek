<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage order']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $order = Order::select();
            return datatables()->of($order)
            ->addIndexColumn()
            ->addColumn('created_at', function($query){
                return $query->created_at->format('d F Y H:i:s');
            })
            ->addColumn('amount', function($query){
                return '<div class="flex justify-between"><span>Rp.</span><span>'.number_format($query->amount, 0, '', '.').'</span></div>';
            })
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'order', 'admin');
            })
            ->rawColumns(['action', 'amount'])
            ->make(true);
        }

        return view('page.admin-dashboard.order.index');
    }

    public function getActionColumn($data, $path = '', $prefix = 'admin')
    {
        $detailBtn = route("$prefix.$path.detail", $data->id);
        $buttonAction = '<a href="' . $detailBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">View Detail</a>';
        return $buttonAction;
    }

    public function detail(Order $order, Request $request)
    {
        if ($request->ajax())
        {
            $order = OrderProduct::with('product')->where('order_id', $order->id)->select();
            return datatables()->of($order)
            ->addIndexColumn()
            ->addColumn('quantity', function($query){
                return number_format($query->quantity, 0, '', '.');
            })
            ->addColumn('price', function($query){
                return number_format($query->price, 0, '', '.');
            })
            ->addColumn('amount', function($query){
                return number_format($query->amount, 0, '', '.');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.order.detail', compact('order'));
    }
}
