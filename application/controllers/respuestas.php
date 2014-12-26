<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Respuestas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_respuesta');
	}
	
	function aprobadas($offset = 0)
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			$id = $this->input->post('id');
			$idTipo = $this->input->post('idtipo');
			$total_rows = $this->model_respuesta->getCountRespuestasAprobadas($id,$idTipo);
			$this->load->library('pagination');
			$config['base_url'] = base_url().'/respuestas/aprobadas/';
			$config['total_rows'] = $total_rows[0]->cantidad;
			$config['per_page'] = 4;
			// Initialize
			$this->pagination->initialize($config);
			
			$data["respuestas"] = $this->model_respuesta->getRespuestasAprobadas($id,$idTipo, $config['per_page'], $offset);
			$this->load->view("respuestas/aprobadas", $data);
		} 
	}
}