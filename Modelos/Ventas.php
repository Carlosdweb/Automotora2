<?php

require_once("Generico.php");

class ventas extends generico{

	/*
		Esta clase maneja a las ventas en el sistema.
	*/

	// Nombre del usuario
	public $idCliente;
	// Es el Email con el que se loguea el usuario
	public $idAuto;

    public $precio;

	public $fechainicio;

	public $fechaFinal;

    public $estadoEntrega;


	public function constructor($arrayDatos = array()){

		parent::constructor($arrayDatos);
		$this->idCliente 	  = $this->chequeadorConstructor($arrayDatos, 'idCliente', ''); 
		$this->idAuto	      = $this->chequeadorConstructor($arrayDatos, 'idAuto', ''); 
        $this->precio	      = $this->chequeadorConstructor($arrayDatos, 'precio', ''); 
		$this->fechainicio    = $this->chequeadorConstructor($arrayDatos, 'fechainicio', ''); 
		$this->fechaFinal	  = $this->chequeadorConstructor($arrayDatos, 'fechaFinal', '');
        $this->estadoEntrega  = $this->chequeadorConstructor($arrayDatos, 'estadoEntrega', '');
		$this->estadoRegistro = $this->chequeadorConstructor($arrayDatos, 'estado', 'Ingresado'); 
	}

	public function ingresarVenta(){
		
	
		try{

			$varSQL = 'SELECT * FROM ventas WHERE idCliente = :idCliente AND idAuto = :idAuto;';		
			$arrayVentas = array('idCliente' => $this->idCliente, 'idAuto' => $this->idAuto );
			$respuesta = $this->traerListado($varSQL, $arrayVentas);

			if(!empty($respuesta)){
				/*
					En caso que tenga registro entro aca y devuelvo que ya la venta esta ingresada
				*/
				return "Ya esta ingresada la venta";
			}

			$fecha = date("Y-m-d h:i:s");
			$sql = "INSERT INTO ventas SET
						idCliente		= :idCliente,
						idAuto  		= :idAuto,
						precio			= :precio,
						fechainicio		= :fechainicio,
                        fechaFinal      = :fechaFinal,
                        estadoEntrega   = :estadoEntrega,
						estadoRegistro	= :estadoRegistro,
						fechaEdicion	= :fechaEdicion,
						historial 		= '';
				";

		
			$arrayVentas = array(
				"idCliente"			=>	$this->idCliente,
				"idAuto" 			=>  $this->idAuto,
				"precio"			=>	$this->precio,				
				"fechainicio"		=>	$this->fechainicio,
                "fechaFinal"		=>	$this->fechaFinal,
                "estadoEntrega"		=>	$this->estadoEntrega,
				"estadoRegistro"	=>	$this->estadoRegistro,
				"fechaEdicion"		=>  $fecha,
			);	

			$respuesta = $this->ejecutarSentencia($sql, $arrayVentas);

			if($respuesta == 1){
				$retorno = "Se ingreso la venta correctamente";
			}else{
				$retorno = "Error al ingresar la venta";
			}
			return $retorno;

		}catch(PDOException $e){
			$retorno = "Ocurrio Un error al ingresar la venta";
			return $retorno;
		}

       	}// ingresarVenta

	public function traerVenta($idRegistro){
		
		$varSQL 	= 'SELECT * FROM ventas WHERE idVenta = :idVenta;';
		$arrayVentas = array('idVenta' => $idRegistro);

		$respuesta = $this->traerListado($varSQL, $arrayVentas);

		$this->idRegistro 		= $respuesta[0]['idVenta'];
		$this->idCliente		= $respuesta[0]['idCliente'];
		$this->idAuto			= $respuesta[0]['idAuto'];
		$this->precio			= $respuesta[0]['precio'];
		$this->fechainicio		= $respuesta[0]['fechainicio'];
        $this->fechaFinal		= $respuesta[0]['fechaFinal'];
        $this->estadoEntrega	= $respuesta[0]['estadoEntrega'];
		$this->estadoRegistro	= $respuesta[0]['estadoRegistro'];

	}// traerVentas


	public function guardarVentas(){
		
		
		$fecha = date("Y-m-d h:i:s");

		$sql = "UPDATE ventas SET
				idCliente		= :idCliente,
				idAuto  		= :idAuto,
				precio			= :precio,
				fechainicio		= :fechainicio,
                fechaFinal      = :fechaFinal,
                estadoEntrega   = :estadoEntrega,
				estadoRegistro	= :estado,
				fechaEdicion	= :fechaEdicion,
				historial 		= ''
				WHERE idVenta     = :idVenta;
			";


		$arrayVentas = array(
			"idCliente"		=>	$this->idCliente,
			"idAuto"		=>	$this->idAuto,				
			"precio"		=>	$this->precio,
            "fechainicio"	=>	$this->fechainicio,
            "fechaFinal"	=>	$this->fechaFinal,
            "estadoEntrega"	=>	$this->estadoEntrega,
			"estado"		=>	$this->estadoRegistro,
			"fechaEdicion"	=>  $fecha,
			"idVenta"   	=>  $this->idRegistro,
		);	

		$respuesta = $this->ejecutarSentencia($sql, $arrayVentas);
		if($respuesta == 1){
			$retorno = "Se guardo la venta correctamente";
		}else{
			$retorno = "Error al guardar la venta";
		}
		return $retorno;

	}//guardarVentas


	public function listarVentas($filtos = array()){
		
		

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
		//      SELECT * FROM ventas LIMIT 0,10; 
		$puntoSalida = $pagina * $limite;

		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE idVenta LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = "SELECT * FROM ventas ".$buscador."  ORDER BY idVenta LIMIT ".$puntoSalida.",".$limite."";

		$retorno = $this->traerListado($varSQL, array());
		return $retorno;

	}//listarVentas
	
	public function totalVentas($filtos = array()){
		
		$buscador = "";
		if(isset($filtos['buscar']) && $filtos['buscar'] != "" ){
		
			$buscador = ' WHERE idVenta LIKE "%'.$filtos['buscar'].'%" ';
		
		}

		$varSQL = 'SELECT count(1) AS totalRegistros FROM ventas '.$buscador.'';
		$respuesta = $this->traerListado($varSQL, array());
		$retorno = $respuesta[0]['totalRegistros'];

		return $retorno;

	}//totalVentas

	public function listarEstadoEntrega(){
		
		//enum('Ingresado',Entregado')
		
		$retorno = ["Ingresado"=>"Ingresado","Entregado"=>"Entregado"];

		return $retorno;

	}//listarEstadoEntrega

	}//totalVentas

?>