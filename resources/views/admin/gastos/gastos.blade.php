@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ProveedoresCtrl">


  {{-- Gastos --}}

   <div class="header_conte">
            <h1>Gastos</h1>
              <div class="btn_nuevo">
                  <a href="" ng-click="btn_nuevo()">Nuevo Gasto</a>
              </div>
   </div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush