@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Invoice Product')
@section('sub-page-title', Str::endsWith(request()->route()->getName(), '.edit') ? 'Edit' : 'Create')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.select name="product_id" title="Product" :disable="is_null($notApproved) ? null : ($notApproved ? null : true)"
                value="{{ $product->product_id ?? (request()->get('product_id') ?? '') }}" data="{!! $productResource !!}" />
            <x-form.input :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="quantity_received" label="Quantity" type="number" placeholder="input quantity"
                value="{{ $product->quantity_received ?? '' }}" />
            <x-form.input :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="buy_price" label="Harga beli" type="number" placeholder="input buy price"
                value="{{ $product->quantity_received ?? '' }}" />
            <x-form.input :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="buy_notes" label="Catatan" placeholder="input buy notes"
                value="{{ $product->quantity_received ?? '' }}" />
            <x-form.input :disable="is_null($notApproved) ? null : ($notApproved ? null : true)" name="expired_at" label="Tanggal Expired" type="date" placeholder="input contact name"
                value="{{ $product->expired_at ?? '' }}" />
            @if (!$notApproved)
            <x-button.submit  />
            @endif
            <x-button.cancel url="{{ $data['home'] }}" label="Kembali"/>
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection
