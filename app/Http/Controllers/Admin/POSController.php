<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $search = $request->search;
            $product = Product::where(function($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%');
                $query->orWhere('branch_code', 'like', '%'.$search.'%');
            })->get()->take(5);

            return response()->json([
                'data' => $product
            ]);
        }
        return view('page.admin-dashboard.pos.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*.branch_code' => 'exists:products,branch_code',
            'order.*.notes' => 'nullable',
            'order.*.quantity' => ['required','numeric','min:1',function($attribute, $value, $fail) use ($request) {
                foreach ($request->order as $order) {
                    $product = Product::where('branch_code', $order['branch_code'])->first();
                    if ($product && $value > $product->quantity) {
                        $fail('The '.$attribute.' must not be greater than '.$product->quantity.' for branch_code '.$order['branch_code']);
                    }
                }
            }],
            'customer_pay' => 'required|numeric|min:0',
            'notes' => 'nullable'
        ]);

        $order = $request->order;
        $total = 0;
        $putOrderProduct = [];
        foreach ($order as $key => $value) {
            $orderProduct = [];
            $product = Product::where('branch_code', $value['branch_code'])->first();
            $orderProduct['product_id'] = $product->id;
            $orderProduct['quantity'] = $value['quantity'];
            $orderProduct['price'] = $product->sell_price;
            $orderProduct['notes'] = $value['notes'];
            $orderProduct['amount'] = $value['quantity'] * $product->sell_price;
            $total += $orderProduct['amount'];
            $putOrderProduct[] = $orderProduct;
        }

        $change = $request->customer_pay - $total;

        $order = Order::create([
            'notes' => $request->notes,
            'amount' => $total,
            'customer_pay' => $request->customer_pay,
            'change' => $change,
        ]);

        foreach ($putOrderProduct as $eachProduct) {
            $order->order_product()->create($eachProduct);
        }

        return response()->json([
            'success' => true
        ]);
    }
}
