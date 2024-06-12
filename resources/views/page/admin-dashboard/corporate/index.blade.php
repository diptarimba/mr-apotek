@extends('layout.app')


@section('page-link', '/')
@section('page-title', 'Corporate')
@section('sub-page-title', 'Index')

@section('content')
    @if (Session::has('auth_username') && Session::has('auth_password'))
    <x-util.card title="Auth for Corporate: {{session('corporate_name')}}">
        <x-util.alert color="green" message="Username: {{session('auth_username')}}" copy />
        <x-util.alert color="green" message="Password: {{session('auth_password')}}" copy />
    </x-util.card>
    @endif

    <x-util.card title="Corporate List" add url="{{route('admin.corporate.create')}}">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Picture</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Name</th>
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
<x-datatables.single url="{{route('admin.corporate.index')}}">
    <x-datatables.column name="picture"/>
    <x-datatables.column name="name"/>
    <x-datatables.action />
</x-datatables.single>
@endsection
