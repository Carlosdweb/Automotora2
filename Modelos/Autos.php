<?php

require_once("generico.php");

class autos extends generico{

	/*
		Esta clase maneja los autos en el sistema.
	*/

	// Es la marca del auto
	public $marca;
	// Modelo del auto
	public $modelo;

	public $descripcion;

	public $foto;

    public $pasajeros;
    // es el tipo de auto
    public $tipovehiculo;
    // Es el precio de alquiler del auto
    public $precio;


	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->marca          = $this->chequeadorConstructor($arrayDatos, 'marca', ''); 
		$this->modelo   	  = $this->chequeadorConstructor($arrayDatos, 'modelo', ''); 
		$this->descripcion	  = $this->chequeadorConstructor($arrayDatos, 'descripcion', ''); 
		$this->foto     	  = $this->chequeadorConstructor($arrayDatos, 'foto'); 
        $this->pasajeros	  = $this->chequeadorConstructor($arrayDatos, 'pasajeros'); 
        $this->tipovehiculo	  = $this->chequeadorConstructor($arrayDatos, 'tipovehiculo');
        $this->precio	      = $this->chequeadorConstructor($arrayDatos, 'precio'); 
		$this->estadoRegistro = $this->chequeadorConstructor($arrayDatos, 'estado', 'Ingresado'); 
	}

	public function ingresarAuto(){
		
		/*
			Primero evaluo si el auto esta ingresado
			1) chequeo que exista el auto con la marca y el modelo (countryCode 3)
		*/
		try{

			$varSQL = 'SELECT * FROM autos WHERE marca = :marca AND modelo = :modelo;';		
			$arrayAutos = array('marca' => $this->marca, 'modelo' => $this->modelo );
			$respuesta = $this->traerListado($varSQL, $arrayAutos);

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya ese auto esta ingresado
				*/
				return "Ya esta ingresado el auto";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO auto SET
						marca			= :marca,
						modelo  		= :modelo,
						descripcion		= :descripcion,
						foto			= :foto,
                        pasajeros		= :pasajeros,
                        tipovehiculo	= :tipovehiculo,
                        precio			= :precio,
						estadoRegistro	= :estadoRegistro,
						fechaEdicion	= :fechaEdicion,
						historial 		= '';
				";

			$clave = md5($this->clave);	

			$arrayAutos = array(
				"marca"		    	=>	$this->nombre,
				"modelo" 			=>  $this->email,
				"descripcion"		=>  $this->descripcion,				
				"foto       "		=>  $this->foto,				
				"pasajeros"			=>	$this->pasajeros,
                "tipovehiculo"		=>	$this->tipovehiculo,
                "precio"			=>	$this->precio,
				"estadoRegistro"	=>	$this->estadoRegistro,
				"fechaEdicion"		=>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayAutos);

			if($respuesta == 1){
				$retorno = "Se ingreso el auto correctamente";
			}else{
				$retorno = "Error al ingresar el auto";
			}
			return $retorno;

		}catch(PDOException $e){
			$retorno = "Ocurrio Un error al ingresar el auto";
			return $retorno;
		}

	}// ingresarAuto

	public function traerAutos($idRegistro){
		
		$varSQL 	= 'SELECT * FROM autos WHERE idAuto = :idAuto;';
		$arrayAutos = array('idAuto' => $idRegistro);

		$respuesta = $this->traerListado($varSQL, $arrayAutos);

		$this->idRegistro 		= $respuesta[0]['idAuto'];
		$this->marca			= $respuesta[0]['nombre'];
		$this->modelo			= $respuesta[0]['email'];
		$this->descripcion		= $respuesta[0]['clave'];
		$this->foto			    = $respuesta[0]['perfil'];
        $this->pasajeros	    = $respuesta[0]['pasajeros'];
        $this->tipovehiculo	    = $respuesta[0]['tipovehiculo'];
        $this->precio			= $respuesta[0]['precio'];
		$this->estadoRegistro	= $respuesta[0]['estadoRegistro'];

	}// traerAutos


	public function guardarAuto(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE autos SET
					marca			= :marca,
					modelo  		= :modelo,
					descripcion		= :descripcion,
					foto			= :foto,
                    pasajeros		= :pasajeros,
                    tipovehiculo	= :tipovehiculo,
                    precio			= :precio,
					estadoRegistro	= :estadoRegistro,
					fechaEdicion	= :fechaEdicion,
					historial 		= ''
				WHERE idAuto = :idAuto;
			";


		$arrayGenero = array(
			"nombre"		=>	$this->nombre,
			"email" 		=>  $this->email,
			"clave"			=>	$this->clave,				
			"perfil"		=>	$this->perfil,
			"estado"		=>	$this->estadoRegistro,
			"fechaEdicion"	=>  $fecha,
			"idUsuario" 	=>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayGenero);
		if($respuesta == 1){
			$retorno = "Se guardo el usuario correctamente";
		}else{
			$retorno = "Error al usuario el género";
		}
		return $retorno;

	}//guardarUsuario


	public function listarUsuarios($filtos = array()){
		
		//$varSQL = 'SELECT * FROM autos';

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
				En caso que tenga registro entro aca y devuelvo que ya ese autor esta ingresado
			*/
			return "Error en las credenciales";
		}

		return $respuesta;

	}//totalUsuarios



}





?>