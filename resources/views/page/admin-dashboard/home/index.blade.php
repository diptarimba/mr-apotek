@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Index')

@section('content')
<x-util.card title="Penjualan">
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    <x-home.card-mini title="Hari Ini" prefix="" counterValue="{{number_format($sumOrderToday, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    <x-home.card-mini title="Kemarin" prefix="" counterValue="{{number_format($sumOrderLastDay, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    <x-home.card-mini title="Sebulan Terakhir" prefix="" counterValue="{{number_format($sumOrderLastMonth, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    {{-- <x-home.card-mini title="All File" prefix="" counterValue="{{number_format(334899, 0, ',', '.')}}" suffix="" color="red" valueChanged="- 29 Trades" information="Since last week"/> --}}
    {{-- <x-home.card-mini title="Semua Test" prefix="" counterValue="{{number_format($testAll, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
    <x-home.card-mini title="Test Akan Datang" prefix="" counterValue="{{number_format($testIncoming, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
    <x-home.card-mini title="Test Berlangsung" prefix="" counterValue="{{number_format($testOnGoing, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
    <x-home.card-mini title="Test Berakhir" prefix="" counterValue="{{number_format($testEnded, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/> --}}
</div>
</x-util.card>
@endsection
