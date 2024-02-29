<!DOCTYPE html>
<html lang="en">
<head>
    @csrf
    <title>Mitt</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div class="row">
    <div class="col-6 d-flex justify-content-end">
        <img class="img-fluid mt-2" alt="mitt" style="height: 50px;" src="{{ \Illuminate\Support\Facades\Vite::asset('resources/images/mitt.svg') }}"/>
    </div>
    <div class="col-5 d-flex justify-content-end">
        <button id="clear-data"
                type="button"
                data-source="{{ route('settings.clear') }}"
                class="btn btn-primary"
        >Clear data</button>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-10" id="messages"></div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-4">
        <label for="http_status" class="form-label">HTTP Status</label>
        <select id="http_status" name="http_status" class="form-select">
            @foreach(\App\Enums\HttpStatus::cases() as $httpStatus)
                <option value="{{ $httpStatus->value }}">{{ $httpStatus->value }}: {{ $httpStatus->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-6">
        <label for="slug" class="form-label">Slug</label>
        <input id="slug" name="slug" type="text" class="form-control"/>
    </div>
</div>
<div class="row d-flex justify-content-center my-2">
    <div class="col-10">
        <label for="body">Body</label>
        <textarea id="body"
                  name="body"
                  class="form-control"
                  rows="5"
        ></textarea>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-10">
        <button id="save"
                class="btn btn-lg btn-primary w-100"
                data-save="{{ route('settings.save') }}"
        >Save</button>
    </div>
</div>
<div class="row d-flex justify-content-center my-2">
    <div class="col-10">
        <table class="table rounded-3 overflow-hidden"
               id="results-table"
               data-source="{{ route('caught') }}"
        >
            <thead>
            <tr><th colspan="3" class="text-center">Caught requests</th></tr>
            <tr>
                <th scope="col">Path</th>
                <th scope="col">Content</th>
                <th scope="col">Headers</th>
            </tr>
            </thead>
            <tbody>
            <tr class="active empty-state">
                <td colspan="3" class="text-center">Nothing to see here</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row d-flex justify-content-center my-2">
    <div class="col-10">
        <table class="table rounded-3 overflow-hidden"
               id="endpoints-table"
               data-source="{{ route('settings.get') }}"
        >
            <thead>
            <tr><th colspan="3" class="text-center">Available endpoints</th></tr>
            <tr>
                <th scope="col">Path</th>
                <th scope="col">Code</th>
                <th scope="col">Body</th>
            </tr>
            </thead>
            <tbody>
            <tr class="warning empty-state">
                <td colspan="3" class="text-center">Nothing to see here</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
