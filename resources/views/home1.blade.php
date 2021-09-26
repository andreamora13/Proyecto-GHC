
<!DOCTYPE html>
<html lang="es">
    <head>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
    var inicio=0;
    var timeout=0;
   
    function empezar(elemento)
    {
        
 
            // Obtenemos el valor actual
            inicio=new Date().getTime();
 
            // Guardamos el valor inicial en la base de datos del navegador
            localStorage.setItem("inicio",inicio);
            
            // iniciamos el proceso
            funcionando();
        
    }
    
    function reinicio(elemento)
    {
       
            // detener el cronometro
 
            clearTimeout(timeout);
 
            // Eliminamos el valor inicial guardado
            localStorage.removeItem("inicio");
            timeout=0;
            
            empezar();
        
    }
     function Detener(elemento)
    {
       
            // detener el cronometro
 
            clearTimeout(timeout);
 
            // Eliminamos el valor inicial guardado
            localStorage.removeItem("inicio");
            timeout=0;
           
        
    }
 
 
    function funcionando()
    {
        // obteneos la fecha actual
        var actual = new Date().getTime();
 
        // obtenemos la diferencia entre la fecha actual y la de inicio
        var diff=new Date(actual-inicio);
 
        // mostramos la diferencia entre la fecha actual y la inicial
        var result=LeadingZero(diff.getUTCHours())+":"+LeadingZero(diff.getUTCMinutes())+":"+LeadingZero(diff.getUTCSeconds());
        document.getElementById('crono').innerHTML = result;
        var m= diff.getUTCMinutes();
        var r= diff.getUTCSeconds();
        document.getElementById('cro').innerHTML = r;
        document.getElementById('croeo').innerHTML = m;
        if(r == 59)
        {
           
            
            $.ajax({
                             url:'{{ action('ProController@espera')}}',
                             
                                 success: function(data) {
                                    window.location.href = "/espera"
                                     
                                  },
                                error: function() {
                                    alert('There was some error performing the AJAX call!');
                                 }
                              }
            );
        }
       
        
        
        // Indicamos que se ejecute esta función nuevamente dentro de 1 segundo
        timeout=setTimeout("funcionando()",1000);
    }
 
    /* Funcion que pone un 0 delante de un valor si es necesario */
    function LeadingZero(Time)
    {
        return (Time < 10) ? "0" + Time : + Time;
    }

 
    window.onload=function()
    {
        if(localStorage.getItem("inicio")!=null)
        {
            // Si al iniciar el navegador, la variable inicio que se guarda
            // en la base de datos del navegador tiene valor, cargamos el valor
            // y iniciamos el proceso.
            inicio=localStorage.getItem("inicio");
           
            funcionando();
        }
    }

    </script>
    
    </head>

    <body class="main-layout ">
        <h2 id='crono'>00:00:00</h2>
        <h2 id='cro'>00:00:00</h2>
        <h2 id='croeo'>00:00:00</h2>
        <input type="button" value="Empezar" id="boton" onclick="empezarDetener(this);">
        <input type="button" value="Empezar" id="boton" onclick="empezar(this);">
        <input type="button" value="Detener" id="boton" onclick="detener(this);">
        <input type="button" value="Seguir" id="boton" onclick="reinicio();">
    
    </body>

</html>
