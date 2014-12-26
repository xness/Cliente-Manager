<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_respuesta extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function getRespuestasById($id)
	{
		$this->db->select("*");
		$this->db->from("respuesta");
		$this->db->where("id",$id);
		$query = $this->db->get();
		
		$row = $query->result();
	}
	
	function getRespuestasAprobadas($id, $idTipo, $per_page, $offset)
	{
		$query = $this->db->query("
			SELECT r.descripcion AS descripcionRespuesta,i.titulo AS incidenciaTitulo 
			FROM respuesta AS r 
				LEFT JOIN incidencia AS i ON i.id_respuesta = r.id 
			WHERE i.id_empresa = $id
			AND r.estado = 1 
			LIMIT $offset,$per_page 
		");
		
		$row = $query->result();
		
		return $row;
	}
	
	function getCountRespuestasAprobadas($id, $idTipo)
	{
		$query = $this->db->query("
			SELECT COUNT(r.id) AS cantidad
			FROM respuesta AS r
			LEFT JOIN incidencia AS i ON i.id_respuesta = r.id
			WHERE i.id_empresa = $id
			AND r.estado = 1
		");

		$row = $query->result();

		return $row;
	}
	function insert($data)
	{
		$this->db->trans_start();
		$insert = $this->db->insert('respuesta',$data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		return  $insert_id;
	}
	
	function update($id,$data)
	{
		$this->db->where('id', $id);
		return $this->db->update('respuesta', $data);
	}
	
}