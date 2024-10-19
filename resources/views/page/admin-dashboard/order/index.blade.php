@extends('layout.app')


@section('page-link', route('admin.order.index'))
@section('page-title', 'Data')
@section('sub-page-title', 'Order')

@section('content')
    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form.base>
            <x-form.input name="daterange" label="Filter Tanggal" placeholder="" value="" />
        </x-form.base>
    </div>
    <x-util.card title="Order">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Tanngal Transaksi
                    </th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Jumlah</th>
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
    <x-datatables.single url="{{ route('admin.order.index') }}" needrange="true">
        <x-datatables.column name="created_at" />
        <x-datatables.column name="amount" />
        <x-datatables.action />
    </x-datatables.single>
@endsection
