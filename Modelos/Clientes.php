<?php

require_once("Generico.php");

class clientes extends generico{

	/*
		Esta clase maneja a los Clientes  del sistema.
	*/
	public $idCliente;
	// Nombre del usuario
	public $nombre;
	
	public $apellidos;

	public $documento;

	public $FechaNacimiento;

	public $telefono;
	// Es el Email con el que se loguea el usuario
	public $email;
	
	public $clave;

	


	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->nombre 			= $this->chequeadorConstructor($arrayDatos, 'nombre', ''); 
		$this->email			= $this->chequeadorConstructor($arrayDatos, 'email', ''); 
		$this->apellidos		= $this->chequeadorConstructor($arrayDatos, 'apellidos', ''); 
		$this->documento		= $this->chequeadorConstructor($arrayDatos, 'documento', ''); 
		$this->fechaNacimiento	= $this->chequeadorConstructor($arrayDatos, 'fechaNacimiento', ''); 
		$this->telefono			= $this->chequeadorConstructor($arrayDatos, 'telefono', ''); 
		$this->clave			= $this->chequeadorConstructor($arrayDatos, 'clave', ''); 
		$this->estadoRegistro 	= $this->chequeadorConstructor($arrayDatos, 'estado', 'Ingresado'); 
	}

	public function ingresarClientes(){
		
		/*
			Primero evaluo si el usuario esta ingresado
			1) chequeo que exista el usuario con nombre y el email
		*/
		try{

			$varSQL = 'SELECT * FROM clientes WHERE nombre = :nombre AND email = :email;';		
			$arrayCliente = array('nombre' => $this->nombre, 'email' => $this->email );
			$respuesta = $this->traerListado($varSQL, $arrayCliente);

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese usuario esta ingresado
				*/
				return "Ya esta ingresado el Cliente";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO clientes SET
						nombre			= :nombre,
						apellidos		= :apellidos,
						documento		= :documento,
						fechaNacimiento	= :fechaNacimiento,
						telefono		= :telefono,
						email  			= :email,
						clave			= :clave,
						estadoRegistro	= :estadoRegistro,
						fechaEdicion	= :fechaEdicion,
						historial 		= '';
				";

			$clave = md5($this->clave);	

			$arrayCliente = array(
				"nombre"			=>	$this->nombre,
				"apellidos"			=>	$this->apellidos,
				"documento"			=>	$this->documento,
				"fechaNacimiento"	=>	$this->fechaNacimiento,
				"telefono" 			=>  $this->telefono,
				"email" 			=>  $this->email,
				"clave"				=>	$clave,				
				"estadoRegistro"	=>	$this->estadoRegistro,
				"fechaEdicion"		=>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayCliente);

			if($respuesta == 1){
				$retorno = "Se ingreso el Cliente correctamente";
			}else{
				$retorno = "Error al ingresar el Cliente";
			}
			return $retorno;

		}catch(PDOException $e){
			$retorno = "Ocurrio Un error al ingresar Cliente";
			return $retorno;
		}

	}// ingresarCliente

	public function traerClientes($idRegistro){
		
		$varSQL 	= 'SELECT * FROM clientes WHERE idCliente = :idCliente;';
		$arrayCliente = array('idCliente' => $idRegistro);

		$respuesta = $this->traerListado($varSQL, $arrayCliente);

		$this->idRegistro 		= $respuesta[0]['idCliente'];
		$this->nombre			= $respuesta[0]['nombre'];
		$this->apellidos		= $respuesta[0]['apellidos'];
		$this->documento		= $respuesta[0]['documento'];
		$this->fechaNacimiento	= $respuesta[0]['fechaNacimiento'];
		$this->telefono			= $respuesta[0]['telefono'];
		$this->email			= $respuesta[0]['email'];
		$this->clave			= $respuesta[0]['clave'];
		$this->estadoRegistro	= $respuesta[0]['estadoRegistro'];

	}// traerCliente


	public function guardarClientes(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE clientes SET
					nombre			= :nombre,
					apellidos		= :apellidos,
					documento		= :documento,
					fechaNacimiento	= :fechaNacimiento,
					telefono		= :telefono,
					email  			= :email,
					clave			= :clave,
					estadoRegistro	= :estado,
					fechaEdicion	= :fechaEdicion,
					historial 		= ''
				WHERE idCliente     = :idCliente;
			";


		$arrayCliente = array(
			"nombre"			=>	$this->nombre,
			"apellidos"			=>	$this->apellidos,
			"documento"			=>	$this->documento,
			"fechaNacimiento"	=>	$this->fechaNacimiento,
			"telefono"			=>	$this->nombre,
			"email" 			=>  $this->email,
			"clave"				=>	$this->clave,				
			"estado"			=>	$this->estadoRegistro,
			"fechaEdicion"		=>  $fecha,
			"idCliente" 		=>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayCliente);
		if($respuesta == 1){
			$retorno = "Se guardo el Cliente correctamente";
		}else{
			$retorno = "Error al guardar el Cliente";
		}
		return $retorno;

	}//guardarCliente


	public function listarClientes($filtos = array()){
		
		//$varSQL = 'SELECT * FROM clientes';

		// Evaluo si existe en el array que recibo la clave pagina en caso contrario pongo por defecto 0.
		if(isset($filtos['pagina']) && $filtos['pagina'] != "" ){			
			$pagina = $filtos['pagina'];
		}else{
			$pagina = 0;
		}
		// Evaluo si existe en el array que recibo la clave limite en caso contrario pongo por defecto 10.
		if(isset($filtos['limite']) && $filtos['limite'] != "" ){
			$limite = $filtos['limite'];
		}else{
			$limite = 5;
		}
		//      SELECT * FROM usuarios LIMIT 0,10; 
		$puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE nombre LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM clientes ".$buscador."  ORDER BY nombre LIMIT ".$puntoSalida.",".$limite."";

		$retorno = $this->traerListado($varSQL, array());
		return $retorno;

	}//listarUsuarios
	
	public function totalClientes($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE nombre LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM clientes '.$buscador.'';
		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}//totalClientes

	
	public function login($email, $clave){
		
		$retorno = "";
		$claMD5 = md5($clave);	

		$varSQL 	= 'SELECT * FROM clientes WHERE email = :email AND clave = :clave ;';
		$arrayClientes 	= array('email' => $email, 'clave' => $clave);

		
		$respuesta = $this->traerListado($varSQL, $arrayClientes);

		if(empty($respuesta)){
			/*
				En caso que tenga registro entro aca y devuelvo que ya ese usuario esta ingresado
			*/
			return "Error en las credenciales";
		}

		return $respuesta;

	}//totalClientes



}





?>