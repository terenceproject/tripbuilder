@extends('app')

@push('styles')
    <link href="{{ asset('css/trip.css') }}" rel="stylesheet">
@endpush

@section('content')
    <h1>Trip Builder</h1>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/trip.js') }}"></script>
@endpush