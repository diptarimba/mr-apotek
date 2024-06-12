@extends('layout.app')

@section('page-link', $data['home'])
@section('page-title', 'Corporate')
@section('sub-page-title', 'List')

@section('content')
    <x-util.card title="{{ $data['title'] }}">
        <x-form.base url="{{ $data['url'] }}" method="POST">
            <x-form.input name="name" label="Name" placeholder="input corporate name"
                value="{{ $corporate->name ?? '' }}" />
            <x-form.input oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 13);" name="phone"
                label="Phone" placeholder="input corporate phone" value="{{ $corporate->phone ?? '' }}" />
            <x-form.input oninput="this.value = this.value.replace(/[^a-zA-Z0-9@_.]/g, '');" name="email" label="Email"
                placeholder="input corporate email" value="{{ $corporate->email ?? '' }}" />
            <x-form.input name="address" label="Address" placeholder="input corporate address"
                value="{{ $corporate->address ?? '' }}" />
            <x-form.input name="city" label="City" placeholder="input corporate city"
                value="{{ $corporate->city ?? '' }}" />
            <x-form.input name="state" label="Province" placeholder="input corporate province"
                value="{{ $corporate->province ?? '' }}" />
            <x-form.input name="country" label="Country" placeholder="input corporate country"
                value="{{ $corporate->country ?? '' }}" />
            <x-form.input oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5);" name="zip" label="Postal Code" placeholder="input corporate postal code"
                value="{{ $corporate->postal_code ?? '' }}" />
            <x-form.input accept=".png,.jpg,.jpeg" texting="Image" name="image" type="file" label="Photo Profile"
                placeholder="" value="" />
            <div class="mb-4 hidden" id="thumbnailContainer">
                <img id="thumbnail" src="" alt="Thumbnail" class="max-w-xs mb-2">
                <button type="button" id="removeButton"
                    class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">Remove Image</button>
            </div>
            <x-button.submit />
            <x-button.cancel url="{{ $data['home'] }}" />
        </x-form.base>
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
@endsection
