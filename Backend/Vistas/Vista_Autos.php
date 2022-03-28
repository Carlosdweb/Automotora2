<?PHP

require_once("Modelos/Autos.php");

$objAutos = new autos();

$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

	$marca 			= $_POST['txtMarca'];
    $modelo 		= $_POST['txtModelo'];
    $descripcion 	= $_POST['txtDescripcion'];
    $foto       	= $_POST['txtfoto'];
    $pasajeros 	    = $_POST['txtpasajeros'];
	$tipovehiculo   = $_POST['txtTipovehiculo'];
	$precio 		= $_POST['txtPrecio'];
        
	$datos = [
			'idRegistro'	=>'', 
			'estadoRegisto' =>'', 
			'marca'		    => $marca, 
			'modelo'		=> $modelo, 
			'descripcion'	=> $descripcion, 
			'foto'	        => $foto, 
			'pasajeros'		=> $pasajeros, 
			'tipovehiculo'	=> $tipovehiculo,
			'precio'		=> $precio];

           

	$objAutos->constructor($datos);
	$respuesta = $objAutos->ingresarAuto();

}

if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
		$idRegistro = $_POST['idRegistro'];		
		$objAutos->traerAutos($idRegistro);
	}
	
}

if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];
		
		$objAutos->traerAutos($idRegistro);
		$objAutos->modificarEstadoBorrado();
		$respuesta = $objAutos->guardarAuto();

	}
}


if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objAutos->traerAutos($idRegistro);

	}
}


if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro 	= $_POST['idRegistro'];		
        $marca 			= $_POST['txtMarca'];
        $modelo 		= $_POST['txtModelo'];
        $descripcion 	= $_POST['txtDescripcion'];
        $foto       	= $_POST['txtfoto'];
        $pasajeros 	    = $_POST['txtpasajeros'];
        $tipovehiculo   = $_POST['txtTipovehiculo'];
        $precio 		= $_POST['txtPrecio'];

       

		$objAutos->traerAutos($idRegistro);
		$objAutos->marca        = $marca;
		$objAutos->modelo 	    = $modelo;
		$objAutos->descripcion 	= $descripcion;
		$objAutos->foto 	    = $foto;
		$objAutos->pasajeros 	= $pasajeros;
		$objAutos->tipovehiculo	= $tipovehiculo;
		$objAutos->precio		= $precio;

		if(isset($_POST['eliminar']) && $_POST['eliminar'] == "ok" ){
			$objAutos->modificarEstadoBorrado();
		}
		$respuesta = $objAutos->guardarAuto();

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


$totalRegistros = $objAutos->totalAutos($arrayFiltros);

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

$listaClientes = $objAutos->listarAutos($arrayFiltros);

?>

	<div class="section no-pad-bot" id="index-banner">
		<br><br>
		<h1 class="header center orange-text">Autos</h1>			
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
						<h3>Eliminar el Auto:<?=$objAutos->marca?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objAutos->obtenerIdRegistro()?>">
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
						<h3>Ingresar Auto</h3>
					</div>
					<div class="input-field col s12">
						<input placeholder="Marca del Auto" name="txtMarca" id="first_name" type="text" class="validate" value="<?=$objAutos->marca?>">
						<label for="first_name">Marca</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Apellidos Cliente" name="txtApellidos" id="first_name" type="text" class="validate" value="<?=$objAutos->modelo?>">
						<label for="first_name">Modelo</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Descripcion del Auto" name="txtDescripcion" id="first_name" type="text" class="validate" value="<?=$objAutos->descripcion?>">
						<label for="first_name">Descripcion</label>

                        <div class="file-field input-field col s12">
				    		<div class="btn">
								<span>Sube aqui la imagen del Auto</span>
								<input type="file" name="txtFoto" placeholder="Imagen del Auto">
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text">
							</div>
					    </div>

					<div class="input-field col s12">
						<input placeholder="Cantidad de Pasajeros" name="txtPasajeros" id="first_name" type="text" class="validate" value="<?=$objAutos->pasajeros?>">
						<label for="first_name">Cantidad de Pasajeros</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Tipo de Vehiculo" name="txtTipoVehiculo" id="first_name" type="text" class="validate" value="<?=$objAutos->tipovehiculo?>">
						<label for="first_name">Tipo de Vehiculo</label>
					</div>
					
					<div class="input-field col s12">
						<input placeholder="Precio" name="txtPrecio" id="first_name" type="text" class="validate" value="<?=$objAutos->precio?>">
						<label for="first_name">Precio</label>
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
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objAutos->obtenerIdRegistro()?>">
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
						<th colspan="8">
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
						<th>Marca</th>
						<th>Modelo</th>
						<th>Descripcion</th>
						<th>Foto</th>
						<th>Pasajeros</th>
						<th>Tipo de Vehiculo</th>
						<th>Precio</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach($listaAutos as $Autos){
?>
					<tr>
						<td><?=$Autos['idAuto']?></td>	
						<td><?=$Autos['marca']?></td>
						<td><?=$Autos['modelo']?></td>
						<td><?=$Autos['descripcion']?></td>
						<td><?=$Autos['foto']?></td>
						<td><?=$Autos['pasajeros']?></td>
						<td><?=$Autos['tipovehiculo']?></td>
						<td><?=$Autos['precio']?></td>
						<td><?=$Autos['estadoRegistro']?></td>
						<td>
							<form action="backend.php" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								<input type="hidden" name="idRegistro" value="<?=$Autos['idAutos']?>">
								<button class="btn-floating waves-effect waves-light red darken-3" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backend.php" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$Autos['idAutos']?>">
								<button class="btn-floating waves-effect waves-light green darken-3" type="submit" name="action">
									<i class="material-icons right">edit</i>
								</button>
							</form>
                            <form action="backend.php" method="POST">
								<input type="hidden" name="accion" value="Activar">
								<input type="hidden" name="idRegistro" value="<?=$Autos['idAutos']?>">
								<button class="btn-floating waves-effect waves-light green darken-3" type="submit" name="action">
									<i class="material-icons right">check</i>
								</button>
							</form>
						</td>
						
					</tr>					
<?php
				}
?>
					<tr>
						<td colspan="8">
							<span class="right"><?=$totalRegistros?></span>
							<ul class="pagination right">
								<li class="waves-effect">
									<a href="backend.php?pag=<?=$PAGINAANTERIOR?>&accion=Buscar&txtBuscar=<?=$BUSCAR?>"><i class="material-icons">chevron_left</i></a>
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
							<h3>Ingresar Autos</h3>
						</div>
						<div class="input-field col s12">
							<input placeholder="Marca" name="txtMarca" id="first_name" type="text" class="validate">
							<label for="first_name">Marca</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Modelo" name="txtModelo" id="first_name" type="text" class="validate">
							<label for="first_name">Modelo</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Descripcion" name="txtDescripcion" id="first_name" type="text" class="validate">
							<label for="first_name">Descripcion</label>
						</div>
						<div class="file-field input-field col s12">
				    		<div class="btn">
								<span>Sube Aqui la imagen del Auto</span>
								<input type="file" name="txtImagen" placeholder="imagen">
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text">
							</div>
					    </div>
						<div class="input-field col s12">
							<input placeholder="Pasajeros" name="txtPasajeros" id="first_name" type="text" class="validate">
							<label for="first_name">Pasajeros</label>
						</div>
						<div class="input-field col s12">
							<input placeholder="Tipo de Vehiculo" name="txtTipovehiculo" id="first_name" type="text" class="validate">
							<label for="first_name">Tipo de Vehiculo</label>
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