@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Supplier')
@section('sub-page-title', Str::endsWith(request()->route()->getName(), '.edit') ? 'Edit' : 'Create')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="invoice_code" label="Nomor Invoice" placeholder="input invoice code" value="{{ $invoice->invoice_code ?? '' }}"/>
            <x-form.input name="published_at" label="Tanggal Invoice" type="date" placeholder="input product name"
                value="{{ $invoice->published_at ?? '' }}" />
            <x-form.input name="due_at" label="Tanggal Penagihan" type="date" placeholder="input contact name"
                value="{{ $invoice->due_at ?? '' }}" />
            <x-form.select name="supplier_id" title="Supplier"
                value="{{ $invoice->supplier_id ?? (request()->get('supplier_id') ?? '') }}" data="{!! $supplier !!}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection
