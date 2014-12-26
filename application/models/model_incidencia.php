<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_incidencia extends CI_Model
{
	
	/*
	 * TORPEDO
	 *       
	  public 'id' => string '1' (length=1)
      public 'id_usuario' => string '1' (length=1)
      public 'id_empresa' => string '1' (length=1)
      public 'id_tipo_incidencia' => string '2' (length=1)
      public 'id_medio' => string '1' (length=1)
      public 'titulo' => string 'Reclamo Facebook' (length=16)
      public 'descripcion' => string 'Reclamo de señora en facebook' (length=30)
      public 'id_cliente' => string '1' (length=1)
      public 'id_respuesta' => null
      public 'id_estado' => string '1' (length=1)
      public 'fecha' => string '2014-11-26 17:59:51' (length=19)
      public 'nombreEmpresa' => string 'Empresa1' (length=8)
      public 'idEmpresa' => string '1' (length=1)
      public 'nombreEstado' => string 'Uno' (length=3)
      public 'idEstado' => string '1' (length=1)
      public 'nombreCliente' => string 'Tua Buelita' (length=11)
      public 'idCliente' => string '1' (length=1)
      public 'emailCliente' => string 'tuabuelitadelboom@gmail.com' (length=27)
      public 'telefonoCliente' => string '2321321321' (length=10)
      public 'idTipoIncidencia' => string '2' (length=1)
      public 'nombreTipoIncidencia' => string 'Dos' (length=3)
      public 'nombreMedio' => string 'Facebook' (length=8)
      public 'idMedio' => string '1' (length=1)
      public 'descripcionRespuesta' => null
      public 'idRespuesta' => null
      public 'fechaRespuesta' => null
	 */
	
	public function __construct()
	{
		parent::__construct();
	}
	
	function getAllbyUserId($id, $per_page, $offset, $where = array ())
	{
		
		$wheresql = "";
		
		if ( !empty($where) )
		{
			if ( isset($where["filtroEmpresa"]) )
			{ 
				$wheresql .= " AND e.id = " . $where["filtroEmpresa"];
			}
			if ( isset($where["filtroFecha_a"]) && isset($where["filtroFecha_b"]) )
			{
				$wheresql .= " AND i.fecha BETWEEN DATE('" . $where["filtroFecha_a"] . "') AND DATE('" . $where["filtroFecha_b"] . "')";
			}
		}
		
		$query = $this->db->query("
			SELECT
				i.*,
				u.nombre AS nombreUsuario,
				e.nombre AS nombreEmpresa,
				e.id AS idEmpresa,
				es.nombre AS nombreEstado,
				es.id AS idEstado,
				c.nombre AS nombreCliente,
				c.id AS idCliente,
				c.email AS emailCliente,
				c.telefono AS telefonoCliente,
				t.id AS idTipoIncidencia,
				t.nombre AS nombreTipoIncidencia,
				m.nombre AS nombreMedio,
				m.id AS idMedio,
				r.descripcion AS descripcionRespuesta,
				r.id AS idRespuesta,
				r.fecha AS fechaRespuesta,
				r.estado AS estadoRespuesta,
				r.fechaProceso AS fechaProceso
			FROM `incidencia` AS i
			LEFT JOIN empresa AS e ON i.id_empresa = e.id
			LEFT JOIN tipo_incidencia AS t ON i.id_tipo_incidencia = t.id
			LEFT JOIN medio AS m ON i.id_medio = m.id
			LEFT JOIN cliente AS c ON i.id_cliente = c.id
			LEFT JOIN respuesta AS r ON i.id_respuesta = r.id
				LEFT JOIN usuario as u ON r.id_usuario = u.id
			LEFT JOIN estado AS es ON i.id_estado = es.id
			WHERE id_empresa IN (
			    SELECT id_empresa FROM usuario_empresa WHERE id_usuario = $id   
			) $wheresql
			ORDER BY e.nombre, i.fecha DESC,i.id_estado ASC
			LIMIT $offset,$per_page
		");
		
		$row = $query->result();
		
		return $row;
	}
	
	function getCountAllbyUserId($id, $where = array())
	{
		$wheresql = "";
		
		if ( !empty($where) )
		{
			if ( isset($where["filtroEmpresa"]) )
			{
				$wheresql .= " AND e.id = " . $where["filtroEmpresa"];
			}
			if ( isset($where["filtroFecha_a"]) && isset($where["filtroFecha_b"]) )
			{
				$wheresql .= " AND i.fecha BETWEEN DATE('" . $where["filtroFecha_a"] . "') AND DATE('" . $where["filtroFecha_b"] . "')";
			}
		}
		$query = $this->db->query("
				SELECT
				COUNT(i.id) AS cantidad
				FROM `incidencia` AS i
				LEFT JOIN empresa AS e ON i.id_empresa = e.id
				LEFT JOIN tipo_incidencia AS t ON i.id_tipo_incidencia = t.id
				LEFT JOIN medio AS m ON i.id_medio = m.id
				LEFT JOIN cliente AS c ON i.id_cliente = c.id
				LEFT JOIN respuesta AS r ON i.id_respuesta = r.id
				LEFT JOIN estado AS es ON i.id_estado = es.id
				WHERE id_empresa IN (
					SELECT id_empresa FROM usuario_empresa WHERE id_usuario = $id
				) $wheresql
				");
	
		$row = $query->result();

		return $row;
	}
	
	function getIncidenciaById($id)
	{
		$query = $this->db->query("
			SELECT
				i.*,
				e.nombre AS nombreEmpresa,
				e.id AS idEmpresa,
				es.nombre AS nombreEstado,
				es.id AS idEstado,
				c.nombre AS nombreCliente,
				c.id AS idCliente,
				c.email AS emailCliente,
				c.telefono AS telefonoCliente,
				c.rut AS rutCliente,
				t.id AS idTipoIncidencia,
				t.nombre AS nombreTipoIncidencia,
				m.nombre AS nombreMedio,
				m.id AS idMedio,
				r.descripcion AS descripcionRespuesta,
				r.id AS idRespuesta,
				r.fecha AS fechaRespuesta,
				r.estado AS estadoRespuesta,
				r.fechaProceso AS fechaProceso
			FROM `incidencia` AS i
			LEFT JOIN empresa AS e ON i.id_empresa = e.id
			LEFT JOIN tipo_incidencia AS t ON i.id_tipo_incidencia = t.id
			LEFT JOIN medio AS m ON i.id_medio = m.id
			LEFT JOIN cliente AS c ON i.id_cliente = c.id
			LEFT JOIN respuesta AS r ON i.id_respuesta = r.id
			LEFT JOIN estado AS es ON i.id_estado = es.id
			WHERE i.id = $id
		");
		
		$row = $query->row();
		
		return $row;
	}
	
	function insert($data)
	{
		$insert = $this->db->insert('incidencia',$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
	
	function update($id,$data)
	{	
		$this->db->where('id', $id);
		return $this->db->update('incidencia', $data);
	}
}