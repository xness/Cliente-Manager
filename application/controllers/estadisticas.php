<?php 

class Estadisticas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("model_usuario");
		$this->load->model("model_empresa");
		$this->load->model("model_tipo_incidencia");
	}
	
	public function index()
	{
		if ( $this->session->userdata("is_logged_in") ) {
			$data = $this->getHeaderData();
			$this->load->view("header", $data);
			$dataIncidencias["empresas"] = $this->model_empresa->getEmpresas();
			$dataIncidencias["tipoIncidencias"] = $this->model_tipo_incidencia->getAll();
			
			if ( $this->input->post("filtroEmpresa") )
			{
				$idEmpresa = $this->input->post("filtroEmpresa");
			} else {
				$idEmpresa = 1;
			}
			
			$dataIncidencias['data1'] = $this->estadisticasFechaIngresoRespuesta($idEmpresa);
			$dataIncidencias['data2'] = $this->estadisticasFechaIngresoProceso($idEmpresa);
			$dataIncidencias['data3'] = $this->estadisticasFechaProcesoRespuesta($idEmpresa);
			
			$this->load->view("estadisticas/index",$dataIncidencias);
			$this->load->view("footer");
		} else {
			redirect('inicio/restricted');
		}
	}
	
	function estadisticasFechaIngresoRespuesta($idEmpresa)
	{
		/* TIPO 1 */
		$fechasTipo1 = $this->model_tipo_incidencia->getPromedioTipoIncidencia(1,$idEmpresa);
		if ( !empty($fechasTipo1) ) {
			$cSinResponder1 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(1,$idEmpresa);
			$suma1 = 0;
			$min1 = (strtotime($fechasTipo1[0]->fechaRespuesta) - strtotime($fechasTipo1[0]->fechaIncidencia));
			$max1 = (strtotime($fechasTipo1[0]->fechaRespuesta) - strtotime($fechasTipo1[0]->fechaIncidencia));
			$i = 1;
			foreach ( $fechasTipo1 as $fechaTipo1 )
			{
				$i++;
				$diff = strtotime($fechaTipo1->fechaRespuesta) - strtotime($fechaTipo1->fechaIncidencia);
				$m = $diff / 60;
					
				// Calcular el minimo
				if ( $diff < $min1 )
				{
					$min1 = $diff;
				}
					
				if ( $diff > $max1 )
				{
					$max1 = $diff;
				}
					
				// Sumar para sacar el promedio
				$suma1 = $suma1 + $diff/3600;
			}
		
			$minimo1 = $this->getFormatDate($min1);
			$maximo1 = $this->getFormatDate($max1);
		
			$prom1 = $this->calcularPromedio(round($suma1/$i,2));
		
			$dataIncidencias["promedio1"] = $prom1;
			$dataIncidencias["minimo1"]   = $minimo1;
			$dataIncidencias["maximo1"]   = $maximo1;
			$dataIncidencias["sinResponder1"] = $cSinResponder1[0]->cantidad;
		} else {
			$dataIncidencias["promedio1"] = "0:0";
			$dataIncidencias["minimo1"]   = "0:0";
			$dataIncidencias["maximo1"]   = "0:0";
		}
		/* !TIPO 1 */
		 	
		/* TIPO 2 */
		$fechasTipo2 = $this->model_tipo_incidencia->getPromedioTipoIncidencia(2,$idEmpresa);
		if ( !empty($fechasTipo2) ) {
			$cSinResponder2 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(2,$idEmpresa);
			$suma2 = 0;
			$min2 = (strtotime($fechasTipo2[0]->fechaRespuesta) - strtotime($fechasTipo2[0]->fechaIncidencia));
			$max2 = (strtotime($fechasTipo2[0]->fechaRespuesta) - strtotime($fechasTipo2[0]->fechaIncidencia));
			$i2 = 1;
			foreach ( $fechasTipo2 as $fechaTipo2 )
			{
				$i2++;
				$diff = strtotime($fechaTipo2->fechaRespuesta) - strtotime($fechaTipo2->fechaIncidencia);
				$m = $diff / 60 % 60;
		
				// Calcular el minimo
				if ( $diff < $min2 )
				{
					$min2 = $diff;
				}
		
				if ( $diff > $max2 )
				{
					$max2 = $diff;
				}
		
				// Sumar para sacar el promedio
				$suma2 = $suma2 + $diff/3600;
			}
				
			$minimo2 = $this->getFormatDate($min2);
			$maximo2 = $this->getFormatDate($max2);
		
			$prom2 = $this->calcularPromedio(round($suma2/$i2,2));
				
			$dataIncidencias["promedio2"] = $prom2;
			$dataIncidencias["minimo2"]   = $minimo2;
			$dataIncidencias["maximo2"]   = $maximo2;
			$dataIncidencias["sinResponder2"] = $cSinResponder2[0]->cantidad;
		} else {
			$dataIncidencias["promedio2"] = "0:0";
			$dataIncidencias["minimo2"]   = "0:0";
			$dataIncidencias["maximo2"]   = "0:0";
		}
		/* !TIPO 2 */
		 	
		/* TIPO 3 */
		$fechasTipo3 = $this->model_tipo_incidencia->getPromedioTipoIncidencia(3,$idEmpresa);
		$cSinResponder3 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(3,$idEmpresa);
		if ( !empty($fechasTipo3) ) {
			$suma3 = 0;
			$min3 = (strtotime($fechasTipo3[0]->fechaRespuesta) - strtotime($fechasTipo3[0]->fechaIncidencia));
			$max3 = (strtotime($fechasTipo3[0]->fechaRespuesta) - strtotime($fechasTipo3[0]->fechaIncidencia));
			$i3=1;
			foreach ( $fechasTipo3 as $fechaTipo3 )
			{
				$i3++;
				$diff = strtotime($fechaTipo3->fechaRespuesta) - strtotime($fechaTipo3->fechaIncidencia);
				$m = $diff / 60 % 60;
		
				// Calcular el minimo
				if ( $diff < $min3 )
				{
					$min3 = $diff;
				}
		
				if ( $diff > $max3 )
				{
					$max3 = $diff;
				}
		
				// Sumar para sacar el promedio
				$suma3 = $suma3 + $diff/3600;
			}
		
			$minimo3 = $this->getFormatDate($min3);
			$maximo3 = $this->getFormatDate($max3);
		
			$prom3 = $this->calcularPromedio(round($suma3/$i3,2));
		
			$dataIncidencias["promedio3"] = $prom3;
			$dataIncidencias["minimo3"]   = $minimo3;
			$dataIncidencias["maximo3"]   = $maximo3;
		} else {
			$dataIncidencias["promedio3"] = "0:0";
			$dataIncidencias["minimo3"]   = "0:0";
			$dataIncidencias["maximo3"]   = "0:0";
		}
		$dataIncidencias["sinResponder3"] = $cSinResponder3[0]->cantidad;
		/* !TIPO 3 */
		/* TIPO 4 */
		$fechasTipo4 = $this->model_tipo_incidencia->getPromedioTipoIncidencia(4,$idEmpresa);
		$cSinResponder4 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(4,$idEmpresa);
		$i4=1;
		if ( !empty($fechasTipo4) ) {
			$suma4 = 0;
			$min4 = (strtotime($fechasTipo4[0]->fechaRespuesta) - strtotime($fechasTipo4[0]->fechaIncidencia));
			$max4 = (strtotime($fechasTipo4[0]->fechaRespuesta) - strtotime($fechasTipo4[0]->fechaIncidencia));
			foreach ( $fechasTipo4 as $fechaTipo4 )
			{
				$i4++;
				$diff = strtotime($fechaTipo4->fechaRespuesta) - strtotime($fechaTipo4->fechaIncidencia);
				$m = $diff / 60 % 60;
					
				// Calcular el minimo
				if ( $diff < $min4 )
				{
					$min4 = $diff;
				}
					
				if ( $diff > $max4 )
				{
					$max4 = $diff;
				}
					
				// Sumar para sacar el promedio
				$suma4 = $suma4 + $diff/3600;
			}
				
			$minimo4 = $this->getFormatDate($min4);
			$maximo4 = $this->getFormatDate($max4);
				
			$prom4 = $this->calcularPromedio(round($suma4/$i4,2));
				
			$dataIncidencias["promedio4"] = $prom4;
			$dataIncidencias["minimo4"]   = $minimo4;
			$dataIncidencias["maximo4"]   = $maximo4;
		} else {
			$dataIncidencias["promedio4"] = "0:0";
			$dataIncidencias["minimo4"]   = "0:0";
			$dataIncidencias["maximo4"]   = "0:0";
		}
		$dataIncidencias["sinResponder4"] = $cSinResponder4[0]->cantidad;
		/* !TIPO 4 */
		
		return $dataIncidencias;
	}
	
	function estadisticasFechaIngresoProceso($idEmpresa)
	{
		/* TIPO 1 */
		$fechasTipo1 = $this->model_tipo_incidencia->getPromedioTipoIncidencia2(1,$idEmpresa);
		if ( !empty($fechasTipo1) ) {
			$cSinResponder1 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(1,$idEmpresa);
			$suma1 = 0;
			$min1 = (strtotime($fechasTipo1[0]->fechaProceso) - strtotime($fechasTipo1[0]->fechaIncidencia));
			$max1 = (strtotime($fechasTipo1[0]->fechaProceso) - strtotime($fechasTipo1[0]->fechaIncidencia));
			$i = 1;
			foreach ( $fechasTipo1 as $fechaTipo1 )
			{
				$i++;
				$diff = strtotime($fechaTipo1->fechaProceso) - strtotime($fechaTipo1->fechaIncidencia);
				$m = $diff / 60;
					
				// Calcular el minimo
				if ( $diff < $min1 )
				{
					$min1 = $diff;
				}
					
				if ( $diff > $max1 )
				{
					$max1 = $diff;
				}
					
				// Sumar para sacar el promedio
				$suma1 = $suma1 + $diff/3600;
			}
	
			$minimo1 = $this->getFormatDate($min1);
			$maximo1 = $this->getFormatDate($max1);
	
			$prom1 = $this->calcularPromedio(round($suma1/$i,2));
	
			$dataIncidencias["promedio1"] = $prom1;
			$dataIncidencias["minimo1"]   = $minimo1;
			$dataIncidencias["maximo1"]   = $maximo1;
			$dataIncidencias["sinResponder1"] = $cSinResponder1[0]->cantidad;
		} else {
			$dataIncidencias["promedio1"] = "0:0";
			$dataIncidencias["minimo1"]   = "0:0";
			$dataIncidencias["maximo1"]   = "0:0";
		}
		/* !TIPO 1 */
	
		/* TIPO 2 */
		$fechasTipo2 = $this->model_tipo_incidencia->getPromedioTipoIncidencia2(2,$idEmpresa);
		if ( !empty($fechasTipo2) ) {
			$cSinResponder2 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(2,$idEmpresa);
			$suma2 = 0;
			$min2 = (strtotime($fechasTipo2[0]->fechaProceso) - strtotime($fechasTipo2[0]->fechaIncidencia));
			$max2 = (strtotime($fechasTipo2[0]->fechaProceso) - strtotime($fechasTipo2[0]->fechaIncidencia));
			$i2 = 1;
			foreach ( $fechasTipo2 as $fechaTipo2 )
			{
				$i2++;
				$diff = strtotime($fechaTipo2->fechaProceso) - strtotime($fechaTipo2->fechaIncidencia);
				$m = $diff / 60 % 60;
	
				// Calcular el minimo
				if ( $diff < $min2 )
				{
					$min2 = $diff;
				}
	
				if ( $diff > $max2 )
				{
					$max2 = $diff;
				}
	
				// Sumar para sacar el promedio
				$suma2 = $suma2 + $diff/3600;
			}
	
			$minimo2 = $this->getFormatDate($min2);
			$maximo2 = $this->getFormatDate($max2);
	
			$prom2 = $this->calcularPromedio(round($suma2/$i2,2));
	
			$dataIncidencias["promedio2"] = $prom2;
			$dataIncidencias["minimo2"]   = $minimo2;
			$dataIncidencias["maximo2"]   = $maximo2;
			$dataIncidencias["sinResponder2"] = $cSinResponder2[0]->cantidad;
		} else {
			$dataIncidencias["promedio2"] = "0:0";
			$dataIncidencias["minimo2"]   = "0:0";
			$dataIncidencias["maximo2"]   = "0:0";
		}
		/* !TIPO 2 */
	
		/* TIPO 3 */
		$fechasTipo3 = $this->model_tipo_incidencia->getPromedioTipoIncidencia2(3,$idEmpresa);
		$cSinResponder3 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(3,$idEmpresa);
		if ( !empty($fechasTipo3) ) {
			$suma3 = 0;
			$min3 = (strtotime($fechasTipo3[0]->fechaProceso) - strtotime($fechasTipo3[0]->fechaIncidencia));
			$max3 = (strtotime($fechasTipo3[0]->fechaProceso) - strtotime($fechasTipo3[0]->fechaIncidencia));
			$i3=1;
			foreach ( $fechasTipo3 as $fechaTipo3 )
			{
				$i3++;
				$diff = strtotime($fechaTipo3->fechaProceso) - strtotime($fechaTipo3->fechaIncidencia);
				$m = $diff / 60 % 60;
	
				// Calcular el minimo
				if ( $diff < $min3 )
				{
					$min3 = $diff;
				}
	
				if ( $diff > $max3 )
				{
					$max3 = $diff;
				}
	
				// Sumar para sacar el promedio
				$suma3 = $suma3 + $diff/3600;
			}
	
			$minimo3 = $this->getFormatDate($min3);
			$maximo3 = $this->getFormatDate($max3);
	
			$prom3 = $this->calcularPromedio(round($suma3/$i3,2));
	
			$dataIncidencias["promedio3"] = $prom3;
			$dataIncidencias["minimo3"]   = $minimo3;
			$dataIncidencias["maximo3"]   = $maximo3;
		} else {
			$dataIncidencias["promedio3"] = "0:0";
			$dataIncidencias["minimo3"]   = "0:0";
			$dataIncidencias["maximo3"]   = "0:0";
		}
		$dataIncidencias["sinResponder3"] = $cSinResponder3[0]->cantidad;
		/* !TIPO 3 */
		/* TIPO 4 */
		$fechasTipo4 = $this->model_tipo_incidencia->getPromedioTipoIncidencia2(4,$idEmpresa);
		$cSinResponder4 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(4,$idEmpresa);
		$i4=1;
		if ( !empty($fechasTipo4) ) {
			$suma4 = 0;
			$min4 = (strtotime($fechasTipo4[0]->fechaProceso) - strtotime($fechasTipo4[0]->fechaIncidencia));
			$max4 = (strtotime($fechasTipo4[0]->fechaProceso) - strtotime($fechasTipo4[0]->fechaIncidencia));
			foreach ( $fechasTipo4 as $fechaTipo4 )
			{
				$i4++;
				$diff = strtotime($fechaTipo4->fechaProceso) - strtotime($fechaTipo4->fechaIncidencia);
				$m = $diff / 60 % 60;
					
				// Calcular el minimo
				if ( $diff < $min4 )
				{
					$min4 = $diff;
				}
					
				if ( $diff > $max4 )
				{
					$max4 = $diff;
				}
					
				// Sumar para sacar el promedio
				$suma4 = $suma4 + $diff/3600;
			}
	
			$minimo4 = $this->getFormatDate($min4);
			$maximo4 = $this->getFormatDate($max4);
	
			$prom4 = $this->calcularPromedio(round($suma4/$i4,2));
	
			$dataIncidencias["promedio4"] = $prom4;
			$dataIncidencias["minimo4"]   = $minimo4;
			$dataIncidencias["maximo4"]   = $maximo4;
		} else {
			$dataIncidencias["promedio4"] = "0:0";
			$dataIncidencias["minimo4"]   = "0:0";
			$dataIncidencias["maximo4"]   = "0:0";
		}
		$dataIncidencias["sinResponder4"] = $cSinResponder4[0]->cantidad;
		/* !TIPO 4 */
	
		return $dataIncidencias;
	}
	
	function estadisticasFechaProcesoRespuesta($idEmpresa)
	{
		/* TIPO 1 */
		$fechasTipo1 = $this->model_tipo_incidencia->getPromedioTipoIncidencia3(1,$idEmpresa);
		$cSinResponder1 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(1,$idEmpresa);
		if ( !empty($fechasTipo1) ) {
			$suma1 = 0;
			$min1 = (strtotime($fechasTipo1[0]->fechaRespuesta) - strtotime($fechasTipo1[0]->fechaProceso));
			$max1 = (strtotime($fechasTipo1[0]->fechaRespuesta) - strtotime($fechasTipo1[0]->fechaProceso));
			$i = 1;
			foreach ( $fechasTipo1 as $fechaTipo1 )
			{
				$i++;
				$diff = strtotime($fechaTipo1->fechaRespuesta) - strtotime($fechaTipo1->fechaProceso);
				$m = $diff / 60;
					
				// Calcular el minimo
				if ( $diff < $min1 )
				{
					$min1 = $diff;
				}
					
				if ( $diff > $max1 )
				{
					$max1 = $diff;
				}
					
				// Sumar para sacar el promedio
				$suma1 = $suma1 + $diff/3600;
			}
	
			$minimo1 = $this->getFormatDate($min1);
			$maximo1 = $this->getFormatDate($max1);
	
			$prom1 = $this->calcularPromedio(round($suma1/$i,2));
	
			$dataIncidencias["promedio1"] = $prom1;
			$dataIncidencias["minimo1"]   = $minimo1;
			$dataIncidencias["maximo1"]   = $maximo1;
		} else {
			$dataIncidencias["promedio1"] = "0:0";
			$dataIncidencias["minimo1"]   = "0:0";
			$dataIncidencias["maximo1"]   = "0:0";
		}
		$dataIncidencias["sinResponder1"] = $cSinResponder1[0]->cantidad;
		/* !TIPO 1 */
	
		/* TIPO 2 */
		$fechasTipo2 = $this->model_tipo_incidencia->getPromedioTipoIncidencia3(2,$idEmpresa);
		$cSinResponder2 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(2,$idEmpresa);
		if ( !empty($fechasTipo2) ) {
			$suma2 = 0;
			$min2 = (strtotime($fechasTipo2[0]->fechaRespuesta) - strtotime($fechasTipo2[0]->fechaProceso));
			$max2 = (strtotime($fechasTipo2[0]->fechaRespuesta) - strtotime($fechasTipo2[0]->fechaProceso));
			$i2 = 1;
			foreach ( $fechasTipo2 as $fechaTipo2 )
			{
				$i2++;
				$diff = strtotime($fechaTipo2->fechaRespuesta) - strtotime($fechaTipo2->fechaProceso);
				$m = $diff / 60 % 60;
	
				// Calcular el minimo
				if ( $diff < $min2 )
				{
					$min2 = $diff;
				}
	
				if ( $diff > $max2 )
				{
					$max2 = $diff;
				}
	
				// Sumar para sacar el promedio
				$suma2 = $suma2 + $diff/3600;
			}
	
			$minimo2 = $this->getFormatDate($min2);
			$maximo2 = $this->getFormatDate($max2);
	
			$prom2 = $this->calcularPromedio(round($suma2/$i2,2));
	
			$dataIncidencias["promedio2"] = $prom2;
			$dataIncidencias["minimo2"]   = $minimo2;
			$dataIncidencias["maximo2"]   = $maximo2;
		} else {
			$dataIncidencias["promedio2"] = "0:0";
			$dataIncidencias["minimo2"]   = "0:0";
			$dataIncidencias["maximo2"]   = "0:0";
		}
		$dataIncidencias["sinResponder2"] = $cSinResponder2[0]->cantidad;
		/* !TIPO 2 */
	
		/* TIPO 3 */
		$fechasTipo3 = $this->model_tipo_incidencia->getPromedioTipoIncidencia3(3,$idEmpresa);
		$cSinResponder3 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(3,$idEmpresa);
		if ( !empty($fechasTipo3) ) {
			$suma3 = 0;
			$min3 = (strtotime($fechasTipo3[0]->fechaRespuesta) - strtotime($fechasTipo3[0]->fechaProceso));
			$max3 = (strtotime($fechasTipo3[0]->fechaRespuesta) - strtotime($fechasTipo3[0]->fechaProceso));
			$i3=1;
			foreach ( $fechasTipo3 as $fechaTipo3 )
			{
				$i3++;
				$diff = strtotime($fechaTipo3->fechaRespuesta) - strtotime($fechaTipo3->fechaProceso);
				$m = $diff / 60 % 60;
	
				// Calcular el minimo
				if ( $diff < $min3 )
				{
					$min3 = $diff;
				}
	
				if ( $diff > $max3 )
				{
					$max3 = $diff;
				}
	
				// Sumar para sacar el promedio
				$suma3 = $suma3 + $diff/3600;
			}
	
			$minimo3 = $this->getFormatDate($min3);
			$maximo3 = $this->getFormatDate($max3);
	
			$prom3 = $this->calcularPromedio(round($suma3/$i3,2));
	
			$dataIncidencias["promedio3"] = $prom3;
			$dataIncidencias["minimo3"]   = $minimo3;
			$dataIncidencias["maximo3"]   = $maximo3;
		} else {
			$dataIncidencias["promedio3"] = "0:0";
			$dataIncidencias["minimo3"]   = "0:0";
			$dataIncidencias["maximo3"]   = "0:0";
		}
		$dataIncidencias["sinResponder3"] = $cSinResponder3[0]->cantidad;
		/* !TIPO 3 */
		/* TIPO 4 */
		$fechasTipo4 = $this->model_tipo_incidencia->getPromedioTipoIncidencia3(4,$idEmpresa);
		$cSinResponder4 = $this->model_tipo_incidencia->getCountIncidenciasSinResponder(4,$idEmpresa);
		$i4=1;
		if ( !empty($fechasTipo4) ) {
			$suma4 = 0;
			$min4 = (strtotime($fechasTipo4[0]->fechaRespuesta) - strtotime($fechasTipo4[0]->fechaProceso));
			$max4 = (strtotime($fechasTipo4[0]->fechaRespuesta) - strtotime($fechasTipo4[0]->fechaProceso));
			foreach ( $fechasTipo4 as $fechaTipo4 )
			{
				$i4++;
				$diff = strtotime($fechaTipo4->fechaRespuesta) - strtotime($fechaTipo4->fechaProceso);
				$m = $diff / 60 % 60;
					
				// Calcular el minimo
				if ( $diff < $min4 )
				{
					$min4 = $diff;
				}
					
				if ( $diff > $max4 )
				{
					$max4 = $diff;
				}
					
				// Sumar para sacar el promedio
				$suma4 = $suma4 + $diff/3600;
			}
	
			$minimo4 = $this->getFormatDate($min4);
			$maximo4 = $this->getFormatDate($max4);
	
			$prom4 = $this->calcularPromedio(round($suma4/$i4,2));
	
			$dataIncidencias["promedio4"] = $prom4;
			$dataIncidencias["minimo4"]   = $minimo4;
			$dataIncidencias["maximo4"]   = $maximo4;
		} else {
			$dataIncidencias["promedio4"] = "0:0";
			$dataIncidencias["minimo4"]   = "0:0";
			$dataIncidencias["maximo4"]   = "0:0";
		}
		$dataIncidencias["sinResponder4"] = $cSinResponder4[0]->cantidad;
		/* !TIPO 4 */
	
		return $dataIncidencias;
	}
	
	
	
	function getFormatDate($n)
	{
		$h = floor($n/3600%24);
		$m = intval($n / 60 % 60);
		$s = intval( $n % 60 );
		return $h . ":" . $m . ":" . $s;
	}
	
	function calcularPromedio($n)
	{
		if ( strpos($n,'.') === false ) {
			$n = $n . '.0';
		} 
			
		$decmal = floatval($n);
		$hours  = intval($decmal);
		$minutesDecimal = (($decmal - $hours) * 60);
		$minutes = intval($minutesDecimal);
		$seconds = intval((($minutesDecimal - $minutes) * 60));
		/*$promedioFecha1 = explode(".",$n);

		if ( floor($promedioFecha1[0]) < 60 )
		{
			$horas = "0";
			$minutos = $promedioFecha1[0];
			$segundos = $promedioFecha1[1] * 60 / 10;
			if ( $segundos > 60 ) $segundos = round($segundos / 10);
		} else {
			$horas = explode(".",$n / 60);
			$horas = $horas[0];//1 hora
			$minutos = explode(".",((($n / 60)-1) * 60));
			$minutos = $minutos[0]; // 18
			$segundos = ceil((((($n / 60)-1) * 60) - $minutos) * 60); //36
		}*/
		
		return $hours . ":" . $minutes . ":" . $seconds;
	}
	
	function getHeaderData()
	{
		$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
	
		$data = array(
				'titulo' => "Estad&iacute;sticas",
				'nombre' => $udata->nombre,
				'email'  => $udata->email,
				'imagen' => $udata->imagen,
				'rol' => $udata->id_rol,
				'bgstate' => array(
						1 => '#ff0000',
						2 => '#ffff00',
						3 => '#32cd32'
				),
				'color' => array(
						1 => 'red',
						2 => 'yellow',
						3 => 'green'
				)
		);
	
		return $data;
	}
}