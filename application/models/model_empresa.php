<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_empresa extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function getEmpresasByIdUsuario($id)
	{
		$this->db->select('id_empresa');    
		$this->db->from('usuario_empresa');
		$this->db->where('id_usuario',$id);
		$query = $this->db->get();
		
		$row = $query->result();
		
		foreach ( $row as $id )
		{
			$arrid[] = $id->id_empresa;
		}
		
		$query2 = $this->db->query("SELECT * from empresa WHERE id IN (".implode(',',$arrid).")");
		
		$finalrow = $query2->result();
		
		return $finalrow;
	}
	
	function getEmpresas()
	{
		$this->db->select("*");
		$this->db->from("empresa");
		$query = $this->db->get();
		
		$row = $query->result();
		
		return $row;
	}
}