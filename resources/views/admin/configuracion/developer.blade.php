@extends('layouts.app')
@extends('layouts.menu')
@section('content')
@role('developer')
	<div class="col-md-12 top_conte" ng-controller="DeveloperCtrl" ng-cloak>
		<div class="header_conte">
			<h1>Developer</h1>
			<h1>Estado del sistema @{{ developers }}</h1>
		</div>
		
		<div class="caja_contenido">
			<table class="table">
				<thead>
					<tr>
						<th>Configuración</th>
						<th>Descripción</th>	
						<th>Opciones</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>Modo Desarrollador</strong></td>
						<td>Anula los envios de facturas a la SAT vía internet</td>
						<td>
							<div class="onoffswitch">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" ng-click="act_rol()">
                                    <label class="onoffswitch-label" for="myonoffswitch">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                            </div>                            	
                        </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endrole
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
    <script src="/js/controller/DeveloperCtrl.js"></script>
@endpush