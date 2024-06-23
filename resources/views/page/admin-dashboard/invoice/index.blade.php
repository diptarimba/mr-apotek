@extends('layout.app')


@section('page-link', route('admin.invoice.index'))
@section('page-title', 'Data')
@section('sub-page-title', 'Invoice')

@section('content')
    <x-util.card title="Invoice" add url="{{route('admin.invoice.create')}}">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Supplier</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Tanggal Dibuat Invoice</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Tanggal Ditagih Invoice</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Total</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Oleh</th>
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
<x-datatables.single url="{{route('admin.invoice.index')}}">
    <x-datatables.column name="supplier_name"/>
    <x-datatables.column name="published_at"/>
    <x-datatables.column name="due_at"/>
    <x-datatables.column name="total"/>
    <x-datatables.column name="updated_by_name"/>
    <x-datatables.action />
</x-datatables.single>
@endsection
