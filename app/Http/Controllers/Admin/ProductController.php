<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage product']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $product = Product::select();
            return datatables()->of($product)
            ->addIndexColumn()
            ->addColumn('image', function($query){
                return '<img src="'.$query->image.'" class="img-thumbnail" width="100" height="100"/>';
            })
            ->addColumn('quantity', function($query){
                return '<div class="flex justify-end"><span>'.number_format($query->quantity, 0, '', '.').'</span></div>';
            })
            ->addColumn('price', function($query){
                return '<div class="flex justify-between"><span>Rp.</span><span>'.number_format($query->sell_price, 0, '', '.').'</span></div>';
            })
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'product');
            })
            ->rawColumns(['action', 'image', 'price', 'quantity'])
            ->make(true);
        }

        return view('page.admin-dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Product', 'product');
        $unit = Unit::get()->pluck('name', 'id');
        return view('page.admin-dashboard.product.create-edit', compact('unit', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit_id' => 'exists:units,id',
            'branch_code' => 'required',
            'sell_price' => 'required',
            'image' => 'nullable|max:2048|mimes:jpg,jpeg,png'
        ]);

        $dataPost = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/product', $image->hashName(), 'public');
            $dataPost = array_merge($dataPost, ['image' => asset('storage/public/product/' . $image->hashName())]);
        } else {
            $dataPost = array_merge($dataPost, ['image' => asset('assets-dashboard/images/not-found.png')]);
        }

        Product::create(array_merge($dataPost, [
            'branch_code' => strtoupper($dataPost['branch_code']),
            'quantity' => 0
        ]));

        return redirect()->route('admin.product.index')->with('success', 'Successfully Created Product');

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data = $this->createMetaPageData($product->id, 'Product', 'product');
        $unit = Unit::get()->pluck('name', 'id');
        return view('page.admin-dashboard.product.create-edit', compact('product', 'data', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'unit_id' => 'exists:units,id',
            'branch_code' => 'required',
            // 'quantity' => 'required|numeric|min:0',
            'sell_price' => 'required',
            'image' => 'sometimes|max:2048|mimes:jpg,jpeg,png'
        ]);

        $dataPost = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/product', $image->hashName(), 'public');
            $dataPost = array_merge($dataPost, ['image' => asset('storage/public/product/' . $image->hashName())]);
        }

        $product->update(array_merge($dataPost, [
            'branch_code' => strtoupper($dataPost['branch_code']),
        ]));

        return redirect()->route('admin.product.index')->with('success', 'Successfully Update Product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('admin.product.index')->with('success', 'Successfully Deleted Product');
        } catch (\Exception $e) {
            return redirect()->route('admin.product.index')->with('error', $e->getMessage());
        }
    }
}
