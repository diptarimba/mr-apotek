@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Unit')
@section('sub-page-title', (Str::endsWith(request()->route()->getName(),
'.edit') ? 'Edit' : 'Create'))

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Nama Unit" placeholder="input unit name"
                value="{{ $unit->name ?? '' }}" />
            <x-button.submit/>
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
    </x-util.card>
@endsection

@section('custom-footer')
@endsection
