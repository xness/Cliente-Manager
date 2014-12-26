<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Incidencias extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model("model_usuario");
		$this->load->model("model_incidencia");
		$this->load->model("model_empresa");
		$this->load->model("model_usuario_empresa");
		$this->load->model("model_tipo_incidencia");	
		$this->load->model("model_respuesta");
		$this->load->model("model_medio");
		$this->load->model("model_cliente");
		$this->load->library('My_PHPMailer');
	}
	
	public function index($offset = 0)
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			if ( $this->session->userdata("rol") == 4 ) redirect('estadisticas');
				
			$data = $this->getHeaderData();
			$this->load->view("header",$data);

			// Filtro
			$where = array();
				
			if ( $this->input->post("filtroEmpresa") )
			{
				$this->session->unset_userdata('filtroFecha_a');
				$this->session->unset_userdata('filtroFecha_b');
				$this->session->set_userdata('filtroEmpresa', $this->input->post('filtroEmpresa'));
			}
				
			if ( $this->session->userdata('filtroEmpresa') ) {
				$where["filtroEmpresa"] = $this->session->userdata('filtroEmpresa');
			}
				
			if ( $this->input->post("filtroFecha_a") && $this->input->post("filtroFecha_b") ) {
				$this->session->set_userdata('filtroFecha_a', $this->input->post('filtroFecha_a'));
				$this->session->set_userdata('filtroFecha_b', $this->input->post('filtroFecha_b'));
			}
				
			if ( $this->session->userdata('filtroFecha_a') && $this->session->userdata('filtroFecha_b') ) {
				$where["filtroFecha_a"] = $this->session->userdata('filtroFecha_a');
				$where["filtroFecha_b"] = $this->session->userdata('filtroFecha_b');
			}
			// !Filtro
			
			$this->load->library('pagination');
			$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
			$total_rows = $this->model_incidencia->getCountAllbyUserId($udata->id,$where);
			$config['base_url'] = base_url().'/incidencias/index/';
			$config['total_rows'] = $total_rows[0]->cantidad;
			$config['per_page'] = 10;
			$this->pagination->initialize($config);			
			
			$dataIncidencias["incidencias"] = $this->model_incidencia->getAllbyUserId($udata->id,$config['per_page'], $offset, $where);
			
			if ( empty($dataIncidencias["incidencias"]) ) {
				$this->session->unset_userdata('filtroFecha_a');
				$this->session->unset_userdata('filtroFecha_b');
				$this->session->unset_userdata('filtroEmpresa');
			}
			
			$id = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
			$dataIncidencias["empresas"] = $this->model_empresa->getEmpresasByIdUsuario($id->id);
			
			$this->load->view("incidencias/index",$dataIncidencias);
				
			$this->load->view("footer");
				
		} else {
			redirect("inicio/restricted");
		}
	}
	
	function todas()
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			$this->session->unset_userdata('filtroFecha_a');
			$this->session->unset_userdata('filtroFecha_b');
			$this->session->unset_userdata('filtroEmpresa');
			redirect('incidencias');
		}
	}
	
	function add()
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			// Obtenemos id usuario
			$id = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
			$data = $this->getHeaderData();
			$data["titulo"] = "A&ntilde;adir Incidencia";
			$data["empresas"] = $this->model_empresa->getEmpresasByIdUsuario($id->id);
			$data["tipoincidencias"] = $this->model_tipo_incidencia->getAll();
			$data["medios"] = $this->model_medio->getAll();
			
			$this->load->view("header", $data);
			
			$this->load->view("forms/formulario_incidencia");
			
			$this->load->view("footer");
		} else {
			redirect("inicio/restricted");
		}
	}
	
	function form_validation()
	{
		$this->load->library("form_validation");
		
		$this->form_validation->set_rules('empresa','Empresa','required|trim');
		$this->form_validation->set_rules('tipoincidencia','Tipo Incidencia','required|trim');
		$this->form_validation->set_rules('medio','Medio','required|trim');
		$this->form_validation->set_rules('titulo','Titulo','required|trim');
		$this->form_validation->set_rules('incidencia','Incidencia','required|trim');
		$this->form_validation->set_rules('nombre','Nombre','required|trim');
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		//$this->form_validation->set_rules('telefono','Telefono','required|trim');
		
		$this->form_validation->set_message('required','El campo %s es requerido.');
		
		if ( $this->form_validation->run() === FALSE )
		{
			$this->add();
		} else {
			$this->register();
		}
		
	}
	
	function form_validation_answer()
	{
		$this->load->library("form_validation");

		$this->form_validation->set_rules('respuesta','Respuesta','required|trim|min_length[5]|max_length[255]');
	
		$this->form_validation->set_message('required','El campo %s es requerido.');
	
		if ( $this->form_validation->run() === FALSE )
		{
			$idN = $this->input->post('inID');
			$this->view($idN);
		} else {
			// checkea si edita CM o cliente  
			$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
			if ( $this->input->post('ticket') )
			{
				$id = $this->input->post('idRespuesta');
				
				$dataIncidencia = array(
					'id_estado' => 3,
					'fechaProcesoIncidencia' => date("Y-m-d H:i:s")	
				);
				
				$idIncidencia = $this->input->post("inID");
				
				$update = $this->model_incidencia->update($idIncidencia,$dataIncidencia);
				
				if ( $update )
				{
					$data = array(
							'descripcion' => $this->input->post('respuesta'),
							'estado' => 1,
							'fecha'  => date("Y-m-d H:i:s")
					);
					$incidencia = $this->model_incidencia->getIncidenciaById($idIncidencia);
					$titulo = $incidencia->titulo;
					$descripcion = $incidencia->descripcion;
					$asunto = "Incidencia con respuesta aprobada por ".$udata->nombre." ";
					$mensaje = "
						Incidencia: $titulo<br/>
						$descripcion <br/>
						<a href='".base_url()."incidencias/view/".$idIncidencia."'>Ver Incidencia</a>
					";
					if ( $this->sendEmail($udata->id,$idIncidencia,$asunto,$mensaje) ) {
						$this->updateRespuesta($id, $data);
					}
				}
				
			} else {
				if ( trim($this->input->post('idRespuesta')) == '' )
				{
					$this->addRespuesta();
				} else {
					$id = $this->input->post('idRespuesta');
					$data = array(
						'descripcion' => $this->input->post('respuesta'),
						'fechaProceso' => date("Y-m-d H:i:s")	
					);
					$titulo = $this->input->post("titulo");
					$asunto = "Incidencia respondida por ".$udata->nombre." ";
					
					$idIncidencia = $this->input->post("inID");
					$incidencia = $this->model_incidencia->getIncidenciaById($idIncidencia);
					$titulo = $incidencia->titulo;
					$descripcion = $incidencia->descripcion;
					$asunto = "Incidencia con respuesta aprobada por ".$udata->nombre." ";
					$mensaje = "
						Incidencia: $titulo<br/>
						$descripcion <br/>
						<a href='".base_url()."incidencias/view/".$idIncidencia."'>Ver Incidencia</a>
					";
					if ( $this->sendEmail($udata->id,$idIncidencia,$asunto,$mensaje) ) {
						$this->updateRespuesta($id, $data);
					}
				}
			}
		}
	
	}
	
	function updateRespuesta($id,$data)
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			$update = $this->model_respuesta->update($id, $data);
			if ( $update ) redirect('incidencias');
		} else {
			redirect("inicio/restricted");
		}	
	}
	
	function addRespuesta()
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			$empresa = $this->input->post("empresa");
			$respuesta = $this->input->post("respuesta");
			$idIncidencia = $this->input->post("inID");
			$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
			//add Respuesta
			$dataRespuesta = array(
					'id_usuario'   => $udata->id,
					'descripcion'  => $respuesta
			);
			
			$idRespuesta = $this->model_respuesta->insert($dataRespuesta);
			
			// update incidencia estado 2
			if ( $idRespuesta )
			{
				$dataIncidencia = array(
					'id_respuesta' =>	$idRespuesta,
					'id_estado' => 3
				);	
				
				$updateIncidencia = $this->model_incidencia->update($idIncidencia,$dataIncidencia);
				
				if ( $updateIncidencia )
				{
					$titulo = $this->input->post("titulo");
					$asunto = "Incidencia respondida por ".$udata->nombre." ";
					$incidencia = $this->model_incidencia->getIncidenciaById($idIncidencia);
					$titulo = $incidencia->titulo;
					$descripcion = $incidencia->descripcion;
					$asunto = "Incidencia con respuesta aprobada por ".$udata->nombre." ";
					$mensaje = "
						Incidencia: $titulo<br/>
						$descripcion <br/>
						<a href='".base_url()."incidencias/view/".$idIncidencia."'>Ver Incidencia</a>
					";
					if ( $this->sendEmail($udata->id,$idIncidencia,$asunto,$mensaje) ) redirect("incidencias");
				}
			}
			
		} else {
			redirect("inicio/restricted");
		}
	}
	
	function register()
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			$empresa = $this->input->post("empresa");
			$tipoincidencia = $this->input->post("tipoincidencia");
			$medio = $this->input->post("medio");
			$titulo = $this->input->post("titulo");
			$incidencia = $this->input->post("incidencia");
			$nombre = $this->input->post("nombre");
			$email = $this->input->post("email");
			$rut = $this->input->post("rut")!=''?$this->input->post("rut"):null;
			$telefono = $this->input->post("telefono");
			
			// add cliente
			$dataCliente = array(
				'nombre' => $nombre,
				'email'  => $email,
				'telefono' => $telefono,
				'rut'      => $rut	
			);
			
			$idInsertCliente = $this->model_cliente->insert($dataCliente);

			if ( $idInsertCliente )
			{
				$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
				$dataIncidencia = array(
					'id_usuario' =>	$udata->id,
					'id_empresa' => $empresa,
					'id_tipo_incidencia' => $tipoincidencia,
					'id_medio' => $medio,
					'titulo' => $titulo,
					'descripcion' => $incidencia,
					'id_cliente' => $idInsertCliente
				);	
				
				$idInsertIncidencia = $this->model_incidencia->insert($dataIncidencia);
				
				if ( $idInsertIncidencia )
				{
					$asunto = "Incidencia registrada por ".$udata->nombre." ";
					$mensaje = "
						Incidencia: $titulo<br/>
						<a href='".base_url()."incidencias/view/".$idInsertIncidencia."'>Ver Incidencia</a> 
					";
					if ( $this->sendEmail($udata->id,$idInsertIncidencia,$asunto,$mensaje) ) redirect("incidencias");
				}
			}
			
		} else {
			redirect("inicio/restricted");
		}
	}
	
	function view($id)
	{
		if ( $this->session->userdata("is_logged_in") )
		{
			$id = (int) $id;
			
			if ( empty($id) || !is_int($id) ) {
				redirect('incidencias');
			}
			
			// Pertenece al usuario?
			$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
			$listEmpresas = $this->model_usuario_empresa->getIdEmpresaByUserId($udata->id);
			$incidencia = $this->model_incidencia->getIncidenciaById($id);	
			
			$valido = true;
			
			if ( $this->pertenece($listEmpresas,$incidencia) ) 
			{
				if ( is_null($incidencia->fechaProcesoIncidencia) )
				{
					$dataIncidencia = array(
							'id_estado' => 2,
							'fechaProcesoIncidencia' => date("Y-m-d H:i:s")
					);
				
					$idIncidencia = $incidencia->id;
				
					$update = $this->model_incidencia->update($idIncidencia,$dataIncidencia);
				}
				
				$headerData = $this->getHeaderData();
				$headerData["titulo"] =  "Incidencia: " . $incidencia->titulo;
				
				$this->load->view("header",$headerData);
				
				$data = array(
						"incidencia" => $incidencia
				);
				
				$this->load->view("forms/formulario_view_incidencia", $data);
				
				$this->load->view("footer");
			} else {
				redirect('incidencias');
			}
		} else {
			$this->load->helper('url');
			$this->session->set_userdata('last_page', current_url());
			redirect("inicio/restricted");
		}
		
	}
	
	function getHeaderData()
	{
		$udata = $this->model_usuario->getDataByEmail($this->session->userdata("email"));
		$imagenEmpresa = $this->model_empresa->getEmpresasByIdUsuario($udata->id);
		$data = array(
				'titulo' => "Incidencias",
				'nombre' => $udata->nombre,
				'email'  => $udata->email,
				'imagen' => $udata->imagen,
				'imagenEmpresa' => $imagenEmpresa[0]->imagen,
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
	
	function pertenece($listEmpresas, $incidencia)
	{
		foreach ( $listEmpresas as $empresaID )
		{
			if ( $empresaID->id_empresa == $incidencia->idEmpresa )
			{
				return true;
			}
		}	
		
		return false;
	}
	
	function sendEmail($userId,$idIncidencia,$asunto,$mensaje)
	{
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPAuth   = true; 
		$mail->SMTPSecure = "ssl"; 
		$mail->Host       = "smtp.gmail.com";
		$mail->Port       = 465;
		$mail->Username   = "contacto@bluedigital.cl";
		$mail->Password   = "c0nt4ct0";
		$mail->SetFrom('no-reply@bluedigital.cl', 'Cliente Manager'); 
		$mail->Subject    = "".$asunto."";
		$mail->isHTML(true);
		$mail->Body = "".$mensaje."";
		
		//Destinos
		$userIds = $this->model_usuario_empresa->getIdUsuariosByUserId($userId);
		$userEmails = $this->model_usuario->getDataByIds($userIds);
		
		foreach ( $userEmails as $email )
		{
			$mail->AddAddress($email->email, $email->nombre);
		}
		
		$mail->CharSet = 'UTF-8';
		
		if( $mail->Send() ) {
			return true;	
		} else {
			return false;
		}
	}
	
}