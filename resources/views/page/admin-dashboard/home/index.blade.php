@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Index')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    {{-- <x-home.card-mini title="Encrypted Document" prefix="" counterValue="{{number_format($countEncrypted, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    <x-home.card-mini title="Corporate" prefix="" counterValue="{{number_format($countCorporate, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    <x-home.card-mini title="All User Corporate" prefix="" counterValue="{{number_format($countAllUserCorporate, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/> --}}
    {{-- <x-home.card-mini title="All File" prefix="" counterValue="{{number_format(334899, 0, ',', '.')}}" suffix="" color="red" valueChanged="- 29 Trades" information="Since last week"/> --}}
    {{-- <x-home.card-mini title="Semua Test" prefix="" counterValue="{{number_format($testAll, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
    <x-home.card-mini title="Test Akan Datang" prefix="" counterValue="{{number_format($testIncoming, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
    <x-home.card-mini title="Test Berlangsung" prefix="" counterValue="{{number_format($testOnGoing, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/>
    <x-home.card-mini title="Test Berakhir" prefix="" counterValue="{{number_format($testEnded, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $2.8k" information="Since last week"/> --}}
</div>
@endsection
