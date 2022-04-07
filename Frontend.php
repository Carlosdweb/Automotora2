<?PHP

require_once("Modelos/Autos.php");
require_once("Modelos/Clientes.php");

$objAutos = new autos();

$arraFilto = ['limite' => "100"];

$listaRandom = $objAutos->listarAutos($arraFilto);




@session_start();

if(isset($_GET['sec'])){

	$_SESSION['seccion'] = $_GET['sec'];

}else{

	// Si da error que no existe cargamos 
	if(!isset($_SESSION['seccion'])){

		$_SESSION['seccion'] = "principal";
	
	// Si existe y es vacio 
	}elseif($_SESSION['seccion'] == ""){
		$_SESSION['seccion'] = "principal";	
	// Si existis y tenes algo 
	}else{

	}

}
	
if(isset($_SESSION['nombre'])){

}else{

}


$objCliente = new clientes();
$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Login"){

	$email = $_POST['txtEmail'];
	$clave 	= $_POST['txtClave'];
	
	$respuesta = $objCliente->login($email, $clave);

	if(isset($respuesta[0]['nombre'])){

		
		@session_start();
		$_SESSION['nombre'] = $respuesta[0]['nombre'];
		$_SESSION['fecha'] 	= date("Y-m-d H:i:s");
	}
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Yanicar Automoviles</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="Web/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="Web/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <img src="Imagenes/Yanicar Automoviles.png" alt="Yanicar Automoviles" width="180px" height="60px">
      <ul class="right hide-on-med-and-down">
      <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#modal3">Registrate</a></li>
        <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#modal2">Ingresar</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
         <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#modal3">Registrate</a></li>
         <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#modal2">Ingresar</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>    
  </nav>

        <div class="container section">
          <div class="row">
            <div class="col s12">
            <h1 class="header center  orange darken-1">Elige el auto de tus sueños</h1>

              <div class="carousel carousel-slider">

                  <a href="" calss="carpusel-item">
                    <img src="imagenes/banner.jpg" alt="">
                  </a>

                 </div>

            </div>
          </div>
       </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">


<?PHP
			      	foreach($listaRandom as $Autos){
?>
					      <div class="col s2 m6">
						        <div class="icon-block">
                        <h3 class="center"><?=$Autos['marca']?> <?=$Autos['modelo']?></h3>
                        <img src="Imagenes/<?=$Autos['foto']?>" width="460px" height="280"/>
                        <li><h5><p class="right red-text ">$ <?=($Autos['precio'])?></p></h5></h5><a class="waves-effect waves-light btn modal-trigger green darken-3" href="#modal1">Reservar</a></li>
							          <p class="center"><?=substr($Autos['descripcion'], 0, 100)?>...</p>
                        <?php

                        ?>
						        </div>
					      </div>
<?PHP
				}
?>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>
        <br><br>    
