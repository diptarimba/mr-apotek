@extends('layout.app')


@section('page-link', route('admin.product.index'))
@section('page-title', 'Order')
@section('sub-page-title', 'Page')

@push('additional-header')
    <style>
        datalist {
            background-color: #fff;
            color: #df0c0c;
        }

        @media (prefers-color-scheme: dark) {
            datalist {
                background-color: #333;
                color: #fff;
            }
        }
    </style>
@endpush

@section('content')
    <x-util.card title="Admin">
        <x-slot name="customBtn">
            <x-button.modal label="Tambah Produk" id="add-product" />
        </x-slot>
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Name</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Branch Code</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Quantity</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Price</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Subtotal</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Notes</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Action</th>
                    </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">
                        Total:</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0"></th>
                    <th colspan="2" class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">
                        <x-button.modal label="Bayar" id="pay-product" /></th>
                </tr>
            </tfoot>
        </table>
    </x-util.card>
    <x-util.modals.content center="tidak" id="add-product" title="Add Product">
        <x-slot name="button">
            <x-button.modal.button label="Tambahkan" id="btn-add-product" colour="green" />
            <x-button.modal.button class="hidden" label="Ubah" id="btn-update-product" colour="green" />
        </x-slot>
        <form id="form-add-product">
            <x-form.input name="branch_code" type="hidden" label="Nama Produk" placeholder="input product name"
                value="" />
            <x-form.input name="product_name" label="Nama Produk" placeholder="input product name" value=""
                list="product-name-list" />
            <x-form.input name="quantity" type="number" label="Quantity" type="number" placeholder="input quantity"
                value="0" />
            <x-form.input disable="benar" name="price" label="Price" type="number" placeholder="input price"
                value="0" />
            <x-form.input disable="benar" name="sub_total" label="Subtotal" type="number" placeholder="input subtotal"
                value="0" />
            <x-form.input name="notes" label="Notes" placeholder="input notes" value="" />
        </form>
    </x-util.modals.content>

    <x-util.modals.content center="tidak" id="pay-product" title="Bayar">
        <x-slot name="button">
            <x-button.modal.button label="bayar" id="btn-pay-product" colour="green" />
        </x-slot>
        <form id="form-pay-product">

            <x-form.input disable="benar" name="totalPay" label="Total Bayar" type="number" placeholder="input total bayar"
                value="" />
            <x-form.input name="customerMoney" label="Uang Diberikan Pelanggan" type="number"
                placeholder="input uang diberikan pelanggan" value="{{ old('customerMoney') ?? '' }}" />
            <x-form.input disable="benar" name="change" label="Kembalian" type="number" placeholder="input kembalian"
                value="" />
        </form>
    </x-util.modals.content>

@endsection


