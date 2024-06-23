<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Supplier;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $invoice = Invoice::select();
            return datatables()->of($invoice)
            ->addIndexColumn()
            ->addColumn('supplier_name', function($query){
                return $query->supplier->name ?? '';
            })
            ->addColumn('updated_by_name', function($query){
                return $query->user->name ?? '';
            })
            ->addColumn('action', function($query){
                return $this->getActionColumn($query, 'invoice');
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('page.admin-dashboard.invoice.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Invoice', 'invoice');
        $supplier = Supplier::get()->pluck('name', 'id');
        return view('page.admin-dashboard.invoice.create-edit', compact('data', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'invoice_code' => 'required',
            'supplier_id' => 'required',
            'published_at' => 'required',
            'due_at' => 'required',
        ]);

        Invoice::create(array_merge($request->all(),[
            'updated_by_id' => auth()->user()->id,
            'status' => self::STATUS_INVOICE_UNPAID,
            'tax' => 0,
            'total' => 0,
        ]));

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $data = $this->createMetaPageData($invoice->id, 'Invoice', 'invoice');
        $supplier = Supplier::get()->pluck('name', 'id');
        return view('page.admin-dashboard.invoice.create-edit', compact('data', 'invoice', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'invoice_code' => 'required',
            'supplier_id' => 'required',
            'published_at' => 'required',
            'due_at' => 'required',
        ]);

        $invoice->update(array_merge($request->all(),[
            'updated_by_id' => auth()->user()->id,
        ]));

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        try {
            $invoice->delete();
            return redirect()->route('admin.invoice.index')->with('success', 'Invoice has been deleted');
        } catch (\Throwable $th) {
            return redirect()->route('admin.invoice.index')->with('error', 'Invoice cannot be deleted');
        }
    }
}
