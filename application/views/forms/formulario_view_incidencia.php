<div class="content">
	<a href="<?php echo base_url() . "incidencias";?>">Volver</a>
	<div class="title">
    	<h2>INGRESE SUS DATOS</h2>
    </div>
	<div class="form_1">
		<!-- Errors -->
		<?php echo validation_errors(); ?>
		<!-- !errors -->
		<form action="<?php echo base_url() . "incidencias/form_validation_answer"; ?>" method="post" id="incidenciaEdit">
			<div class="box1">
				<div class="elemento1">
					<label for="empresa">Empresa:</label>
					<select name="empresa" id="empresa" disabled="disabled">
						<option value="<?php echo htmlentities($incidencia->idEmpresa); ?>" selected="selected"><?php echo htmlentities($incidencia->nombreEmpresa, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></option>
					</select>
				</div>
				<div class="elemento2">
					<label for="tipoincidencia">Tipo de Incidencia:</label>
					<select name="tipoincidencia" id="tipoincidencia" disabled="disabled">
							<option value="<?php echo htmlentities($incidencia->idTipoIncidencia); ?>" selected="selected"><?php echo htmlentities($incidencia->nombreTipoIncidencia, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></option>
					</select>
				</div>
				<div class="elemento3">
					<label for="medio">Medio:</label>
					<select name="medio" id="medio" disabled="disabled">
						<option value="<?php echo htmlentities($incidencia->idMedio); ?>" selected="selected"><?php echo htmlentities($incidencia->nombreMedio, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></option>
					</select>
				</div>
			</div>
			<div class="box2">
				<div class="contenido1">
					<label for="titulo">Titulo:</label>
					<input type="text" name="titulo" id="titulo" readonly disabled="disabled" value="<?php echo htmlentities($incidencia->titulo,ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?>" />
					<label for="incidencia" style="vertical-align: top;">Incidencia:</label>
					<textarea name="incidencia" id="incidencia" cols="50" rows="10" readonly disabled="disabled"><?php echo htmlentities($incidencia->descripcion,ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></textarea>
					<?php if ( $incidencia->id_estado != 3 ): ?>
						<div class="botonaprobada">
                    		Ver Respuesta Aprobadas
                    	</div>
                    <?php endif; ?>
				</div>
				<div class="contenido2">
					<label for="respuesta" style="vertical-align:top;">Respuesta:</label>
					<?php $postresp = set_value("respuesta"); ?>
					<textarea name="respuesta" maxlength="255" <?php if ( $incidencia->estadoRespuesta == 1 ): ?>readonly disabled="disabled" <?php endif;?> id="respuesta" cols="50" rows="10"><?php echo !empty($postresp)?$postresp:htmlentities($incidencia->descripcionRespuesta,ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></textarea>
					<div id="charNum"></div>
				</div>
				<?php if ( $rol == 3 && $incidencia->estadoRespuesta != 1 ): ?>
					<div class="aprobadas">
	                    <label for="ticket">Respuesta Aprobada
	                	<input type="checkbox" name="ticket" id="ticket" /></label>
					</div>
				<?php endif; ?>
				<!-- INFO RESPUESTA APROBADA -->
				<?php if ( $incidencia->estadoRespuesta == 1 /*&& $rol == 1*/ ): ?>
					<div style="background: green; color: #fff; font: lighter 13px 'Open Sans'; padding: 0 10px; margin: 20px 0; ">
						<?php echo htmlentities($incidencia->nombreEmpresa, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?> - <?php echo $incidencia->fecha; ?> - Respondido - <?php echo $incidencia->fechaRespuesta; ?>
					</div>
				<?php endif;?>
			</div>
			<div class="box3">
				<div class="title">
                	<h2>DATOS Cliente</h2>
                </div>
                <div>
                	<label for="nombre">Nombre:</label>
					<input type="text" name="nombre" id="nombre" readonly disabled="disabled" value="<?php echo htmlentities($incidencia->nombreCliente, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?>" />
                </div>
                <div>
                	<label for="email">Email:</label>
					<input type="text" name="email" id="email" readonly disabled="disabled" value="<?php echo htmlentities($incidencia->emailCliente); ?>" />
                </div>
                <div>
                	<label for="telefono">Tel&eacute;fono:</label>
					<input type="text" name="telefono" id="telefono" readonly disabled="disabled" value="<?php echo htmlentities($incidencia->telefonoCliente); ?>" />
                </div>
                <div>
                	<label for="rut">Rut:</label>
                	<input type="text" name="rut" id="rut" readonly disabled="disabled" value="<?php echo htmlentities($incidencia->rutCliente, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?>"/>
                </div>
                <?php if ( $incidencia->estadoRespuesta != 1 ): ?>
                	<a href="<?php echo base_url() . "incidencias";?>">Cancelar</a>
                	<div class="mask"></div>
					<input type="submit" name="submit" value="Enviar" /> 
					<input type="hidden" name="inID" value="<?php echo htmlentities($incidencia->id); ?>" />
					<input type="hidden" name="idRespuesta" value="<?php echo htmlentities($incidencia->idRespuesta); ?>" />
				<?php else: ?>
					<a href="<?php echo base_url() . "incidencias";?>">Volver</a>
				<?php endif;?>
			</div>
		</form>
	</div>
</div>