<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_tipo_incidencia extends CI_Model
{
	public function __construct()
	{
		parent::__construct();		
	}
	
	function getAll()
	{
		$this->db->select('*');
		$this->db->from('tipo_incidencia');
		$query = $this->db->get();
		
		$row = $query->result();
		
		return $row;
	}
	
	function getPromedioTipoIncidencia($id,$idEmpresa)
	{
		$query = $this->db->query("
				SELECT i.fecha AS fechaIncidencia,r.fecha AS fechaRespuesta 
				FROM `incidencia` AS i 
				INNER JOIN respuesta AS r 
					ON i.id_respuesta = r.id 
				WHERE i.id_tipo_incidencia = $id
				AND i.id_empresa = $idEmpresa
				AND i.id_estado = 3");
		
		$row = $query->result();
		
		return $row;
	}
	
	function getPromedioTipoIncidencia2($id,$idEmpresa)
	{
		$query = $this->db->query("
				SELECT i.fecha AS fechaIncidencia,i.fechaProcesoIncidencia AS fechaProceso
				FROM `incidencia` AS i
				WHERE i.id_tipo_incidencia = $id
				AND i.id_empresa = $idEmpresa
				AND i.id_estado = 3");
	
				$row = $query->result();
	
				return $row;
	}
	
	function getPromedioTipoIncidencia3($id,$idEmpresa)
	{
		$query = $this->db->query("
				SELECT i.fechaProcesoIncidencia AS fechaProceso,r.fecha AS fechaRespuesta
				FROM `incidencia` AS i
				INNER JOIN respuesta AS r
				ON i.id_respuesta = r.id
				WHERE i.id_tipo_incidencia = $id
				AND i.id_empresa = $idEmpresa
				AND i.id_estado = 3");
	
				$row = $query->result();
	
				return $row;
	}
	
	
	function getCountIncidenciasSinResponder($id,$idEmpresa)
	{
		$query = $this->db->query("
				SELECT COUNT(id) as cantidad
				FROM incidencia
				WHERE id_tipo_incidencia = $id
				AND id_empresa = $idEmpresa
				AND id_estado = 1");
		
		$row = $query->result();

		return $row;
	}
}