@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="ReporteVentasCtrl">
	<div class="header_conte">
              <h1>Reporte de Ventas</h1>
     </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/ReporteVentasCtrl.js"></script>
@endpush