<!-- Modal Structure -->
<div id="modal3" class="modal">
			<div class="modal-content">				
				<div class="row">
					<form class="col s12" method="POST"action="Frontend.php" >
						<div class="input-field col s12">
							<h3>Ingresar Clientes</h3>
						</div>
						<div class="input-field col s12">
							<input placeholder="Nombre" name="txtNombre" id="first_name" type="text" class="validate">
							<label for="first_name">Nombre</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Apellidos" name="txtApellidos" id="first_name" type="text" class="validate">
							<label for="first_name">Apellidos</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Documentos" name="txtDocumento" id="first_name" type="text" class="validate">
							<label for="first_name">Documentos</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Telefono" name="txtTelefono" id="first_name" type="text" class="validate">
							<label for="first_name">Telefono</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="txtFechaNacimiento" name="txtFechaNacimiento" id="first_name" type="date" class="validate">
							<label for="first_name">Fecha Nacimiento</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Email" name="txtEmail" id="first_name" type="text" class="validate">
							<label for="first_name">Email</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Clave" name="txtClave" id="first_name" type="text" class="validate">
							<label for="first_name">Clave</label>
						</div>
						<input type="hidden" id="idAccion" name="accion" value="Ingresar" >
						<button class="btn waves-effect waves-light cyan darken-3" type="submit">Enviar
							<i class="material-icons right">send</i>
						</button>	
					</form>
				</div>
			</div>
			<div class="modal-footer blue darken-4">
				<a href="#!" class="modal-close waves-effect waves-green btn-flat  white-text">Cancelar</a>
			</div>
		</div>
              
  <!-- Modal Structure -->
  <div id="modal2" class="modal">
			<div class="modal-content">				
				<div class="row">
					<form class="col s12" action="Frontend.php" method="POST">
						<div class="input-field col s12">
							<h3>Ingresar Cliente</h3>
					
						<div class="input-field col s12">
							<input placeholder="Email" name="txtEmail" id="first_name" type="text" class="validate">
							<label for="first_name">Email</label>
						</div>

						</div>
						  <div class="input-field col s12">
						  	<input placeholder="Clave" name="txtClave" id="first_name" type="text" class="validate">
						  	<label for="first_name">Clave</label>
					  	</div>
					    	<input type="hidden" id="idAccion" name="accion" value="Ingresar" >
					      	<button class="btn waves-effect waves-light cyan darken-3" type="submit">Enviar
					  	    	<i class="material-icons right">send</i>
						      </button>	
					</form>
				</div>
			</div>
	    	<div class="modal-footer blue darken-4">
			  	<a href="#!" class="modal-close waves-effect waves-green btn-flat  white-text">Cancelar</a>
    	</div>
  </div>      


  <!-- Modal Structure -->
  <div id="modal1" class="modal">
			<div class="modal-content">				
				<div class="row">
					<form class="col s12" action="Frontend.php" method="POST">
						<div class="input-field col s12">
							<h3>Reservar Auto</h3>
					
						<div class="input-field col s12">
							<input placeholder="Desde" name="txtfechainicio" id="first_name" type="date" class="validate">
							<label for="first_name">Desde</label>
						</div>

						</div>
						  <div class="input-field col s12">
						  	<input placeholder="Hasta" name="txtfechaFinal" id="first_name" type="date" class="validate">
						  	<label for="first_name">Hasta</label>
					  	</div>
					    	<input type="hidden" id="idAccion" name="accion" value="Reservar" >
					      	<button class="btn waves-effect waves-light cyan darken-3" type="submit">Enviar
					  	    	<i class="material-icons right">send</i>
						      </button>	
					</form>
				</div>
			</div>
	    	<div class="modal-footer blue darken-4">
			  	<a href="#!" class="modal-close waves-effect waves-green btn-flat  white-text">Cancelar</a>
    	</div>
  </div>      


        
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">group</i></h2>
            <h5 class="center">la experiencia que gustes</h5>
            <p class="light center">Alquila tu auto y compartelo con hasta 3 conductores al mismo precio de 1.</p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">build</i></h2>
            <h5 class="center">La mejor asistencia</h5>
            <p class="light center">Contamos con la mejor asistencia de auxilio mecanico por cualquier eventualidad, tu auto esta asegurado contra todo, puedes disfrutar tu viaje tranquilo.</p>
          </div>
        </div>
     

      <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">gps_fixed</i></h2>
            <h5 class="center">Tu seguridad y la nuestra</h5>
            <p class="light center">Todos nuestros autos cuentan con monitoreo GPS las 24hs los 365 días.</p>
          </div>
        </div>
      </div>

    </div>
  </div>



  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text ">Nuestra Meta</h5>
          <p class="grey-text text-lighten-4 ">Estamos enfocados a ofrecer el mejor servicio al minimo costo, para ello trabajamos a diario para ofrecer la mejor flota de vehiculos al un precio imbatible. </p>
       </div>
        
        <div class="col l3 s12">
        <h5 class="white-text center">Contacto</h5>
          <ul>
            <li><i class="material-icons">mail</i><a class="white-text" href="#!">Mail</a></li>
            <li><i class="material-icons">local_phone</i><a class="white-text" href="#!">Whatsapp: 092445894</a></li>
            <li><i class="material-icons">local_phone</i><a class="white-text" href="#!">Telefonos: 22004323</a></li>
            <li><i class="material-icons">location_on</i><a class="white-text" href="#!">Direccion: Dr. Magested 1711 Montevideo Uruguay </a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
     
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

		<script src="backend/js/jquery-2.1.1.min.js"></script>
		<script src="backend/js/materialize.js"></script>
		<script src="backend/js/init.js"></script>
		<script>
			
			document.addEventListener('DOMContentLoaded', function() {		

 				M.AutoInit();
				var elems = document.querySelectorAll('.modal');
				var instances = M.Modal.init(elems, options);

				var elems = document.querySelectorAll('.dropdown-trigger');
    			var instances = M.Dropdown.init(elems, options);

			});
		</script>
  <script>
			
      //modal//
    var  options={}
     document.addEventListener('DOMContentLoaded', function() {		
 				var elems = document.querySelectorAll('.modal');
				var instances = M.Modal.init(elems, options);

				var elems = document.querySelectorAll('.dropdown-trigger');
    			var instances = M.Dropdown.init(elems, options);

			});

      //carousel//
		</script>
  <script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var instances = M.Carousel.init(elems);

        $(document).ready(function(){
        $('.carousel').carousel();
  });
      
  });

  //datepicker//
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      m.autoinit()
    });
  </script>

  </body>
</html>
