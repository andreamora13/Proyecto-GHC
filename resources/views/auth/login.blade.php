@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Login</title>
        <link rel="shortcut icon" href="{{ asset('imagenes/logo6.png') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        

        <link rel="stylesheet" type="text/css" href="{{ asset('css/estilo.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
            function mostrarPassword(){
		            var cambio = document.getElementById("password");
		            if(cambio.type == "password"){
			            cambio.type = "text";
			            $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
		            }else{
			            cambio.type = "password";
			            $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
		            }
	        }
            
	            $(document).ready(function () {
	            //CheckBox mostrar contraseña
	            $('#ShowPassword').click(function () {
		            $('#Password').attr('type', $(this).is(':checked') ? 'text' : 'password');
	            });
            });
        </script>
        <!-- Styles -->
    </head>

    <body>
        <!-- Background Video-->
       
        <div class="container px-4 py-5 mx-auto">
            <div class="card card0">
                <div class="d-flex flex-lg-row flex-column-reverse">
                    <div class="card card1">
               
                            <h3 class="mb-5 text-center heading" translate="no">Ingreso</h3>
                      

                                <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right" translate="no">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        <br>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right" translate="no">Contraseña</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" >
                                 
                                                  <center>
                                                    <span class="fa fa-eye-slash icon" onclick="mostrarPassword()" style=" width: 30px; height: 30px; vertical-align:sub">
                                                    </span>
                                                  </center>
                                      
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                        <br>
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember" >
                                                &nbsp; &nbsp;Recuerdame
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary ">
                                            Ingreso
                                        </button>
                                
                                        <br><br>
                                        @if (Route::has('password.request'))
                                            <a  href="{{ route('password.request') }}">
                                                <small>{{ __('Olvidaste tu contraseña?') }}</small>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </form>

                   
                
                    </div>
                    <div class="card card2">
                        <div class="my-auto mx-md-5  " >
                          <center> <img src="{{ asset('imagenes/logo6.png') }}" style="float: left; width: 100%; height: 100%"></center>
                           <center> <p style="font-family:Freestyle Script; font-size:50px">Greenhouse Crops</p></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </body>
</html>
@endsection

