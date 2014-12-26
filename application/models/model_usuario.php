<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuario extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function is_logged_in()
	{
		$this->db->where('email', $this->input->post('email'));
		$this->db->where('password', md5($this->input->post('password')));
		
		$query = $this->db->get('usuario');
		
		if ( $query->num_rows() == 1 ) 
		{
			return true;
		} else {
			return false;
		}
		
	}
	
	function getDataByEmail($str)
	{
		$this->db->where('email', $str);
		
		$query = $this->db->get('usuario');
		
		if ( $query->num_rows() == 1 )
		{
			$row = $query->row();
			return $row; 
		}
	}
	
	function getDataByIds($ids)
	{
		foreach ( $ids as $id )
		{
			$arrid[] = $id->id_usuario;
		}
		$query = $this->db->query("SELECT email,nombre FROM usuario WHERE id IN (".implode(',', $arrid).")");
		$row = $query->result();
		
		return $row;
	}
	
} 