@section('custom-footer')
    <script>
        $('#btn-pay-product').attr('disabled', true);

        let cartProduct = [];

        var table = $('#datatable').DataTable({
            rowId: 'DT_RowIndex',
            columns: [{
                    name: 'id',
                    data: null, // Use null data for the iteration column
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // Return the row number
                    },
                    className: 'p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600'

                },
                {
                    data: 'product_name',
                    name: 'product_name',
                    className: 'p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
                {
                    data: 'branch_code',
                    name: 'branch_code',
                    className: 'p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    className: 'p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
                {
                    data: 'price',
                    name: 'price',
                    className: 'p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
                {
                    data: 'sub_total',
                    name: 'sub_total',
                    className: 'p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
                {
                    data: 'notes',
                    name: 'notes',
                    className: 'p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
                {
                    data: null,
                    name: 'action',
                    render: function(data) {
                        return `
                        <div class="w-full">
                        <button class="w-full m-1 text-white bg-green-700 hover:bg-green-500 rounded p-1" onclick="modifyThisRow(${data.id})"><i class="fa fa-pencil"></i></button>
                        <button class="w-full m-1 text-white bg-red-700 hover:bg-red-500 rounded p-1" onclick="deleteThisRow(${data.id})"><i class="fa fa-trash"></i></button></div>`
                    },
                    orderable: false,
                    searchable: false,
                    className: 'p-2 pr-4 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0'
                },
            ],
            footerCallback: function(row, data, start, end, display) {
                var api = this.api(),
                    data;
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                var total = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                if (total === 0) {
                    $('[data-tw-target="#pay-product"]').addClass('hidden');
                } else {
                    $('#input-totalPay').val(total)
                    $('[data-tw-target="#pay-product"]').removeClass('hidden');
                }
                $(api.column(5).footer()).html(
                    'Rp ' + total
                );
            },
        });

        var productSource = [];
        var productSuggests = [];

        function modifyThisRow(row) {
            var data = table.row(row).data();
            implementProduct(data.branch_code, 'update');
            $('#input-product_name').val(data.branch_code + ' - ' + data.product_name);
            $('#input-product_name').attr('disabled', 'disabled');
            $('#add-product').removeClass('hidden');
            $('#btn-add-product').addClass('hidden');
            $('#btn-update-product').removeClass('hidden');
        }

        $('#btn-pay-product').on('click', function() {
            let order = {}
            order.order = []
            cartProduct.forEach(product => {
                newProduct = {
                    'branch_code': product.branch_code,
                    'quantity': product.quantity,
                    'notes': product.notes
                }
                order.order.push(newProduct)
            })

            let customerMoney = $('#input-customerMoney').val();
            order.customer_pay = customerMoney;

            $.ajax({
                type: "POST",
                url: "{{ route('admin.order.store') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}',
                },
                data: order,
                success: function(response) {
                    console.log(response)
                },
                error: function(xhr, status, error) {
                    console.log(error)
                }
            });
        })


        function deleteThisRow(row) {
            var data = table.row(row).data();
            const index = cartProduct.findIndex(product => product.branch_code === data.branch_code);
            cartProduct.splice(index, 1);
            drawTable();
            $('#add-product').addClass('hidden');
        }

        // mengambil data produk
        function ajaxGetProductData(search = '') {
            $.ajax({
                url: '{{ route('admin.order') }}',
                data: {
                    search: search,
                },
                type: 'GET',
                success: function(response) {
                    productSuggests = response.data.map(product => product.branch_code + ' - ' + product.name);
                    productSource = response.data;
                    showSuggestions(search);
                }
            });

        }

        $('#input-customerMoney').on('keyup', debounce(function() {
            var customerMoney = $('#input-customerMoney').val();
            var totalPay = $('#input-totalPay').val();
            var change = customerMoney - totalPay;
            if (change < 0) {
                $('#input-change').val(0)
                $('#btn-pay-product').attr('disabled', true)
                return
            }else{
                $('#btn-pay-product').attr('disabled', false)
            }

            $('#input-change').val(customerMoney - totalPay)
        }))

        $('#btn-update-product').on('click', function() {
            resArray = $('#form-add-product').serializeArray();
            let pushData = {}
            resArray.forEach(element => {
                pushData[element.name] = element.value
            });
            product = productSource.find(product => product.branch_code == pushData.branch_code);
            pushData['product_name'] = product.name;
            const index = cartProduct.findIndex(product => product.branch_code === pushData.branch_code);
            cartProduct[index] = pushData;
            drawTable();
            clearDataProduct()
            $('#add-product').addClass('hidden');
            $('#input-product_name').attr('disabled', false);
        })

        // membuat delay
        function debounce(func, timeout = 200) {
            let timerId;
            return (...args) => {
                clearTimeout(timerId);
                timerId = setTimeout(() => {
                    func.apply(null, args);
                }, timeout);
            };
        }

        function drawTable() {
            table.clear();
            cartProduct.forEach(product => {
                table.row.add(product).draw();
            })
            table.draw();
        }


        // ketika ada yang ngetik sesuatu di cek produknya
        const input = document.getElementById('input-product_name');
        input.addEventListener('input', debounce((event) => {
            ajaxGetProductData(event.target.value);
        }, 500));

        input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                if (productSuggests.length > 0) {
                    branch_code = productSuggests[0].split(' - ')[0];
                    implementProduct(branch_code, 'add')
                    selectSuggestion(productSuggests[0])
                }
            }
        })



        // nempelin data product ke field field
        function implementProduct(branch_code, type = 'add') {
            let price;
            let product;
            let quantity;
            let max_quantity;
            if (type == 'add') {
                // ambil data dari product hasil api
                product = productSource.find(product => product.branch_code == branch_code);
                price = product.sell_price;
                max_quantity = product.quantity
                quantity = 1;
            } else {
                //ambil data dari cart
                product = cartProduct.find(product => product.branch_code == branch_code);
                price = product.price;
                max_quantity = product.max_quantity
                quantity = product.quantity
            }

            $('#btn-add-product').attr('disabled', false);
            $('#input-price').val(price);
            $('#input-branch_code').val(product.branch_code);
            $('#input-quantity').val(quantity);
            $('#input-quantity').attr('max', max_quantity);
            $('#input-quantity').attr('oninput', 'this.value = this.value.replace(/[^0-9]/g, \'\'); if(this.value > ' +
                max_quantity + ') { this.value = ' + max_quantity + '}');
            calculateTotal()
        }

        // disable button tambah ketika input quantity = 0
        $('#btn-add-product').attr('disabled', true);
        $('#input-quantity').on('keyup', function() {
            calculateTotal()
            let subtotal = $('#input-sub_total').val();
            let quantity = $('#input-quantity').val();
            if (subtotal <= 0 || quantity <= 0) {
                $('#btn-add-product').attr('disabled', true);
                $('#btn-update-product').attr('disabled', true);
            } else {
                $('#btn-add-product').attr('disabled', false);
                $('#btn-update-product').attr('disabled', false);
            }
        })

        $('#btn-add-product').on('click', function() {
            resArray = $('#form-add-product').serializeArray();

            let pushData = {}
            resArray.forEach(element => {
                pushData[element.name] = element.value
            });
            product = productSource.find(product => product.branch_code == pushData.branch_code);
            pushData['product_name'] = product.name;
            pushData['max_quantity'] = product.quantity;

            let existingIndex = cartProduct.findIndex(product => product.branch_code === pushData.branch_code);
            if (existingIndex !== -1) {
                cartProduct[existingIndex].quantity = parseInt(cartProduct[existingIndex].quantity) + parseInt(
                    pushData.quantity);
                cartProduct[existingIndex].sub_total = cartProduct[existingIndex].quantity * pushData.price;
            } else {
                cartProduct.push(pushData);
            }

            drawTable();
            clearDataProduct()
            $('#add-product').addClass('hidden');
        })


        // clear data ketika input product name kosong
        $('#input-product_name').on('keyup', function() {
            debounce(clearProductWhenNameEmpty(), 500)
        })

        function clearProductWhenNameEmpty() {
            if ($('#input-product_name').val() == '') {
                clearDataProduct()
            }
        }

        // set to starting state
        function clearDataProduct() {
            $('#input-price').val(0);
            $('#input-quantity').val(0);
            $('#input-sub_total').val(0);
            $('#input-product_name').val('');
            $('#input-branch_code').val('');
            $('#btn-add-product').attr('disabled', true);
        }


        function createMutationObserver(targetId, callback) {
            var target = document.getElementById(targetId);
            var observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    callback(mutation, target);
                });
            });
            observer.observe(target, {
                attributes: true
            });
        }

        // Contoh penggunaan
        createMutationObserver('pay-product', function(mutation, target) {
            if (mutation.attributeName === "class") {
                var classList = $(target).attr('class');
                if (classList.includes('hidden')) {
                    $('#btn-pay-product').attr('disabled', true);
                    $('#input-customerMoney').val(0)
                    $('#input-change').val(0)
                }
            }
        });

        createMutationObserver('add-product', function(mutation, target) {
            if (mutation.attributeName === "class") {
                var classList = $(target).attr('class');
                if (classList.includes('hidden')) {
                    clearDataProduct()
                    $('#input-product_name').attr('disabled', false);
                    $('#btn-add-product').removeClass('hidden');
                    $('#btn-update-product').addClass('hidden');
                }
            }
        });

        function calculateTotal() {
            total = $('#input-price').val() * $('#input-quantity').val();
            $('#input-sub_total').val(total);
        }

        function showSuggestions(value) {
            const suggestionsList = document.getElementById('suggestions-list');
            suggestionsList.innerHTML = ''; // Hapus saran sebelumnya
            if (value) {
                const filteredProducts = productSuggests.filter(product => product.toLowerCase().includes(value
                    .toLowerCase()));
                if (filteredProducts.length > 0) {
                    filteredProducts.forEach(product => {
                        const suggestionItem = document.createElement('div');
                        suggestionItem.textContent = product;
                        suggestionItem.classList.add('cursor-pointer', 'p-2', 'hover:bg-gray-200');
                        suggestionItem.onclick = () => {
                            branch_code = product.split(' - ')[0];
                            implementProduct(branch_code, 'add')
                            selectSuggestion(product)
                        };
                        suggestionsList.appendChild(suggestionItem);
                    });
                    suggestionsList.classList.remove('hidden');
                } else {
                    suggestionsList.classList.add('hidden');
                }
            } else {
                suggestionsList.classList.add('hidden');
            }
        }

        function selectSuggestion(value) {
            const input = document.getElementById('input-product_name');
            input.value = value;
            const suggestionsList = document.getElementById('suggestions-list');
            suggestionsList.innerHTML = '';
            suggestionsList.classList.add('hidden');
        }

        document.addEventListener('click', function(e) {
            const suggestionsList = document.getElementById('suggestions-list');
            if (!suggestionsList.contains(e.target) && e.target.id !== 'input-product_name') {
                suggestionsList.classList.add('hidden');
            }
        });

        // table.on('xhr.dt', function(e, settings, json, xhr) {
        //     var data = json.data;
        //     table.clear();
        //     for (var i = 0; i < data.length; i++) {
        //         table.row.add([
        //             data[i].id,
        //             data[i].name,
        //             data[i].branch_code,
        //             data[i].image,
        //             data[i].quantity,
        //             data[i].price,
        //             '<a href="" class="flex items-center justify-center text-theme-6"><i class="fa fa-trash"></i></a>'
        //         ]);
        //     }
        //     table.draw();
        // });
    </script>
@endsection

@push('additional-header')
    <!-- DataTables -->
    <link href="{{ asset('assets-dashboard/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets-dashboard/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets-dashboard/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
@endpush

@push('additional-footer')
    <!-- Required datatable js -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.dataTables.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets-dashboard/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets-dashboard/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>

    <!-- Datatable init js -->
    {{-- <script src="{{ asset('assets-dashboard/js/pages/datatables.init.js') }}"></script> --}}
@endpush
