@extends('layout.app')


@section('page-link', route('admin.order.index'))
@section('page-title', 'Order')
@section('sub-page-title', 'Detail')

@section('content')
    <x-util.card title="Product">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Nama Produk</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Kuantitas</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Harga</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Subtotal</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Catatan</th>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600 sorting_1 dtr-control">
                        Total:</th>
                    <th colspan="2"class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0"></th>
                </tr>
            </tfoot>
        </table>
    </x-util.card>
@endsection

@section('custom-footer')
<x-datatables.single url="{{route('admin.order.detail', $order->id)}}">
    <x-slot name="customdatatables">
        footerCallback: function(row, data, start, end, display) {
            var api = this.api(),
                data;
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };
            var total = api
                .column(4)
                .data()
                .reduce(function(a, b) {
                    if (typeof a === 'string') {
                        a = a.replace(".", "")
                    }
                    if (typeof b === 'string') {
                        b = b.replace(".", "")
                    }
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(5).footer()).html(
                new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(total)
            );
        },
    </x-slot>
    <x-datatables.column name="product.name"/>
    <x-datatables.column name="quantity"/>
    <x-datatables.column name="price"/>
    <x-datatables.column name="amount"/>
    <x-datatables.column name="notes"/>
</x-datatables.single>
@endsection
