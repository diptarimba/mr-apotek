@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Index')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    <x-home.card-mini title="Encrypted Document" prefix="" counterValue="{{number_format($encDoc, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
    <x-home.card-mini title="All User" prefix="" counterValue="{{number_format($allUser, 0, ',', '.')}}" suffix="" color="green" valueChanged="+ $20.9k" information="Since last week"/>
</div>
@endsection
