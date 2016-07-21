<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Wakami</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700italic,700,500italic,500,400italic,300italic,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300italic,300,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select.min.css') }}">
  
    <!-- Styles -->
   {{--
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    --}}
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('assets/bower/bootstrap/dist/css/bootstrap.min.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

</head>
<body id="app-layout" ng-app="wApp">


       @yield('content')
 
   

    <!-- JavaScripts -->
     {{--<script type="text/javascript" src="{{asset('assets/bower/angular/angular.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('assets/bower/angular-route/angular-route.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('assets/bower/angular-cookies/angular-cookies.min.js')}}"></script>
      --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="/js/vendor.js"></script>
      <script type="text/javascript" src="{{asset('js/bootstrap-select.min.js')}}"></script>
    @stack('scripts')
  
</body>
</html>
