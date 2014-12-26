<div class="content">
	<a href="<?php echo base_url() . "incidencias";?>">Volver</a>
	<div class="title">
    	<h2>INGRESE SUS DATOS</h2>
    </div>
    <div class="form_1">
    	<!-- Errors -->
		<?php echo validation_errors(); ?>
		<!-- !errors -->
		<form action="<?php echo base_url() . "incidencias/form_validation"; ?>" method="post" id="incidencia">
			<div class="box1">
				<div class="elemento1">
                	<label for="empresa">Empresa:</label>
                    <select name="empresa" id="empresa">
						<?php if ( $empresas ): ?>
							<option value="">Seleccione Empresa</option>
							<?php foreach ( $empresas as $empresa  ): ?>
								<option value="<?php echo htmlentities($empresa->id); ?>" <?php if ( set_value('empresa') == $empresa->id ): ?>selected="selected"<?php endif;?>><?php echo htmlentities($empresa->nombre, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
                <div class="elemento2">
					<label for="tipoincidencia">Tipo de Incidencia:</label>
					<select name="tipoincidencia" id="tipoincidencia">
						<?php if ( $tipoincidencias ): ?>
							<option value="">Seleccione Tipo Incidencia</option>
							<?php foreach ( $tipoincidencias as $tipoincidencia ): ?>
								<option value="<?php echo htmlentities($tipoincidencia->id); ?>" <?php if ( set_value('tipoincidencia') == $tipoincidencia->id ): ?>selected="selected"<?php endif;?>><?php echo htmlentities($tipoincidencia->nombre, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
                </div>
                <div class="elemento3">
					<label for="medio">Medio:</label>
                    <select name="medio" id="medio">
						<?php if ( $medios ): ?>
							<option value="">Seleccione Medio</option>
							<?php foreach ( $medios as $medio ): ?>
								<option value="<?php echo htmlentities($medio->id); ?>" <?php if ( set_value('medio') == $medio->id ): ?>selected="selected"<?php endif;?>><?php echo htmlentities($medio->nombre, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</div>
			</div> <!-- Box1 -->
			<div class="box2">
				<div class="contenido1">
                    <label for="titulo">Titulo:</label>
					<input type="text" name="titulo" id="titulo" value="<?php echo set_value("titulo"); ?>" />
					<label for="incidencia" style="vertical-align: top;">Incidencia:</label>
					<textarea name="incidencia" id="incidencia" cols="50" rows="10" maxlength="255"><?php echo set_value('incidencia'); ?></textarea>
					<div id="charNum"></div>
					<div class="botonaprobada">
                    	Ver Respuesta Aprobadas
                    </div>
				</div>
                <div class="contenido2">
                	<label style="display:none;" for="respuesta">Respuesta</label>
					<textarea style="display: none;" name="respuesta" id="respuesta" cols="50" rows="10"><?php echo set_value("respuesta"); ?></textarea>
				</div>
			</div><!-- Box 2 -->
			<div class="box3">
				<div class="title">
                	<h2>DATOS Cliente</h2>
                </div>
				<div>
                    <label for="nombre">Nombre:</label>
					<input type="text" name="nombre" id="nombre" value="<?php echo set_value('nombre'); ?>" />
                </div>
				<div>
                	<label for="email">Email:</label>
					<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" />
                </div>
				<div>
                    <label for="telefono">Tel&eacute;fono:</label>
					<input type="text" name="telefono" id="telefono" value="<?php echo set_value('telefono'); ?>" />
                </div>
                <div>
                	<label for="rut">Rut:</label>
                	<input type="text" name="rut" id="rut" value="<?php echo set_value('rut'); ?>" />
                </div>
                <a href="<?php echo base_url() . "incidencias";?>">Cancelar</a>
                <div class="mask"></div>
            	<input type="submit" name="submit" value="Enviar" />
			</div>
		</form>
    </div>
</div>