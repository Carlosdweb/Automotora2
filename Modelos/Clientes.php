<?php

require_once("generico.php");

class clientes extends generico{


    // Nombre del cliente
	public $nombre;

    public $apellidos;

    public $documento;
    // fecha de nacimiento en formato YYYY-mm-dd
    public $fechaNacimiento;

    public $telefono;
	// Es el Email con el que se loguea el cliente
	public $email;

	public $clave;


	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->nombre			= $this->chequeadorConstructor($arrayDatos, 'nombre', ''); 
		$this->apellidos		= $this->chequeadorConstructor($arrayDatos, 'apellidos', ''); 
		$this->documento		= $this->chequeadorConstructor($arrayDatos, 'documento', ''); 
		$this->fechaNacimiento	= $this->chequeadorConstructor($arrayDatos, 'fechaNacimiento', ''); 
		$this->telefono		    = $this->chequeadorConstructor($arrayDatos, 'telefono', ''); 
		$this->email 			= $this->chequeadorConstructor($arrayDatos, 'email', ''); 
		$this->clave			= $this->chequeadorConstructor($arrayDatos, 'clave', ''); 
		$this->estadoRegistro 	= $this->chequeadorConstructor($arrayDatos, 'estado', 'Ingresado'); 
	}

	public function ingresarClientes(){
		/*
			Primero evaluo si el autor esta ingresado
			1) chequeo que exista el cliente con documento y Email
		*/
		try{

			$varSQL = 'SELECT * FROM clientes WHERE documento = :documento OR email = :email;';		
			$arrayClientes = array('documento' => $this->documento, 'email' => $this->email );
			$respuesta = $this->traerListado($varSQL, $arrayClientes);

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
				*/
				return "Ya esta ingresado el cliente o el mail";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO clientes SET
						nombre			= :nombre,
						apellidos		= :apellidos,
						documento		= :documento,
						fechaNacimiento	= :fechaNacimiento,
                        telefono    	= :telefono,
						email			= :email,
						clave			= :clave,						
						estadoRegistro	= :estadoRegistro,
						fechaEdicion	= :fechaEdicion,
						historial 		= '';
				";

			$clave = md5($this->clave);	

			$arrayClientes = array(
				"nombre"			=>	$this->nombre,
				"apellidos" 		=>  $this->apellidos,
				"documento" 		=>  $this->documento,
				"fechaNacimiento" 	=>  $this->fechaNacimiento,
                "telefono"      	=>  $this->telefono,
				"email" 			=>  $this->email,
				"clave"				=>	$clave,		
				"estadoRegistro"	=>	$this->estadoRegistro,
				"fechaEdicion"		=>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayClientes);

			if($respuesta == 1){
				$retorno = "Se ingreso el clientes correctamente";
			}else{
				$retorno = "Error al ingresar el clientes";
			}
			return $retorno;

		}catch(PDOException $e){
			$retorno = "Ocurrio Un error al ingresar clientes";
			return $retorno;
		}

	}// ingresarClientes

	public function traerClientes($idRegistro){
		
		$varSQL 		= 'SELECT * FROM clientes WHERE idCliente = :idCliente;';
		$arrayClientes	= array('idCliente' => $idRegistro);

		$respuesta = $this->traerListado($varSQL, $arrayClientes);

		$this->idRegistro 		= $respuesta[0]['idClinete'];
		$this->nombre			= $respuesta[0]['nombre'];
		$this->apellidos		= $respuesta[0]['apellidos'];
		$this->documento		= $respuesta[0]['documento'];
		$this->fechaNacimiento	= $respuesta[0]['fechaNacimiento'];
        $this->telefono     	= $respuesta[0]['telefono'];
		$this->email			= $respuesta[0]['email'];
		$this->clave			= $respuesta[0]['clave'];
		$this->estadoRegistro	= $respuesta[0]['estadoRegistro'];

	}// traerClientes


	public function guardarClientes(){
				
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE cliente SET
					nombre			= :nombre,
					apellidos  		= :apellidos,
					documento		= :documento,
					fechaNacimiento	= :fechaNacimiento,
                    telefono    	= :telefono,
					email			= :email,
					clave			= :clave,
					estadoRegistro	= :estado,
					fechaEdicion	= :fechaEdicion,
					historial 		= ''
				WHERE idCliente = :idCliente;
			";

		$arrayClientes = array(
			"nombre"		=>	$this->nombre,
			"apellidos" 	=>  $this->apellidos,
			"documento"		=>	$this->documento,				
			"fechaNacimiento"=>	$this->fechaNacimiento,
            "telefono"      =>	$this->fechaNacimiento,
			"email"			=>	$this->email,
			"clave"			=>	$this->clave,
			"estado"		=>	$this->estadoRegistro,
			"fechaEdicion"	=>  $fecha,
			"idCliente" 	=>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayClientes);
		if($respuesta == 1){
			$retorno = "Se guardo el cliente correctamente";
		}else{
			$retorno = "Error al guardar el Cliente";
		}
		return $retorno;

	}//guardarClientes


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
		//      SELECT * FROM autores LIMIT 0,10; 
		$puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE nombre LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM clientes ".$buscador."  ORDER BY idCliente LIMIT ".$puntoSalida.",".$limite."";
		$retorno = $this->traerListado($varSQL, array());
		return $retorno;

	}//listarClientes
	
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
		$arrayClie 	= array('email' => $email, 'clave' => $claMD5);

		
		$respuesta = $this->traerListado($varSQL, $arrayClie);

		if(empty($respuesta)){
			/*
				En caso que tenga registro entro aca y devuelvo que ya ese cliente esta ingresado
			*/
			return "Error en las credenciales";
		}

		return $respuesta;

	}//totalClientes



}





?>