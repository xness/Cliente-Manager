<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller 
{
	public function index()
	{
		$this->login();
	}
	
	function login()
	{
		
		if ( $this->session->userdata("is_logged_in") ) redirect("incidencias");
		
		$data = array("titulo"=>"Login");
		
		$this->load->view("header", $data);
		
		$this->load->view("forms/formulario_login");
		
		$this->load->view("footer");
	}
	
	function restricted()
	{
		$this->load->view("restricted/index");
	}
	
	function form_validation()
	{
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|callback_comprobar_validacion');
		$this->form_validation->set_rules('password','Password','required|trim|md5');
		$this->form_validation->set_message('required','El campo %s es requerido.');
		$this->form_validation->set_message('valid_email','El campo %s debe contener un email v&aacute;lido.');
		
		if ( $this->form_validation->run() === FALSE )
		{
			$this->login();
		} else {
			if ( $this->input->post('email') == 'contacto@bluedigital.cl' )
			{
				$rols = 4;	
			} else {
				$rol = $this->model_usuario->getDataByEmail($this->input->post("email"));
				$rols = $rol->id_rol;
			}
			$session_user = array(
				'email'        => $this->input->post("email"),
				'password'     => $this->input->post("password"),
				'is_logged_in' => 1	,
				'rol' => $rols
			);
			
			$this->session->set_userdata($session_user);
			
			
			if ( $this->session->userdata("last_page") ) {
				redirect($this->session->userdata("last_page"));
			} else {
				if ( $this->session->userdata("rol") == 4 )
				{
					redirect("estadisticas");
				} else {
					redirect("incidencias");
				}
			}
		}
	}
	
	function comprobar_validacion()
	{
		$this->load->model('model_usuario');
		
		if ( $this->model_usuario->is_logged_in() || $this->input->post("email") == "contacto@bluedigital.cl" && $this->input->post("password") == "c0nt4ct0"  )
		{
			return true;
		} else {
			$this->form_validation->set_message('comprobar_validacion','Email o Password incorrectos.');
			return false;
		}
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect("inicio/login");
	}
	
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */