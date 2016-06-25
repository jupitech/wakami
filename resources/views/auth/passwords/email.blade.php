@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="prin_app">
<div class="container">
    <div class="row">
     <div class="area_login">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-7">
                                <button type="submit" class="btn btn-primary"> Recuperar contraseña
                                </button>
                            </div>
                             <div class="col-md-5">
                             <a class="btn btn-link btn_blanco btn_100" href="{{ url('/login') }}">Regresar</a>
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
