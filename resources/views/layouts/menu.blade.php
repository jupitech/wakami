@section('menu')
<div class="top_menu" ng-controller="menuDos">
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <div class="li_btns"><a href="" class="btn_wakami btn_menu" ng-click="btn_menu()"></a></div>
        <a class="logo_prin2" href="{{ URL::to('/') }}"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
        <ul class="nav navbar-nav navbar-right">
          <li class="li_btns"><a href="#" class="btn_wakami btn_mail"></a></li>
          <li class="li_btns"><a href="#" class="btn_wakami btn_alerta"></a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hola, {{ isset(Auth::user()->getUserProfile()->nombre) ? Auth::user()->getUserProfile()->nombre : Auth::user()->email }} {{ isset(Auth::user()->getUserProfile()->apellido) ? Auth::user()->getUserProfile()->apellido : Auth::user()->email }}  <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Mi perfil</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ URL::to('/logout') }}">Cerrar Sesión</a></li>
              <li><a href=""></a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <div class="menu_dos" ng-hide="menudos">
  <div class="col-sm-12">
       <ul class="nav navbar-nav">
        @role('admin|operativo|developer') 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_ventas" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ventas</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/nuevaventa') }}">Nueva Venta</a></li>
                <li><a href="{{ URL::to('/clientes') }}">Clientes</a></li>
                <li><a href="{{ URL::to('/ventas') }}">Listado de ventas</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ URL::to('/promociones') }}">Promociones</a></li>
                <li><a href="#">Movimientos de ventas</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_productos" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Productos</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/productos') }}">Listado de productos</a></li>
                 <li><a href="{{ URL::to('/inventariocon') }}">Inventario Consolidado</a></li>
                <li><a href="{{ URL::to('/devoluciones') }}">Devoluciones</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_sucursales" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Sucursales</a>
              <ul class="dropdown-menu">
                 <li><a href="{{ URL::to('/sucursales') }}">Bodega de Sucursales</a></li>
                    <li><a href="{{ URL::to('/cierres') }}">Cierres Sucursales</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_bodegas" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Consignación</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/consignacion') }}">Consignación</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_reportes" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/reporteventas') }}">Reporte de ventas</a></li>
                <li><a href="{{ URL::to('/libroventas') }}">Libro de Ventas</a></li>
                <li><a href="{{ URL::to('/cuentascobrar') }}">Cuentas por cobrar</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_gastos" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gastos/Compras</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/gastos') }}">Gastos</a></li>
                <li><a href="{{ URL::to('/compras') }}">Compras</a></li>
                 <li><a href="{{ URL::to('/proveedores') }}">Proveedores</a></li>
                 <li><a href="{{ URL::to('/donaciones') }}">Donaciones</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle ico_configuraciones" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuraciones</a>
              <ul class="dropdown-menu">
                <li><a href="{{ URL::to('/usuarios') }}">Usuarios</a></li>
                @role('developer')<li><a href="{{ URL::to('/developer') }}">Developer</a></li>@endrole
              </ul>
            </li>
               @endrole
               @role('vendedor') 
                       <li class="dropdown">
                        <a href="#" class="dropdown-toggle ico_ventas" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ventas</a>
                        <ul class="dropdown-menu">
                          <li><a href="{{ URL::to('/minuevaventa') }}">Nueva Venta</a></li>
                          <li><a href="{{ URL::to('/clientessu') }}">Clientes</a></li>
                          <li><a href="{{ URL::to('/misventas') }}">Listado de ventas</a></li>
                           <li><a href="{{ URL::to('/cierrecaja') }}">Cierre de Caja</a></li>
                        </ul>
                      </li>
                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle ico_productos" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Productos</a>
                            <ul class="dropdown-menu">
                              <li><a href="{{ URL::to('/misproductos') }}">Listado de productos</a></li>
                              <li><a href="{{ URL::to('/misucursal') }}">Mi Sucursal</a></li>
                               <li><a href="{{ URL::to('/traslados') }}">Traslados</a></li>
                              <li><a href="{{ URL::to('/misdevoluciones') }}">Devoluciones</a></li>
                            </ul>
                          </li>
                           <li class="dropdown">
                            <a href="#" class="dropdown-toggle ico_reportes" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes</a>
                            <ul class="dropdown-menu">
                              <li><a href="">Ventas del día</a></li>
                              <li><a href="">Ventas del mes</a></li>
                                <li role="separator" class="divider"></li>
                              <li><a href="">Crecimiento de ventas</a></li>
                            </ul>
                          </li>

                @endrole
                
          </ul>
      <div class="hora_actual">@{{Fecha | amDateFormat: 'DD/MM/YYYY'}} @{{ clock | date:'HH:mm:ss'}}</div>
  </div>
  </div>
</div>
@show