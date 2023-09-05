@props([
    'id' => '',
    'name' => '',
])

@php
    if(empty($name)) {
        throw \Illuminate\Validation\ValidationException::withMessages(
            [
                'name' => "Input name '$name' isn't set!"
            ]
        );
    }
    $id = !empty($id) ? $id : 'tinymce_' . rand(100000, 999999);
@endphp

<textarea id="{{ $id }}" name="{{ $name }}">{{ $slot }}</textarea>

@pushonce('scripts')
    <script src="https://cdn.tiny.cloud/1/{{ config('app.tinymce_api_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: 'textarea#{{ $id }}', // Replace this CSS selector to match the placeholder element for TinyMCE
            plugins: 'code table lists',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
        });
    </script>
@endpushonce
