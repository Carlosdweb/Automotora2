<?php

require_once("Generico.php");

class usuarios extends generico{

	/*
		Esta clase maneja a los usarios internos del sistema.
	*/

	// Nombre del usuario
	public $nombre;
	// Es el Email con el que se loguea el usuario
	public $email;

	public $clave;

	public $perfil;


	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->nombre 	= $this->chequeadorConstructor($arrayDatos, 'nombre', ''); 
		$this->email	= $this->chequeadorConstructor($arrayDatos, 'email', ''); 
		$this->clave	= $this->chequeadorConstructor($arrayDatos, 'clave', ''); 
		$this->perfil	= $this->chequeadorConstructor($arrayDatos, 'perfil', 'Vendedor'); 
		$this->estadoRegistro = $this->chequeadorConstructor($arrayDatos, 'estado', 'Ingresado'); 
	}

	public function ingresarUsuario(){
		
		/*
			Primero evaluo si el usuario esta ingresado
			1) chequeo que exista el usuario con nombre y el email
		*/
		try{

			$varSQL = 'SELECT * FROM usuarios WHERE nombre = :nombre AND email = :email;';		
			$arrayUsuario = array('nombre' => $this->nombre, 'email' => $this->email );
			$respuesta = $this->traerListado($varSQL, $arrayUsuario);

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese usuario esta ingresado
				*/
				return "Ya esta ingresado el usuario";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO usuarios SET
						nombre			= :nombre,
						email  			= :email,
						clave			= :clave,
						perfil			= :perfil,
						estadoRegistro	= :estadoRegistro,
						fechaEdicion	= :fechaEdicion,
						historial 		= '';
				";

			$clave = md5($this->clave);	

			$arrayUsuario = array(
				"nombre"			=>	$this->nombre,
				"email" 			=>  $this->email,
				"clave"				=>	$clave,				
				"perfil"			=>	$this->perfil,
				"estadoRegistro"	=>	$this->estadoRegistro,
				"fechaEdicion"		=>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayUsuario);

			if($respuesta == 1){
				$retorno = "Se ingreso el usuario correctamente";
			}else{
				$retorno = "Error al ingresar el usuario";
			}
			return $retorno;

		}catch(PDOException $e){
			$retorno = "Ocurrio Un error al ingresar usuarios";
			return $retorno;
		}

	}// ingresarUsuario

	public function traerUsuario($idRegistro){
		
		$varSQL 	= 'SELECT * FROM usuarios WHERE idUsuario = :idUsuario;';
		$arrayUsuario = array('idUsuario' => $idRegistro);

		$respuesta = $this->traerListado($varSQL, $arrayUsuario);

		$this->idRegistro 		= $respuesta[0]['idUsuario'];
		$this->nombre			= $respuesta[0]['nombre'];
		$this->email			= $respuesta[0]['email'];
		$this->clave			= $respuesta[0]['clave'];
		$this->perfil			= $respuesta[0]['perfil'];
		$this->estadoRegistro	= $respuesta[0]['estadoRegistro'];

	}// traerUsuario


	public function guardarUsuario(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE usuarios SET
					nombre			= :nombre,
					email  			= :email,
					clave			= :clave,
					perfil			= :perfil,
					estadoRegistro	= :estado,
					fechaEdicion	= :fechaEdicion,
					historial 		= ''
				WHERE idUsuario     = :idUsuario;
			";


		$arrayUsuario = array(
			"nombre"		=>	$this->nombre,
			"email" 		=>  $this->email,
			"clave"			=>	$this->clave,				
			"perfil"		=>	$this->perfil,
			"estado"		=>	$this->estadoRegistro,
			"fechaEdicion"	=>  $fecha,
			"idUsuario" 	=>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayUsuario);
		if($respuesta == 1){
			$retorno = "Se guardo el usuario correctamente";
		}else{
			$retorno = "Error al guardar el usuario";
		}
		return $retorno;

	}//guardarUsuario


	public function listarUsuarios($filtos = array()){
		
		//$varSQL = 'SELECT * FROM autores';

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

		$varSQL = "SELECT * FROM usuarios ".$buscador."  ORDER BY nombre LIMIT ".$puntoSalida.",".$limite."";

		$retorno = $this->traerListado($varSQL, array());
		return $retorno;

	}//listarUsuarios
	
	public function totalUsuarios($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE nombre LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM usuarios '.$buscador.'';
		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}//totalUsuarios

	public function listarPerfiles(){
		
		//enum('Administrador','Supervisor','Vendedor')
		
		$retorno = ["Administrador"=>"Admistrador","Supervisor"=>"Supervisor","Vendedor"=>"Vendedor"];

		return $retorno;

	}//totalUsuarios

	public function login($email, $clave){
		
		//enum('Administrador','Supervisor','Vendedor')
		$retorno = "";
		$claMD5 = md5($clave);	

		$varSQL 	= 'SELECT * FROM usuarios WHERE email = :email AND clave = :clave ;';
		$arrayUsu 	= array('email' => $email, 'clave' => $claMD5);

		
		$respuesta = $this->traerListado($varSQL, $arrayUsu);

		if(empty($respuesta)){
			/*
				En caso que tenga registro entro aca y devuelvo que ya ese usuario esta ingresado
			*/
			return "Error en las credenciales";
		}

		return $respuesta;

	}//totalUsuarios



}





?>