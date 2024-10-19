@extends('layout.app')

@section('page-link', '/')
@section('page-title', 'Dashboard')
@section('sub-page-title', 'Index')

@section('content')
    <div class="mb-3 grid grid-cols-1 md:grid-cols-2 gap-5">
        <x-form.base>
            <x-form.input name="daterange" label="Filter Tanggal" placeholder="" value="" />
        </x-form.base>
    </div>
    <x-util.card title="Penjualan">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            <x-home.card-mini title="Total Penjualan (Rupiah)" prefix=""
                counterValue="{{ number_format($orderSum, 0, ',', '.') }}" suffix="" color="green"
                valueChanged="+ $20.9k" information="Since last week" />
            <x-home.card-mini title="Total Penjualan (Transaksi)" prefix=""
                counterValue="{{ number_format($orderCount, 0, ',', '.') }}" suffix="" color="green"
                valueChanged="+ $20.9k" information="Since last week" />
        </div>
    </x-util.card>
@endsection


@push('additional-footer')
    <script>
        // mengambil URL saat ini
        let currentUrl = window.location.search;

        // membuat objek URLSearchParams dari URL saat ini
        var searchParams = new URLSearchParams(currentUrl);
        $(document).ready(() => {

            $(function() {
                $('input[name="daterange"]').daterangepicker({
                        opens: 'left', // position of calendar popup
                        startDate: searchParams.get('start_date') ?? moment().startOf(
                            'month'), // initial start date
                        endDate: searchParams.get('end_date') ?? moment().endOf(
                            'month'), // initial end date
                        locale: {
                            format: 'YYYY-MM-DD' // date format
                        }
                    },
                    function(start, end, label) {
                        // menambahkan query string baru pada objek URLSearchParams
                        searchParams.set('start_date', start.format('YYYY-MM-DD'));
                        searchParams.set('end_date', end.format('YYYY-MM-DD'));

                        // melakukan redirect ke URL yang baru
                        window.location.search = searchParams.toString();
                    });
            });
        })
    </script>
@endpush
