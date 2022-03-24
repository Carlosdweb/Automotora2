<?PHP

require_once("Modelos/Usuarios.php");




@session_start();

if(isset($_GET['sec'])){

	$_SESSION['seccion'] = $_GET['sec'];

}else{

	if(isset($_SESSION['seccion']) && $_SESSION['seccion'] == ""){
		$_SESSION['seccion'] = "principal";
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
  <link href="Backend/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="Backend/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Usuarios</a></li>
        <li><a href="#">Clientes</a></li>
        <li><a href="#">Autos</a></li>
        <li><a href="#">Ventas</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Usuarios</a></li>
        <li><a href="#">Clientes</a></li>
        <li><a href="#">Autos</a></li>
        <li><a href="#">Ventas</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>
  <div class="section no-pad-bot" id="index-banner">
    <div class="container">

  




      <br><br>
      <h1 class="header center orange-text">YaniCar Automoviles</h1>
      <div class="row center">
        <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
      </div>
      <div class="row center">
        <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light orange">Get Started</a>
      </div>
      <br><br>

    </div>
  </div>


  <div class="container">
    <div class="section">

     
    </div>
    <br><br>
  </div>

  <footer class="page-footer orange">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Company Bio</h5>
          <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>


        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Settings</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text">Connect</h5>
          <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
      </div>
    </div>
  </footer>




  </body>
</html>
