<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_medio extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function getAll()
	{
		$this->db->select('*');
		$this->db->from('medio');
		$query = $this->db->get();
		
		$row = $query->result();
		
		return $row;
	}
}