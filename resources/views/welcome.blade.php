<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <title>Dynamic Form</title>
    </title>
</head>

<body>
    <div class="main_container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('data.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation"
            novalidate>
            @csrf
            @foreach ($data['data']['form']['fieldsets'] as $fieldset)
                <div class="mb-3">
                    <legend class="fw-bold">{{ $fieldset['label'] }}</legend>
                    @foreach ($fieldset['fields'] as $field)
                        @php
                            $fieldData = collect($data['data']['fields'])->firstWhere('id', $field['id']);
                            $fieldName = $data['data']['form']['id'] . '-' . $fieldData['id'];
                            $fieldValue = old($fieldName);
                        @endphp
                        <div class="mb-3">
                            <div class="form-label">{{ $fieldData['label'] }}</div>
                            @switch ($fieldData['element']['type'])
                                @case ('input')
                                    <input type="text" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        value="{{ $fieldValue }}" {{ $fieldData['validation'][0]['rule'] ?? '' }}
                                        class="form-control" required>
                                    @error($fieldName)
                                        <div class="invalid">{{ $message }}</div>
                                    @enderror
                                @break

                                @case ('extended_select')
                                    <select name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        {{ $fieldData['validation'][0]['rule'] ?? '' }} class="form-select" required>
                                        <option value="" selected>Select an option</option>
                                        @foreach ($fieldData['element']['values'] as $option)
                                            <option value="{{ $option['value'] }}"
                                                {{ $fieldValue == $option['value'] ? 'selected' : '' }}>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error($fieldName)
                                        <div class="invalid">{{ $message }}</div>
                                    @enderror
                                @break

                                @case ('image_uploader')
                                    <input type="file" name="{{ $fieldName }}" id="{{ $fieldName }}" accept="image/*"
                                        {{ $fieldData['validation'][0]['rule'] ?? '' }} class="form-control" required>
                                    @error($fieldName)
                                        <div class="invalid">{{ $message }}</div>
                                    @enderror
                                @break

                                @case ('select')
                                    <select name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        {{ $fieldData['validation'][0]['rule'] ?? '' }} class="form-select" required>
                                        <option value="" selected>Select an option</option>
                                        @foreach ($fieldData['element']['values'] as $option)
                                            <option value="{{ $option['value'] }}"
                                                {{ $fieldValue == $option['value'] ? 'selected' : '' }}>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error($fieldName)
                                        <div class="invalid">{{ $message }}</div>
                                    @enderror
                                @break
                            @endswitch
                        </div>
                    @endforeach
                </div>
            @endforeach
            <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
        </form>

    </div>

</body>

</html>
