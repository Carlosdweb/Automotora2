

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
  <link rel="stylesheet" href="Web\css/estilos_carousel.css">
</head>
<body>
  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" img src="Imagenes/Yanicar Automoviles.png"class="brand-logo">Logo</a>
    
      <ul class="right hide-on-med-and-down">
        <li><a href="#">Login</a></li>
        <li><a href="#">Autos</a></li>
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
    <div class="container">
        <div class="row">
            <div class="col s12">
             <div class="carousel center-align">
                   <img src="Imagenes/cammaro negro.png" alt="">
                    </div>
              </div>
            </div>
        </div>       
  
   </div>
       

  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">


      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center -text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up development</h5>

            <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>

        <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center -text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up development</h5>

            <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>

         <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center -text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up development</h5>

            <p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>
          </div>
        </div>

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
  <script src="Web/js/jquery-2.1.1.min.js"></script>
  <script src="Web/js/materialize.js"></script>
  <script src="Web/js/init.js"></script>
  <script src="Web/js/carousel.js"></script>
  
  </body>
</html>
