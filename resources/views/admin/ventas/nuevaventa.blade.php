@extends('layouts.app')
@extends('layouts.menu')
@section('content')
<div class="col-sm-12">
    @yield('menu')
</div>

   <div class="col-md-12 top_conte" ng-controller="VentaNCtrl">

	{{-- Nueva Venta --}}
	
	 <div class="header_conte">
              <h1>Nueva Venta</h1>
     </div>
	<div class="col-sm-12">
	   <div class="alert alert-success" role="alert" ng-if="alertaNuevo"> <strong>Cliente nuevo</strong> guardado correctamente, creado por administradores.</div>
        <div class="alert alert-danger" role="alert" ng-if="alertaEliminado"> <strong>Cliente borrado</strong> No se podrá recuperar los datos.</div>	
	 <div class="alert alert-info" role="alert" ng-if="alertaEditado"> <strong>Cliente editado</strong> Puedes ver en el listado de cliente las modificaciones realizadas.</div>

	  <div class="caja_contenido">
	         
	      
	  </div>
	</div>

   </div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush