@extends('layout.app')


@section('page-link', route('admin.invoice-product.index', $invoice->id))
@section('page-title', 'Data')
@section('sub-page-title', 'Invoice Product')

@section('content')
<div class="mb-3">
    <x-button.cancel url="{{ route('admin.invoice.edit', $invoice->id) }}" colour="sky" label="Kembali"/>
</div>
    <x-util.card :title="'Invoice Product' . ($invoice->approved_at == null ? ' (Add Product)' : '')"
        :add="($invoice->approved_at == null ? true : false)"
        :url="($invoice->approved_at == null ? route('admin.invoice-product.create', $invoice->id) : null)">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Nama Produk</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Stok Dibeli</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Expired</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Harga Beli</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Total</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Action</th>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single url="{{route('admin.invoice-product.index', $invoice->id)}}">
    <x-datatables.column name="product_name"/>
    <x-datatables.column name="quantity_received"/>
    <x-datatables.column name="expired_at"/>
    <x-datatables.column name="buy_price"/>
    <x-datatables.column name="buy_amount"/>
    <x-datatables.action />
</x-datatables.single>
@endsection
