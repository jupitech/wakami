@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>
        <div class="col-md-12 top_conte">
            <div class="panel panel-default">

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush
