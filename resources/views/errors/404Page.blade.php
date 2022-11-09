@extends('errors.layouts.error')
@section('title')
    <title>404 - Page Not Found</title>
@endsection
@section('content')
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 The requested URL was not found on this server.</p>
        <a href="{{route('auth.login')}}" class="btn btn-primary">Back to home</a>
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
