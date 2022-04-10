<?PHP

require_once("Modelos/Clientes.php");

$objClientes = new clientes();

$respuesta = "";

if(isset($_POST['accion']) && $_POST['accion'] == "Ingresar"){

	$nombre 			= $_POST['txtNombre'];
    $apellidos 			= $_POST['txtApellidos'];
    $documento 			= $_POST['txtDocumento'];
    $fechaNacimiento	= $_POST['txtfechaNacimiento'];
    $telefono 			= $_POST['txtTelefono'];
	$email	 			= $_POST['txtEmail'];
	$clave 				= $_POST['txtClave'];
        
	$datos = [
			'idRegistro'		=>'', 
			'estadoRegistro'	=>'', 
			'nombre'			=> $nombre, 
			'apellidos'			=> $apellidos, 
			'documento'			=> $documento, 
			'fechaNacimiento'	=> $fechaNacimiento, 
			'telefono'			=> $telefono, 
			'email'				=> $email,
			'clave'				=> $clave];

           

	$objClientes->constructor($datos);
	$respuesta = $objClientes->ingresarClientes();

}

if(isset($_POST['accion']) && $_POST['accion'] == "Eliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){
		$idRegistro = $_POST['idRegistro'];		
		$objClientes->traerClientes($idRegistro);
	}
	
}

if(isset($_POST['accion']) && $_POST['accion'] == "ConfirmarEliminar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];
		
		$objClientes->traerClientes($idRegistro);
		$objClientes->modificarEstadoBorrado();
		$respuesta = $objClientes->guardarClientes();

	}
}


if(isset($_POST['accion']) && $_POST['accion'] == "Editar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro = $_POST['idRegistro'];		
		$objClientes->traerClientes($idRegistro);

	}
}


if(isset($_POST['accion']) && $_POST['accion'] == "Guardar"){
	
	if(isset($_POST['idRegistro']) && $_POST['idRegistro'] != "" ){

		$idRegistro 	 = $_POST['idRegistro'];		
		$nombre 		 = $_POST['txtNombre'];
   		$apellidos 		 = $_POST['txtApellidos'];
   		$documento 		 = $_POST['txtDocumento'];
     	$fechaNacimiento = $_POST['txtfechaNacimiento'];
     	$telefono 		 = $_POST['txtTelefono'];
		$email	 		 = $_POST['txtEmail'];
		$clave 			 = $_POST['txtClave'];

		$objClientes->traerClientes($idRegistro);
		$objClientes->nombre 			= $nombre;
		$objClientes->apellidos 		= $apellidos;
		$objClientes->documento 		= $documento;
		$objClientes->fechaNacimiento 	= $fechaNacimiento;
		$objClientes->telefono 			= $telefono;
		$objClientes->email				= $email;
		$objClientes->clave				= $clave;

		if(isset($_POST['eliminar']) && $_POST['eliminar'] == "ok" ){
			$objClientes->modificarEstadoBorrado();
		}
		$respuesta = $objClientes->guardarClientes();

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


$totalRegistros = $objClientes->totalClientes($arrayFiltros);

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

$listaClientes = $objClientes->listarClientes($arrayFiltros);

?>

	<div class="section no-pad-bot" id="index-banner">
		<br><br>
		<h1 class="header center orange-text">Clientes</h1>			
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
				<form class="col s12" action="backend.php?Clientes" method="POST">
					<div class="input-field col s12">
						<h3>Eliminar el Cliente:<?=$objClientes->nombre?>?</h3>
					</div>					
					<input type="hidden" id="idAccion" name="accion" value="ConfirmarEliminar">
					<input type="hidden" id="idRegistro" name="idRegistro" value="<?=$objClientes->obtenerIdRegistro()?>">
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
				<form class="col s12" action="backend.php?Clientes" method="POST">
					<div class="input-field col s12">
						<h3>Modificar Cliente</h3>
					</div>
					<div class="input-field col s12">
						<input placeholder="Nombre Cliente" name="txtNombre" id="first_name" type="text" class="validate" value="<?=$objClientes->nombre?>">
						<label for="first_name">Nombre</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Apellidos Cliente" name="txtApellidos" id="first_name" type="text" class="validate" value="<?=$objClientes->apellidos?>">
						<label for="first_name">Apellidos</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Documento Cliente" name="txtDocumento" id="first_name" type="text" class="validate" value="<?=$objClientes->documento?>">
						<label for="first_name">Documento</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Fecha Nacimiento Cliente" name="txtfechaNacimiento" id="first_name" type="date" class="validate" value="<?=$objClientes->fechaNacimiento?>">
						<label for="first_name">Fecha Nacimiento</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Telefono Cliente" name="txtTelefono" id="first_name" type="text" class="validate" value="<?=$objClientes->telefono?>">
						<label for="first_name">Telefono</label>
					</div>
					<div class="input-field col s12">
						<input placeholder="Email" name="txtEmail" id="first_name" type="text" class="validate" value="<?=$objClientes->email?>">
						<label for="first_name">Email</label>
					</div>
					
					<div class="input-field col s12">
						<input placeholder="clave" name="txtClave" id="first_name" type="text" class="validate" value="<?=$objClientes->clave?>">
						<label for="first_name">Clave</label>
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
					<input type="hidden" id="idCliente" name="idRegistro" value="<?=$objClientes->obtenerIdRegistro()?>">
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
						<th colspan="12">
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
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Documento</th>
						<th>Fecha Nacimiento</th>
						<th>Telefono</th>
						<th>Email</th>
						<th>Clave</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach($listaClientes as $Clientes){
?>
					<tr>
						<td><?=$Clientes['idCliente']?></td>	
						<td><?=$Clientes['nombre']?></td>
						<td><?=$Clientes['apellidos']?></td>
						<td><?=$Clientes['documento']?></td>
						<td><?=$Clientes['fechaNacimiento']?></td>
						<td><?=$Clientes['telefono']?></td>
						<td><?=$Clientes['email']?></td>
						<td><?=$Clientes['clave']?></td>
						<td><?=$Clientes['estadoRegistro']?></td>
						<td>
							<form action="backend.php?Clientes" method="POST">
								<input type="hidden" name="accion" value="Eliminar">
								<input type="hidden" name="idRegistro" value="<?=$Clientes['idCliente']?>">
								<button class="btn-floating waves-effect waves-light red darken-3" type="submit" name="action">
									<i class="material-icons right">delete_forever</i>
								</button>
							</form>
							<form action="backend.php?Clientes" method="POST">
								<input type="hidden" name="accion" value="Editar">
								<input type="hidden" name="idRegistro" value="<?=$Clientes['idCliente']?>">
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
							<input placeholder="Fecha Nacimiento" name="txtfechaNacimiento" id="first_name" type="date" class="validate">
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