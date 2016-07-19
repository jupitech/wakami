@extends('layouts.app')

@section('content')
<div class="prin_app">

<div class="container">
    <div class="row">
    <div class="area_login">
            <div class="panel panel-default margin-top">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                       {{ $errors->first('email','El correo no es correcto') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                       {{ $errors->first('password','La constraseña es incorrecta') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox check_login">
                                    <label>
                                        <input type="checkbox" name="remember"> Recordar usuario
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-7">
                             <a class="btn btn-link btn_blanco btn_100" href="{{ url('/password/reset') }}">No recuerdo mi contraseña?</a>
                            </div>
                              <div class="col-md-5">
                                <button type="submit" class="btn btn-primary btn_100">ENTRAR</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
    <script src="/js/script.js"></script>
@endpush