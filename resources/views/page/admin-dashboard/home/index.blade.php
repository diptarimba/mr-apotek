@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Index')

@section('content')
    <x-util.card title="Penjualan">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <x-home.card-mini title="Hari Ini" prefix="" counterValue="{{ number_format($sumOrderToday, 0, ',', '.') }}"
                suffix="" color="green" valueChanged="+ $20.9k" information="Since last week" />
            <x-home.card-mini title="Kemarin" prefix=""
                counterValue="{{ number_format($sumOrderLastDay, 0, ',', '.') }}" suffix="" color="green"
                valueChanged="+ $20.9k" information="Since last week" />
            <x-home.card-mini title="Sebulan Terakhir" prefix=""
                counterValue="{{ number_format($sumOrderLastMonth, 0, ',', '.') }}" suffix="" color="green"
                valueChanged="+ $20.9k" information="Since last week" />
        </div>
    </x-util.card>
    <x-util.card title="Data Lain">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <x-home.card-mini title="Jumlah Order" prefix="" counterValue="{{ number_format($orderCount, 0, ',', '.') }}"
                suffix="" color="green" valueChanged="+ $20.9k" information="Since last week" />
            <x-home.card-mini title="Jumlah Product" prefix=""
                counterValue="{{ number_format($productCount, 0, ',', '.') }}" suffix="" color="green"
                valueChanged="+ $20.9k" information="Since last week" />
        </div>
    </x-util.card>
@endsection
