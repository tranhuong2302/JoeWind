@extends('errors.layouts.error')
@section('title')
    <title>403 - Access denied</title>
@endsection
@section('content')
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Access denied :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 You dont have authorize.</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back to home</a>
        <div class="mt-3">
            <img
                src="{{asset('admin/assets/img/illustrations/page-misc-error-light.png')}}"
                alt="page-misc-error-light"
                width="500"
                class="img-fluid"
                data-app-dark-img="illustrations/page-misc-error-dark.png"
                data-app-light-img="illustrations/page-misc-error-light.png"
            />
        </div>
    </div>
@endsection
