<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage invoice']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $invoice = Invoice::with('invoice_product')->select();
            if ($request->start_date && $request->end_date) {
                $invoice->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            }

            return datatables()->of($invoice)
                ->addIndexColumn()
                ->addColumn('supplier_name', function ($query) {
                    return $query->supplier->name ?? '';
                })
                ->addColumn('status', function ($query) {
                    $status = 'Dibuat Oleh : ' . $query->user->name;
                    if ($query->approved_at != null) {
                        $status .= ' | Diapprove oleh : ' . $query->approver->name;
                    }
                    if ($query->paid_at != null) {
                        $status .= ' | Dibayar oleh : ' . $query->payer->name;
                    }
                    return $status;
                })
                ->addColumn('expired_at', function($query){
                    return $query->invoice_product->count() > 0 ? Carbon::parse($query->invoice_product->first()->expired_at)->format('d F Y') : '-';
                })
                ->addColumn('published_at', function ($query) {
                    return Carbon::parse($query->published_at)->format('d F Y');
                })
                ->addColumn('due_at', function ($query) {
                    return Carbon::parse($query->due_at)->format('d F Y');
                })
                ->addColumn('total', function ($query) {
                    return 'Rp. ' . number_format($query->total, 0, '', '.');
                })
                ->addColumn('action', function ($query) {
                    return $this->getActionColumn($query, 'invoice');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('page.admin-dashboard.invoice.index');
    }

    public function getActionColumn($data, $path = '', $prefix = 'admin')
    {
        $productInvoiceCount = $data->invoice_product()->count();
        $ident = Str::random(10);
        $editBtn = route("$prefix.$path.edit", $data->id);
        $deleteBtn = route("$prefix.$path.destroy", $data->id);
        $approveBtn = route("$prefix.$path.approve", $data->id);
        $paidBtn = route("$prefix.$path.paid", $data->id);
        $notApproved = $data->approved_at == null;
        $textEditBtn = $notApproved ? 'Edit' : 'View';
        $buttonAction = '<a href="' . $editBtn . '" class="' . self::CLASS_BUTTON_PRIMARY . '">' . $textEditBtn . '</a>';
        if (!$notApproved && $data->paid_at == null) {
            $buttonAction .= '<button type="button" onclick="pay_invoice(\'formbayar' . $ident . '\')"class="' . self::CLASS_BUTTON_INFO . '">Bayar</button>';
            $buttonAction .= '<form id="formbayar' . $ident . '" action="' . $paidBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="PATCH"> </form>';
        }
        if ($notApproved) {
            if ($productInvoiceCount > 0) {
                $buttonAction .= '<button type="button" onclick="approve_data(\'formapprove' . $ident . '\')"class="' . self::CLASS_BUTTON_SUCCESS . '">Approve</button>';
                $buttonAction .= '<form id="formapprove' . $ident . '" action="' . $approveBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="PATCH"> </form>';
            }
            $buttonAction .= '<button type="button" onclick="delete_data(\'formdelete' . $ident . '\')"class="' . self::CLASS_BUTTON_DANGER . '">Delete</button>';
            $buttonAction .= '<form id="formdelete' . $ident . '" action="' . $deleteBtn . '" method="post"> <input type="hidden" name="_token" value="' . csrf_token() . '" /> <input type="hidden" name="_method" value="DELETE"> </form>';
        }
        return $buttonAction;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = $this->createMetaPageData(null, 'Invoice', 'invoice');
        $supplier = Supplier::get()->pluck('name', 'id');
        $notApproved = null;
        return view('page.admin-dashboard.invoice.create-edit', compact('data', 'supplier', 'notApproved'));
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

        Invoice::create(array_merge($request->all(), [
            'updated_by_id' => auth()->user()->id,
            'status' => self::STATUS_INVOICE_UNPAID,
            'tax' => 0,
            'total' => 0,
            'invoice_code' => strtoupper($request->invoice_code),
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
        $notApproved = $invoice->approved_at == null;
        return view('page.admin-dashboard.invoice.create-edit', compact('data', 'invoice', 'supplier', 'notApproved'));
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

        $invoice->update(array_merge($request->all(), [
            'updated_by_id' => auth()->user()->id,
            'invoice_code' => strtoupper($request->invoice_code),
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

    public function approve(Invoice $invoice)
    {
        $invoice->update([
            'approved_at' => Carbon::now(),
            'approved_by_id' => Auth::user()->id,
        ]);

        $invoice->invoice_product()->each(function ($query) {
            $query->product()->increment('quantity', $query->quantity_received);
            $query->product->product_history()->create([
                'type' => "RECEIVED",
                'quantity' => $query->quantity_received,
            ]);
        });
        return redirect()->route('admin.invoice.index')->with('success', 'Invoice has been approved');
    }

    public function paid(Invoice $invoice)
    {
        $invoice->update([
            'paid_at' => Carbon::now(),
            'paid_by_id' => Auth::user()->id,
        ]);

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice has been paid');
    }
}
