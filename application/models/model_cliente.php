<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_cliente extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function getClientIdByEmail($email)
	{
		$query = $this->db->query("SELECT id from cliente WHERE email = '$email'");
		
		$row = $query->result();
		
		return $row[0]->id;
	}
	
	function clientExist($email)
	{
		$query = $this->db->query("SELECT COUNT(id) AS cantidad from cliente WHERE email = '$email'");
		
		$row = $query->result();
		
		return $row[0]->cantidad;
	}
	
	function insert($data)
	{
		if ( $this->clientExist($data["email"]) == 0 )
		{
			$this->db->trans_start();
			$insert = $this->db->insert('cliente',$data);
			$insert_id = $this->db->insert_id();
			$this->db->trans_complete();
			return  $insert_id;
		} else {
			$id = $this->getClientIdByEmail($data["email"]);
			return $id;
		}
	}
}