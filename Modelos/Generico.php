<?php


class generico {

	/*
		public : Marcando que un atributo o metodo es publico significa que puede ser llamdo en cualquier momento y son heredables
		protected : Cuando un atributo o metodo es protected este atributo no puede ser utilizado fuera de la clase y es heredable
		private: Cuando son privado no se peuede unsar fuera de la clase y no son heredables
	*/

	// ES el identificador unico de cada registro 
	protected $idRegistro;
	// Es el estado en que se encuentra el registro 
	protected $estadoRegistro;

	public function constructor($arrayDatos = array()){

		$this->idRegistro = $this->chequeadorConstructor($arrayDatos, 'idRegistro','0'); 
		
		if(isset($arrayDatos['estadoRegistro'])  && strtolower($arrayDatos['estadoRegistro']) == "borrado"){			
			$this->modificarEstadoBorrado();
		}else{
			$this->modificarEstadoIngresado();
		}

	}

	
	public function obtenerIdRegistro(){
		return $this->idRegistro;
	}
	
	public function obtenerEstado(){
		return $this->estadoRegistro;
	}
	
	public function modificarEstadoBorrado(){
		$this->estadoRegistro = "Borrado";
	}

	public function modificarEstadoIngresado(){
		$this->estadoRegistro = "Ingresado";
	}



	protected function chequeadorConstructor($arrayDatos, $nombreCampo, $valorDefecto = ''){
		/*
			Esta funcion verifica si existe en el arrayDatos el valor que estoy buscando.
			En caso que exista se devuelve ese valor en caso de que no devuelve el valorDefecto
		*/
		$retorno = '';
		if(isset($arrayDatos[$nombreCampo])){
			$retorno = $arrayDatos[$nombreCampo];

		}else{
			$retorno = $valorDefecto;
		}
		return $retorno;

	}


	public function traerListado($sqlSentencia, $arrayEjecutar = array()){
		/*
			ESte metodo lo que hace es realizar consulta select contra la base de datos para 
			devolver lista de registros
		*/
		include("Configuracion/Configuracion.php");

		$clave = $ARRAYCONFIGURACION['MySQL']['password'];
		$user = $ARRAYCONFIGURACION['MySQL']['user'];

		$conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbName']."",$user,$clave);

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$mysqlPDO 	= $conexion->prepare($sqlSentencia);
		$respuesta	= $mysqlPDO->execute($arrayEjecutar);

		if($respuesta == 1){
			$lista = $mysqlPDO->fetchAll();
		}else{
			$lista = array();
		}
		return $lista;

	}

	public function ejecutarSentencia($sqlSentencia, $arrayEjecutar = array()){
		/*
			ESte metodo lo que hace es realizar consulta select contra la base de datos para 
			devolver lista de registros
		*/
		include("configuracion/configuracion.php");

		$clave = $ARRAYCONFIGURACION['MySQL']['password'];
		$user = $ARRAYCONFIGURACION['MySQL']['user'];

		$conexion = new PDO("mysql:host=".$ARRAYCONFIGURACION['MySQL']['host'].";dbname=".$ARRAYCONFIGURACION['MySQL']['dbName']."",$user,$clave);

		$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$mysqlPDO 	= $conexion->prepare($sqlSentencia);
		$respuesta	= $mysqlPDO->execute($arrayEjecutar);

		return $respuesta;

	}




}


?>
