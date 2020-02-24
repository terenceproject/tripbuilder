@extends('app')

@push('styles')
    <link href="{{ asset('css/trip.css') }}" rel="stylesheet">
@endpush

@section('content')
    <h1>Trip Builder</h1>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="tripRoute" id="oneway" value="oneway" checked>
        <label class="form-check-label" for="oneway">
            One way
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="tripRoute" id="roundtrip" value="roundtrip">
        <label class="form-check-label" for="roundtrip">
            Round trip
        </label>
    </div>
    <br>

    <div class="form-group">
        <label for="departSelect">From</label>
        <select class="form-control" id="departSelect">
            <option></option>
        </select>
    </div>
    <br>
    <div class="form-group">
        <label for="arrivalSelect">To</label>
        <select class="form-control" id="arrivalSelect">
            <option></option>
        </select>
    </div>
    <br>

    <p id="departDatepickerSection">
        Depart: <input type="text" id="departDatepicker" class="form-control">
    </p>
    <p id="returnDatepickerSection">
        Return: <input type="text" id="returnDatepicker" class="form-control">
    </p>
    <br>

    <p id="errorMessage">
    </p>
    <p>
        <button type="button" class="btn btn-primary" id="submit">Submit</button>
    </p>
    <br>

    <p id="result">

    </p>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/trip.js') }}"></script>
@endpush