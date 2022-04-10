<?PHP

require_once("Modelos/Usuarios.php");




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



$objUsuarios = new usuarios();
$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Login"){

	$email = $_POST['txtEmail'];
	$clave 	= $_POST['txtClave'];
	
	$respuesta = $objUsuarios->login($email, $clave);

	if(isset($respuesta[0]['nombre'])){

		
		@session_start();
		$_SESSION['nombre'] = $respuesta[0]['nombre'];
		$_SESSION['fecha'] 	= date("Y-m-d H:i:s");
		$_SESSION['perfil'] = $respuesta[0]['perfil'];

	
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>YaniCar Automoviles</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="Backend/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="Backend/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
	<img src="Imagenes/Yanicar Automoviles.png" alt="Yanicar Automoviles" width="180px" height="60px">
		<a id="logo-container" href="Imagenes/Yanicar Automoviles.png" class="brand-logo"></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="backend.php?sec=Usuarios">Usuarios</a></li>
        <li><a href="backend.php?sec=Clientes">Clientes</a></li>
        <li><a href="backend.php?sec=Autos">Autos</a></li>
        <li><a href="backend.php?sec=Ventas">Ventas</a></li>
		<li>	
						<a class='dropdown-trigger btn' href='backend.php' data-target='dropdown1'>Menu</a>
							<!-- Dropdown Structure -->
							<ul id='dropdown1' class='dropdown-content'>
								<li class="divider" tabindex="-1"></li>
								<li><a href="Cerrar_Sesion.php"><i class="material-icons">cloud</i>LogOut</a></li>
      						</ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="backend.php?sec=Usuarios">Usuarios</a></li>
        <li><a href="backend.php?sec=Clientes">Clientes</a></li>
        <li><a href="backend.php?sec=Autos">Autos</a></li>
        <li><a href="backend.php?sec=Ventas">Ventas</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">

			
    <?php
		if(!isset($_SESSION['nombre'])){
	?>
			<br><br>
      <h1 class="header center orange-text">YaniCar Automoviles</h1>
      <div class="row center">
        <h2 class="header col s12 solid indigo-text">Bienvenidos Usuarios</h2>
      </div>	
				<br>
			</div>
			<div class="row center">
				<form class="col s9" method="POST" action="backend.php">
			 		<div class="row center">
						<div class="input-field col s6">
							<input name="txtEmail" id="email" type="email" class="validate">
							<label for="email">Email</label>
						</div>
					</div>	
					<div class="row center">
						<div class="input-field col s6">
							<input name="txtClave" id="password" type="password" class="validate">
							<label for="password">Contraseña</label>
			 			</div>
					</div>			 
					<div>
						<input type="hidden" id="idAccion" name="accion" value="Login" >
						<button class="btn waves-effect waves-light cyan darken-3" type="submit">Iniciar Sesion
							<i class="material-icons right">send</i>
						</button>	
					</div>     	
				</form>			
			</div>	
<?php
		}else{

			if($_SESSION['seccion'] == "Autos"){

				// Valido los permisos de los usuarios 
				if($_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Supervisor"  ){		
					
					
					include("backend/Vistas/Vista_Autos.php");
				
				}else{
?>
						<div class="section no-pad-bot" id="index-banner">
							<br><br>
							<h1 class="header center solid red-text">Usted no tiene permiso en esta seccion </h1>			
							<br>
							<br>
						</div>
<?PHP
				}				

			}elseif($_SESSION['seccion'] == "Ventas"){				

				// Valido los permisos de los usuarios 
				if($_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Supervisor" || $_SESSION['perfil'] == "Vendedor" ){

					include("backend/Vistas/Vista_Ventas.php");
				
				}else{
?>
					<div class="section no-pad-bot" id="index-banner">
						<br><br>
						<h1 class="header center solid red-text">Usted no tiene permiso en esta seccion </h1>			
						<br>
						<br>
					</div>
<?PHP
		
				}

			}elseif($_SESSION['seccion'] == "Usuarios"){				

				// Valido los permisos de los usuarios 
				if($_SESSION['perfil'] == "Administrador" ){

					include("backend/Vistas/Vista_Usuarios.php");

				}else{
?>
					<div class="section no-pad-bot" id="index-banner">
						<br><br>
						<h1 class="header center solid red-text">Usted no tiene permiso en esta seccion </h1>			
						<br>
						<br>
					</div>

<?PHP							
				}

			}elseif($_SESSION['seccion'] == "Clientes"){				

				// Valido los permisos de los usuarios 
				if($_SESSION['perfil'] == "Administrador" || $_SESSION['perfil'] == "Supervisor" || $_SESSION['perfil'] == "Vendedor" ){
					
                    include("backend/Vistas/Vista_Clientes.php");
				}

			}else{
?>
				<h1 class="header center orange-text">Bienvenido <?=$_SESSION['nombre']?> </h1>
<?PHP 
			}	
		}
?>

		</div>
		<!-- CIERRO CONTAINER -->
		<br><br><br><br>
		<br><br><br><br>
		<br><br><br><br>
		<footer class="page-footer blue darken-4">
			<div class="container">				
			</div>
			<div class="footer-copyright">
				<div class="container">
					Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
				</div>
			</div>
		</footer>
		<!--  Scripts-->
		
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
	</body>
</html>