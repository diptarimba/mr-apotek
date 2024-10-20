@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Product')
@section('sub-page-title', 'List')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            @if (Str::endsWith(request()->route()->getName(),
            '.edit'))
                <div class="mb-4 w-1/2">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image Product</label>
                    <img class="rounded-lg shadow-xl w-full" src="{{ $product->image ?? '' }}" alt="" srcset="">
            </div>
            @endif
            <x-form.input oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');" name="branch_code" label="Branch Code" placeholder="input branch code"
                value="{{ $product->branch_code ?? '' }}" />
            <x-form.input name="name" label="Nama Produk" placeholder="input product name"
                value="{{ $product->name ?? '' }}" />
            <x-form.select title="Unit" data="{!! $unit !!}" name="unit_id" value="{{$product->unit_id ?? ''}}"/>
            <x-form.input type="number" name="sell_price" label="Harga Jual" placeholder="input product price"
                value="{{ $product->sell_price ?? '' }}" />
            <x-form.input accept=".png,.jpg,.jpeg" texting="Image" name="image" type="file" label="Product Image"
                placeholder="" value="" />
            <div class="mb-4 hidden" id="thumbnailContainer">
                <img id="thumbnail" src="" alt="Thumbnail" class="max-w-xs mb-2">
                <button type="button" id="removeButton"
                    class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">Remove Image</button>
            </div>
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" label="Kembali" />
        </x-form.base>
    </x-util.card>

    <x-util.card title="Product">
        <table id="datatable" class="table w-full pt-4 text-gray-700 dark:text-zinc-100 datatables-target-exec">
            <thead>
                <tr>
                    <th class="p-4 pr-8 border rtl:border-l-0 border-y-2 border-gray-50 dark:border-zinc-600">Id</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Transaction Date</th>
                    <th class="p-4 pr-8 border border-y-2 border-gray-50 dark:border-zinc-600 border-l-0">Quantity</th>
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
    <script>
        // Select the file input element
        const imageFileInput = document.getElementById('input-image');
        // Select the thumbnail container element
        const thumbnailContainer = document.getElementById('thumbnailContainer');
        // Select the thumbnail element
        const thumbnail = document.getElementById('thumbnail');
        // Select the remove button element
        const removeButton = document.getElementById('removeButton');

        // When a file is selected
        imageFileInput.addEventListener('change', function(event) {
            // Get the selected file
            const file = event.target.files[0];

            // Check if a file is selected
            if (file) {
                // Show the thumbnail container
                thumbnailContainer.classList.remove('hidden');

                // Create a FileReader object
                const reader = new FileReader();

                // When the FileReader has finished reading the file
                reader.onload = function(e) {
                    // Set the thumbnail source as the result of the FileReader
                    thumbnail.setAttribute('src', e.target.result);
                };

                // Read the file as a data URL
                reader.readAsDataURL(file);
            } else {
                // Hide the thumbnail container if no file is selected
                thumbnailContainer.classList.add('hidden');
            }
        });

        // When the remove button is clicked
        removeButton.addEventListener('click', function() {
            // Reset the file input value
            imageFileInput.value = '';
            // Hide the thumbnail container
            thumbnailContainer.classList.add('hidden');
        });
    </script>
    <x-datatables.single url="{{route('admin.product.lastTransaction', $product->id)}}">
        <x-datatables.column name="created_at"/>
        <x-datatables.column name="quantity"/>
        <x-datatables.action />
    </x-datatables.single>
@endsection
