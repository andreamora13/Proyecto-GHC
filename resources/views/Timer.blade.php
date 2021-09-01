
<!DOCTYPE html>

<html>
<head>
    <title>Proyecto</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="{{asset('css/stylesPrueba.css')}}" rel="stylesheet" text="text/css">
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
        
        var r= diff.getUTCSeconds();
        document.getElementById('cro').innerHTML = r;
        if(r == 15)
        {
           reinicio();
            
           $.ajax({
                             url:'{{ action('ProController@semana')}}',
                             
                                 success: function(data) {
                                     document.body.innerHTML=data;;
                                     
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
<body onload="empezar(this);">
  <td align="center"><p id='cro'>0</p></td>
</body>
</html>
