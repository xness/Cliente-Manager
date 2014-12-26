<div class="content">
	<div class="title">
		<h2>Incidencias</h2>
	</div>
	<?php if ( !empty($incidencias) ): ?>
		<div class="fEmpresa">
			<form action="<?php echo base_url(); ?>incidencias" method="POST" id="formE">
				<select name="filtroEmpresa" onChange="filtrarByEmpresa();">
					<option value="">Filtrar por empresa</option>
						<option value="0">Todas</option>
						<?php foreach ( $empresas as $empresa ): ?>
							<option value="<?php echo $empresa->id; ?>" <?php if ( $empresa->id == $this->session->userdata('filtroEmpresa') ): ?>selected="selected"<?php endif;?>><?php echo $empresa->nombre; ?></option>
						<?php endforeach; ?>
				</select>
			</form>
		</div>
		<?php if ( $this->session->userdata('filtroEmpresa') ): ?>
			<div class="fFecha">
				<form action="<?php echo base_url(); ?>incidencias" method="POST" id="formF">
					<label>Filtrar por fecha</label>
					<input type="date" name="filtroFecha_a" <?php if ( $this->session->userdata('filtroFecha_a') ): ?>value="<?php echo $this->session->userdata('filtroFecha_a'); ?>" <?php endif; ?> />
					a
					<input type="date" name="filtroFecha_b" <?php if ( $this->session->userdata('filtroFecha_b') ): ?>value="<?php echo $this->session->userdata('filtroFecha_b'); ?>" <?php endif; ?>/>
					<input type="button" value="filtrar" onClick="filtrarByFecha();" />
				</form>
			</div>
		<?php endif; ?>
		<table cellpadding="10">
			<thead>
				<tr>
					<th>ID</th>
					<th>Empresa</th>
					<th>Fecha Ingreso</th>
					<th>Estado</th>
					<th>Fecha Proceso</th>
					<th>Fecha Respuesta</th>
					<th><!-- Link --></th>
					<th><!-- Respondido POR --></th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1; ?>
				<?php $tmp = $incidencias[0]->id_empresa; ?>
				<?php foreach ( $incidencias as $incidencia ): ?>
					<?php 
						if ( $incidencia->id_empresa != $tmp ) {
							$i = 1;
							$tmp = $incidencia->id_empresa;
						}
					?>
					<tr bgcolor="<?php echo $bgstate[$incidencia->idEstado]; ?>" class="<?php echo $color[$incidencia->idEstado]; ?>">
						<td><?php echo $i++; ?></td>
						<td><?php echo htmlentities($incidencia->nombreEmpresa); ?></td>
						<td><?php echo $incidencia->fecha; ?></td>
						<td><?php echo htmlentities($incidencia->nombreEstado); ?></td>
						<td><?php echo is_null($incidencia->fechaProcesoIncidencia)?'00-00-00':$incidencia->fechaProcesoIncidencia; ?></td>
						<td><?php echo is_null($incidencia->fechaRespuesta)?'00-00-00':$incidencia->fechaRespuesta; ?></td>
						<td><a href="<?php echo base_url() . "incidencias/view/" . $incidencia->id; ?>">Ver Denuncia</a></td>
						<td bgcolor="#fff"><?php if ($incidencia->nombreUsuario): ?><small style="color: #333">Respondido por: <b><?php echo htmlentities($incidencia->nombreUsuario, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></b></small><?php endif; ?></td>
					</tr>
					
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<p>No existen incidencias registradas a la fecha.</p>
		<a href="<?php echo base_url() . "incidencias"; ?>">Volver</a>
	<?php endif; ?>
	<div class="pagination">
		<?php echo $this->pagination->create_links(); ?>
	</div>
	<?php if ( $rol == 1 ): ?>
		<a href="<?php echo base_url() . "incidencias/add"; ?>">
			A&ntilde;adir Incidencia
		</a>
	<?php endif; ?>
</div>