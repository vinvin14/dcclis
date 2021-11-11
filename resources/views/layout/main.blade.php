@extends('layout.sbadminb5.app-sbadminb5')
@section('content')
@include('layout.sbadminb5.navbar')

<div id="layoutSidenav">
    @include('layout.sbadminb5.sidebar')

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid p-4">
                @yield('page')
            </div>
        </main>
        <footer class="py-2 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2021</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection


