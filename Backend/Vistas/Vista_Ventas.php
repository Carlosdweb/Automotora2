<?PHP

require_once("Modelos/Ventas.php");
require_once("Modelos/Autos.php");
require_once("Modelos/Clientes.php");


$objVentas = new ventas();

$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

      
    $idCliente  	= $_POST['txtidCliente'];
	$idAuto	        = $_POST['txtidAuto'];
	$precio 	    = $_POST['txtprecio'];
    $fechaInicio 	= $_POST['txtfechaInicio'];
    $fechaFinal 	= $_POST['txtfechaFinal'];
    $estadoEntrega 	= $_POST['selestadoEntrega'];
   
	
	$datos = [
			'idRegistro'	=>'', 
			'estadoRegistro'=>'', 
			'idCliente'		=> $idCliente, 
			'idAuto'		=> $idAuto,
			'precio'		=> $precio, 
            'fechaInicio'	=> $fechaInicio, 
            'fechaFinal'	=> $fechaFinal, 
            'estadoEntrega'	=> $estadoEntrega];
			
	$objVentas->constructor($datos);
	$respuesta = $objVentas->ingresarVenta();

}

if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
		$idRegistro = $_POST['idRegistro'];		
		$objVentas->traerVenta($idRegistro);
	}
	
}

if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];
		
		$objVentas->traerVenta($idRegistro);
		$objVentas->modificarEstadoBorrado();
		$respuesta = $objVentas->guardarVentas();

	}
}


if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objVentas->traerVenta($idRegistro);

	}
}


if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

	$idRegistro 	= $_POST['idRegistro'];		
    $idCliente  	= $_POST['txtidCliente'];
	$idAuto	        = $_POST['txtidAuto'];
	$precio 	    = $_POST['txtprecio'];
    $fechaInicio 	= $_POST['txtfechaInicio'];
    $fechaFinal 	= $_POST['txtfechaFinal'];
    $estadoEntrega 	= $_POST['selestadoEntrega'];
    

		$objVentas->traerVenta($idRegistro);
		$objVentas->idCliente   	= $idCliente;
		$objVentas->idAuto	    	= $idAuto;
		$objVentas->precio      	= $precio;
		$objVentas->fechaInicio		= $fechaInicio;
        $objVentas->fechaFinal		= $fechaFinal;
        $objVentas->estadoEntrega   = $estadoEntrega;

		if(isset($_POST['eliminar']) && $_POST['eliminar'] == "ok" ){
			$objVentas->modificarEstadoBorrado();
		}
		$respuesta = $objVentas->guardarVentas();

	}
}

$arrayFiltros = [];
$BUSCAR = "";

if(isset($_GET['accion']) && $_GET['accion'] == "Buscar"){

	if(isset($_GET['txtBuscar']) && $_GET['txtBuscar'] != ""){

		$arrayFiltros['buscar'] = $_GET['txtBuscar'];
		$BUSCAR 				= $_GET['txtBuscar'];
	}
}


$totalRegistros = $objVentas->totalVentas($arrayFiltros);

if(isset($_GET['pag'])){

	$PAGINA = $_GET['pag'];

	if($PAGINA == "" || $PAGINA <= 0){
		$PAGINA = 0;
		$PAGINAANTERIOR = $PAGINA;	
	}else{
		$PAGINAANTERIOR = $PAGINA - 1;	
	}

	$limitPagina = $totalRegistros / 5;
	if($limitPagina <= ($PAGINA+1) ){
		$PAGINASIGUENTE = $PAGINA;
	}else{
		$PAGINASIGUENTE = $PAGINA + 1;		
	}
	$arrayFiltros['pagina'] = $PAGINA;

}else{

	$PAGINA = 0;
	$PAGINASIGUENTE = $PAGINA + 1;
	$PAGINAANTERIOR = $PAGINA;
	$limitPagina = $totalRegistros / 5;

}

$listaVentas = $objVentas->listarVentas($arrayFiltros);
$listarEstadoEntrega= $objVentas->listarEstadoEntrega();

?>

	<div class="section no-pad-bot" id="index-banner">
		<br><br>
		<h1 class="header center orange-text">Ventas</h1>			
		<br>
		<br>
	</div>

<?PHP	
	if($respuesta != ""){
		
		echo('
			<nav>
				<div class="nav-wrapper center">'.
					$respuesta				
				.'</div>
			</nav>
		');
	}
?>

<?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="row red lighten-5">
				<form class="col s12" action="backend.php" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar la Venta:<?=$objVentas->idRegistro?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objVentas->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves-light red darken-3" type="submit">Eliminar
						<i class="material-icons right">delete_forever</i>
					</button>	
				</form>
			</div>	
<?php
	}
?>

<?php
	if(isset($_POST['accion']) && $_POST['accion'] == "Editar" && isset($_POST['idRegistro']) && $_POST['idRegistro'] != ""){
?>
			<div class="row">
				<form class="col s12" action="backend.php" method="POST">
					<div class="input-field col s12">
						<h3>Editar Venta</h3>
					</div>
					<div class="input-field col s12">
						<input placeholder="idCliente" name="txtidCliente" id="first_name" type="text" class="validate" value="<?=$objVentas->idCliente?>">
						<label for="first_name">Cliente</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="idAuto" name="txtidAuto" id="first_name" type="text" class="validate" value="<?=$objVentas->idAuto?>">
						<label for="first_name">Autos</label>
					</div>
                    <div class="input-field col s12">
						<input placeholder="precio" name="txtprecio" id="first_name" type="text" class="validate" value="<?=$objVentas->precio?>">
						<label for="first_name">Precio</label>
					</div>
                    <div class="input-field col s12">
						<input placeholder="fechaInicio" name="txtfechaInicio" id="first_name" type="date" class="validate" value="<?=$objVentas->fechaInicio?>">
						<label for="first_name">Fecha de Inicio</label>
					</div>
                    <div class="input-field col s12">
						<input placeholder="fechaFinal" name="txtfechaFinal" id="first_name" type="date" class="validate" value="<?=$objVentas->fechaFinal?>">
						<label for="first_name">Fecha de Finalizacion</label>
					</div>
					<div class="input-field col s12">
						<select name="selestadoEntrega">

<?php
							foreach($listarEstadoEntrega as $estadoEntrega => $estadoEntrega){
?>
								<option value="<?=$estadoEntrega?>"><?=$estadoEntrega?></option>

<?PHP
							}
?>	
						</select>
						<label for="first_name">Estado de Entrega</label>
					</div>
					<div class="input-field col s12">
						<div class="switch">
							<label>
							Activado
							<input type="checkbox" name="eliminar" value="ok">
							<span class="lever"></span>
							Eliminar
							</label>
						</div>
					</div>

					<input type="hidden" id="idAccion" name="accion" value="Guardar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objVentas->obtenerIdRegistro()?>">
					<button class="btn waves-effect waves-light cyan darken-3" type="submit">Guardar
						<i class="material-icons right">send</i>
					</button>	
				</form>
			</div>	
<?php
	}
?>

			<table class="striped">
				<thead>
					<tr class="blue darken-3">
						<th colspan="12	">
							<div class="row">
								<div class="col s6">
									<a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#modal1">Ingresar</a>
								</div>
								<div class="col s6">									
									<form class="col s12" action="backend.php" method="GET">	
										<input type="hidden" id="idAccion" name="accion" value="Buscar">
										<button class="btn waves-effect waves-light cyan darken-3 right" type="submit">Buscar
											<i class="material-icons right">search</i>
										</button>							
										<div class="col s6 right">
											<input placeholder="Buscar" name="txtBuscar" id="idBuscar" type="text" value="">
										</div>
									</form>
								</div>
							</div>
						</th>
					</tr>
					<tr class="blue darken-3">
						<th>#Id Registro</th>
						<th>idCliente</th>
						<th>idAuto</th>
						<th>Precio</th>
						<th>Fecha de Inicio</th>
						<th>Fecha de Finalizacion</th>
						<th>Estado de entrega</th>
						<th>Estado</th>
                        <th>Acciones</th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach($listaVentas as $ventas){
?>
					<tr>
						<td><?=$ventas['idVenta']?></td>	
						<td><?=$ventas['idCliente']?></td>
						<td><?=$ventas['idAuto']?></td>
						<td><?=$ventas['precio']?></td>
						<td><?=$ventas['fechaInicio']?></td>
                        <td><?=$ventas['fechaFinal']?></td>
						<td><?=$ventas['estadoEntrega']?></td>
                        <td><?=$ventas['estadoRegistro']?></td>
						<td>
							<form action="backend.php" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								<input type="hidden" name="idRegistro" value="<?=$ventas['idVenta']?>">
								<button class="btn-floating waves-effect waves-light red darken-3" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backend.php" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$ventas['idVenta']?>">
								<button class="btn-floating waves-effect waves-light green darken-3" type="submit" name="action">
									<i class="material-icons right">edit</i>
								</button>
							</form>
                            
						</td>
						
					</tr>					
<?php
				}
?>
					<tr>
						<td colspan="12">
							<span class="right"><?=$totalRegistros?></span>
							<ul class="pagination right">
								<li class="waves-effect">
									<a href="backend.php?pag=<?=$PAGINAANTERIOR?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>">
									<i class="material-icons">chevron_left</i></a>
								</li>
<?php
								for($i = 0; $i < $limitPagina ; $i++){

									$colorear = "waves-effect";
									if($i == $PAGINA){
										$colorear = "active";
									}
?>
										<li class="<?=$colorear?>">
											<a href="backend.php?pag=<?=$i?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><?=$i?></a>
										</li>
<?php 								
								}
?>

								<li class="waves-effect">
									<a href="backend.php?pag=<?=$PAGINASIGUENTE?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>">
										<i class="material-icons">chevron_right</i>
									</a>
								</li>
							</ul>
						</td>
					</tr>

				</tbody>
			</table>
			<br><br>


		  <!-- Modal Structure -->
		 <div id="modal1" class="modal">
			<div class="modal-content">				
				<div class="row">
					<form class="col s12" action="backend.php" method="POST">
						<div class="input-field col s12">
							<h3>Ingresar Venta</h3>
						</div>
						<div class="input-field col s12">
							<input placeholder="idCliente" name="txtidCliente" id="first_name" type="text" class="validate">
							<label for="first_name">idCliente</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="idAuto" name="txtidAuto" id="first_name" type="text" class="validate">
							<label for="first_name">idAuto</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="precio" name="txtprecio" id="first_name" type="text" class="validate">
							<label for="first_name">Precio</label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="fechaInicio" name="txtfechaInicio" id="first_name" type="date" class="validate">
							<label for="first_name">Fecha de Inicio </label>
						</div>
                        <div class="input-field col s12">
							<input placeholder="fechaFinal" name="txtfechaFinal" id="first_name" type="date" class="validate">
							<label for="first_name">Fecha de Finalizacion</label>
						</div>
						<div class="input-field col s12">
							<select name="selestadoEntrega">
<?php
								foreach($listarEstadoEntrega as $estadoEntrega => $estadoEntrega){
?>
									<option value="<?=$estadoEntrega?>"><?=$estadoEntrega?></option>
 <?PHP
								}
?>	
							</select>
							<label for="first_name">Estado Entrega</label>
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

