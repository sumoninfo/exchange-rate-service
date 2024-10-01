@extends('layouts.app')
@section('title', 'Home')
@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Avitech
            </h1>
            <p class="col-md-8 fs-4">Ellingfort Road, London E8 3PA</p>
            <a href="https://www.il-tech.co/" target="_blank" class="btn btn-primary btn-lg" type="button">Link</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let storedToken = window.localStorage.getItem('auth_token');
        if (storedToken === '' || storedToken == null || storedToken === 'undefined') {
            fetch(`/api/fetch-token`)
                .then(response => response.json())
                .then((res) => {
                    const {status, token} = res;
                    if (status) {
                        console.log(token, 'token')
                        window.localStorage.setItem('auth_token', token);
                    }
                })
        }
    </script>
@endsection
