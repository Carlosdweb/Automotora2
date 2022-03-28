

<?php



require_once("Modelos/Autos.php");

$objAutos = new autos();

$arraFilto = ['limite' => "4"];

$listaRandom = $objAutos->listarAutos($arraFilto);


?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>YaniCar Automoviles</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="Web/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="Web/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <img src="Imagenes/Yanicar Automoviles.png"></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Login</a></li>
      </ul>

      <ul id="nav-mobile" class="side-nav">
        <li><a href="#">Login</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center teal-text text-lighten-2">YaniCar Automoviles</h1>
        <div class="row center">
          <h5 class="header col s12 red-text">El Auto de tus sueños al alcance de tu bolsillo</h5>
        </div>
        <br><br>
     </div>
    </div>
    <div class="parallax">
        <img src="Imagenes/autos background.png" alt="Unsplashed background autos"></div>
  </div>




  <div class="carousel carousel-slider">
    <a class="carousel-item" href="#one!"><img src="imagenes/aveo blanco.png"></a>
    <a class="carousel-item" href="#two!"><img src="imagenes/cammaro negro.png"></a>
    <a class="carousel-item" href="#three!"><img src="imagenes/renault clio blanco.jpg"></a>
    <a class="carousel-item" href="#four!"><img src="imagenes/micro bus mercedes.jpg"></a>
  </div>
        
        

  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">

      <?PHP
				foreach($listaRandom as $Autos){
?>
					<div class="col s6 m6">
						<div class="icon-block">
							<img src="Imagenes<?=$Autos['Foto']?>" width="480px" height="480px" />
							<h5 class="center"><?=$Autos['Marca']?></h5>
							<p class="light"><?=substr($Autos['Descripcion'], 0, 100)?>...</p>
						</div>
					</div>
<?PHP
				}
?>


    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 red-text">A modern responsive front-end framework based on Material Design</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="Imagenes/autos background.png" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h4>Contact Us</h4>
          <p class="left-align light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam scelerisque id nunc nec volutpat. Etiam pellentesque tristique arcu, non consequat magna fermentum ac. Cras ut ultricies eros. Maecenas eros justo, ullamcorper a sapien id, viverra ultrices eros. Morbi sem neque, posuere et pretium eget, bibendum sollicitudin lacus. Aliquam eleifend sollicitudin diam, eu mattis nisl maximus sed. Nulla imperdiet semper molestie. Morbi massa odio, condimentum sed ipsum ac, gravida ultrices erat. Nullam eget dignissim mauris, non tristique erat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
        </div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="Imagenes/autos background.png" alt="Unsplashed background img 3"></div>
  </div>

  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text">Sobre Nosotros</h5>
          <p class="grey-text text-lighten-4">Estamos enfocados a ofrecer el mejor servicio al minimo costo, para ello trabajamos a diario para ofrecer la mejor flota de vehiculos al un precio imbatible.</p>
        </div>
        
        <div class="col l3 s12">
          <h5 class="white-text">Contacto</h5>
          <ul>
            <li><a class="white-text" href="#!">Whatsapp</a></li>
            <li><a class="white-text" href="#!">Mail</a></li>
            <li><a class="white-text" href="#!">Telefono</a></li>
            
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Made by <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a>
      </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="js/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/init.js"></script>

  <script>

        var instance = M.Carousel.init({
        fullWidth: true
       
  });

  </script>

  </body>
</html>
