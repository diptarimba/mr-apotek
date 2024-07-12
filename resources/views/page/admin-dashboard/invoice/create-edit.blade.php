@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Invoice')
@section('sub-page-title', Str::endsWith(request()->route()->getName(), '.edit') ? 'Edit' : 'Create')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            {{-- @dd($notApproved) --}}
            <x-form.input oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');" :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="invoice_code" label="Nomor Invoice" placeholder="input invoice code" value="{{ $invoice->invoice_code ?? '' }}"/>
            <x-form.input :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="published_at" label="Tanggal Invoice" type="date" placeholder="input product name"
                value="{{ $invoice->published_at ?? '' }}" />
            <x-form.input :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="due_at" label="Tanggal Penagihan" type="date" placeholder="input contact name"
                value="{{ $invoice->due_at ?? '' }}" />
            <x-form.select :disable="is_null($notApproved) ? null : ($notApproved ? null : true)"  name="supplier_id" title="Supplier"
                value="{{ $invoice->supplier_id ?? (request()->get('supplier_id') ?? '') }}" data="{!! $supplier !!}" />
            @if (is_null($notApproved))
            <x-button.submit/>
            @endif
            <x-button.cancel url="{{ $data['home'] }}" label="Kembali" />
            @if (Str::endsWith(request()->route()->getName(), '.edit'))
            <x-button.cancel colour="sky" url="{{ route('admin.invoice-product.index', $invoice->id)}}" label="Invoice Product"/>
            @endif
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection
