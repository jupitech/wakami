@section('menu')
<div ng-controller="menuDos">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <div class="li_btns"><a href="" class="btn_wakami btn_menu" ng-click="btn_menu()"></a></div>
        <a class="logo_prin" href="{{ URL::to('/') }}"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
        <ul class="nav navbar-nav navbar-right">
          <li class="li_btns"><a href="#" class="btn_wakami btn_mail"></a></li>
          <li class="li_btns"><a href="#" class="btn_wakami btn_alerta"></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hola, Bienvenido <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Action</a></li>
              <li><a href="#">Another action</a></li>
              <li><a href="#">Something else here</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="#">Separated link</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="menu_dos" ng-hide="menudos">
  <div class="col-sm-12">
       <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_ventas" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ventas</a>
              <ul class="dropdown-menu">
                <li><a href="#">Ventas del dia</a></li>
                <li><a href="#">Clientes</a></li>
                <li><a href="#">Listado de ventas</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Movimientos de ventas</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_productos" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Productos</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/productos') }}">Listado de productos</a></li>
                <li><a href="#">Top productos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_sucursales" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sucursales</a>
              <ul class="dropdown-menu">
                 <li><a href="{{ URL::to('/sucursales') }}">Bodega de Sucursales</a></li>
                <li><a href="#">Okland Mall</a></li>
                <li><a href="#">Miraflores</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_bodegas" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bodegas</a>
              <ul class="dropdown-menu">
                <li><a href="#">Consignación</a></li>
                  <li role="separator" class="divider"></li>
                <li><a href="#">Movimiento entre bodegas</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_reportes" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes</a>
              <ul class="dropdown-menu">
                <li><a href="#">Reporte de ventas</a></li>
                <li><a href="#">Reporte de compras</a></li>
                  <li role="separator" class="divider"></li>
                <li><a href="#">Movimientos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_gastos" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gastos/Compras</a>
              <ul class="dropdown-menu">
                <li><a href="#">Gastos</a></li>
                <li><a href="{{ URL::to('/compras') }}">Compras</a></li>
                 <li><a href="{{ URL::to('/proveedores') }}">Proveedores</a></li>
                 <li><a href="#">Donaciones</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_configuraciones" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuraciones</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/usuarios') }}">Usuarios</a></li>
                <li><a href="#">Parametros Generales</a></li>
                 <li><a href="#">Accesos</a></li>
              </ul>
            </li>
          </ul>
      <div class="hora_actual">@{{Fecha | amDateFormat: 'DD/MM/YYYY'}} @{{ clock | date:'HH:mm:ss'}}</div>
  </div>
  </div>
</div>
@show