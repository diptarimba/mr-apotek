@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Supplier')
@section('sub-page-title', (Str::endsWith(request()->route()->getName(),
'.edit') ? 'Edit' : 'Create'))

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Nama Supplier" placeholder="input product name"
                value="{{ $supplier->name ?? '' }}" />
            <x-form.input name="contact_name" label="Contact Name" placeholder="input contact name"
                value="{{ $supplier->contact_name ?? '' }}" />
            <x-form.input name="contact_number" oninput="this.value = this.value.replace(/^[._]+|[._]+$|[^0-9_.]/g).slice(0, 14);" label="Contact Number" placeholder="input contact number"
                value="{{ $supplier->contact_number ?? '' }}" />
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection
