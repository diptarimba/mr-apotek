<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $product = Product::where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
                $query->orWhere('branch_code', 'like', '%' . $search . '%');
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
            'order.*.quantity' => ['required', 'numeric', 'min:1', function ($attribute, $value, $fail) use ($request) {
                foreach ($request->order as $order) {
                    $product = Product::where('branch_code', $order['branch_code'])->first();
                    if ($product && $order['quantity'] > $product->quantity) {
                        $fail('The quantity order must not be greater than ' . $product->quantity . ' for branch_code ' . $order['branch_code']);
                    }
                }
            }],
            'customer_pay' => 'required|numeric|min:0',
            'notes' => 'nullable'
        ]);

        try {
            DB::beginTransaction();
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
                $totalQuantity = $eachProduct['quantity'];
                $product = Product::where('id', $eachProduct['product_id'])->first();
                $product->decrement('quantity', $totalQuantity);
                $product->product_history()->create(array_merge($eachProduct, [
                    'type' => "SOLD",
                ]));

                // mengurangi multiple tracker ketika sistemnya fifo
                // dan ketika orderannya banyak
                $tracker = $product->product_tracker()->oldest()->get();
                foreach ($tracker as $eachTracker) {
                    if ($totalQuantity > 0) {
                        if ($totalQuantity >= $eachTracker->quantity_received) {
                            $eachTracker->sold_all();
                            $totalQuantity -= $eachTracker->quantity_received;
                        } else {
                            $eachTracker->decrement('quantity_received', $totalQuantity);
                            $eachTracker->increment("quantity_sold", $totalQuantity);
                            break;
                        }
                    }
                }

                $order->order_product()->create($eachProduct);
            }
            DB::commit();

            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], 400);
        }
    }
}
