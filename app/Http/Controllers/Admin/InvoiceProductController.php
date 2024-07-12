<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductTracker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Invoice $invoice, Request $request)
    {
        if($request->ajax())
        {
            $product = $invoice->invoice_product()->select();
            return datatables()->of($product)
            ->addIndexColumn()
            ->addColumn('product_name', function($query){
                return $query->product->name ?? '';
            })
            ->addColumn('expired_at', function($query){
                return Carbon::parse($query->expired_at)->format('d F Y');
            })
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'invoice-product');
            })
            ->addColumn('quantity_received', function($query){
                return number_format($query->quantity_received, 0, '', '.') . ' ' . $query->product->unit->name;
            })
            ->addColumn('buy_price', function($query){
                return 'Rp. '.number_format($query->buy_price, 0, '', '.');
            })
            ->addColumn('buy_amount', function($query){
                return 'Rp. '.number_format($query->buy_amount, 0, '', '.');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.invoice.product.index', compact('invoice'));
    }

    public function getActionColumn($data, $path = '', $prefix = 'admin')
    {
        $data->load('invoice');
        $ident = Str::random(10);
        $notApproved = $data->invoice->approved_at == null;
        $textEditBtn = $notApproved ? 'Edit' : 'View';
        $editBtn = route("$prefix.$path.edit", ['product' =>$data->id, 'invoice' => $data->invoice_id]);
        $deleteBtn = route("$prefix.$path.destroy", ['product' =>$data->id, 'invoice' => $data->invoice_id]);
        $buttonAction = '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">'.$textEditBtn.'</a>';
        if($notApproved){
            $buttonAction .= '<button type="button" onclick="delete_data(\'form' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>' . '<form id="form' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
        }
        return $buttonAction;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Invoice $invoice)
    {
        $data = [
            'home' => route('admin.invoice-product.index', ['invoice' => $invoice->id]),
            'url' => route('admin.invoice-product.store', ['invoice' => $invoice->id]),
            'title' => 'Add Product to Invoice'
        ];
        $productResource = Product::get()->pluck('name', 'id');
        return view('page.admin-dashboard.invoice.product.create-edit', compact('invoice', 'data', 'productResource'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Invoice $invoice, Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_received' => 'required|numeric|min:0',
            'buy_price' => 'required|numeric|min:0',
            'buy_notes' => 'nullable',
            'expired_at' => 'required',
        ]);

        $calculateBuyAmount = $request->quantity_received * $request->buy_price;

        $invoice->invoice_product()->create(array_merge($request->all(), [
            'invoice_id' => $invoice->id,
            'buy_amount' => $calculateBuyAmount
        ]));

        $invoice->increment('total', $calculateBuyAmount);

        return redirect()->route('admin.invoice.index', ['invoice' => $invoice->id])->with('success', 'Product has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductTracker $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice, ProductTracker $product)
    {
        $data = [
            'home' => route('admin.invoice-product.index', ['invoice' => $invoice->id]),
            'url' => route('admin.invoice-product.update', ['invoice' => $invoice->id, 'product' => $product->id]),
            'title' => 'Add Product to Invoice'
        ];
        $productResource = Product::get()->pluck('name', 'id');
        $notApproved = $invoice->approved_at == null;
        return view('page.admin-dashboard.invoice.product.create-edit', compact('product', 'data', 'productResource', 'notApproved'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Invoice $invoice, Request $request, ProductTracker $product)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_received' => 'required|numeric|min:0',
            'buy_price' => 'required|numeric|min:0',
            'buy_notes' => 'nullable',
            'expired_at' => 'required',
        ]);

        $invoice->decrement('total', $product->buy_amount);

        $calculateBuyAmount = $request->quantity_received * $request->buy_price;

        $product->update(array_merge($request->all(), [
            'invoice_id' => $invoice->id,
            'buy_amount' => $calculateBuyAmount
        ]));

        $invoice->increment('total', $calculateBuyAmount);

        return redirect()->route('admin.invoice-product.index', ['invoice' => $invoice->id])->with('success', 'Product has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice, ProductTracker $product)
    {
        try {
            $invoice->decrement('total', $product->buy_amount);
            $product->delete();
            return redirect()->route('admin.invoice-product.index', ['invoice' => $invoice->id])->with('success', 'Product has been deleted');
        } catch (\Throwable $th) {
            return redirect()->route('admin.invoice-product.index', ['invoice' => $invoice->id])->with('error', 'Product has not been deleted');
        }
    }
}
