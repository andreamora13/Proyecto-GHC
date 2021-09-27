<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- site metas -->
    <title>Partida</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link href="{{asset('css/stylesPrueba.css')}}" rel="stylesheet" text="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Check.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('moon/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('tabla/css/style.css') }}">
    <!-- fevicon -->
 
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<!-- body -->
    <style>
    html, body {
     background-color: #fff;
     font-family: sans-serif;
   
    }
    #circulo{
       height:10px;
       width:10px;
      
       -moz-border-radius:50px;
       -webkit-border-radius:50px;
       border-radius:50px;
    }
  
    </style>

</head>

 
<body class="main-layout">

 <img src="{{ asset('imagenes/p2.jpeg') }}" style="width: 60px; height: 60px">
<img src="{{ asset('imagenes/p3.jpeg') }}" style="width: 60px; height: 60px">
   
     

    <!-- end offer -->

    <!-- end footer -->
     <script src="{{ asset('moon/js/jquery.min.js') }}"></script>
     <script src="{{ asset('moon/js/custom.js') }}"></script>
     <script src="{{ asset('tabla/js/jquery-3.3.1.min.js') }}"></script>
     <script src="{{ asset('tabla/js/main.js') }}"></script>
    <!-- google map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap"></script>
    <!-- end google map js -->
</body>

</html>
