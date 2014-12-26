<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuario_empresa extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function getIdEmpresaByUserId($id)
	{
		$query = $this->db->query("
			SELECT id_empresa		
			FROM usuario_empresa
			WHERE id_usuario = $id
		");
		
		$row = $query->result();
		
		return $row;
	}
	
	function getIdEmpresasByUserId($id)
	{
		$query = $this->db->query("
				SELECT id_empresa
				FROM usuario_empresa
				WHERE id_usuario = $id
				");
	
		$row = $query->result();
	
		return $row;
	}
	
	function getIdUsuariosByUserId($id)
	{
		$eids = $this->getIdEmpresasByUserId($id);
		
		foreach ( $eids as $eid )
		{
			$arrId[] = $eid->id_empresa;
		}
		
		$query = $this->db->query("
				SELECT DISTINCT id_usuario
				FROM usuario_empresa
				WHERE id_empresa IN ( ".implode(',',$arrId)." )
				AND id_usuario != $id
				");
		
		$row = $query->result();
		
		return $row;
	}
}