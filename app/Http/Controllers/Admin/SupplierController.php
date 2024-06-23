<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $supplier = Supplier::select();
            return datatables()->of($supplier)
            ->addIndexColumn()
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'supplier');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Supplier', 'supplier');
        return view('page.admin-dashboard.supplier.create-edit', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $data = $this->createMetaPageData($supplier->id, 'Supplier', 'supplier');
        return view('page.admin-dashboard.supplier.create-edit', compact('data', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required',
            'contact_name' => 'required',
            'contact_number' => 'required',
        ]);

        $supplier->update($request->all());

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->route('admin.supplier.index')->with('success', 'Supplier has been deleted');
        } catch (\Throwable $th) {
            return redirect()->route('admin.supplier.index')->with('error', 'Supplier cannot be deleted. Cause : ' . $th->getMessage());
        }
    }
}
