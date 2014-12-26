<div class="content_respuesta">
        <div class="title">
            <h2>Respuestas Aprobadas</h2>
        </div>
        <?php if ( !empty($respuestas) ): ?>
	        <?php foreach ( $respuestas as $respuesta ): ?>
	        	<div class="contenido_respuesta">
		            <div class="subtitle">
		                <?php echo htmlentities($respuesta->incidenciaTitulo, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?>
		            </div>
		            <div class="textorespuesta">
		                <?php echo htmlentities($respuesta->descripcionRespuesta, ENT_QUOTES | ENT_IGNORE, 'UTF-8'); ?>
		            </div>
		        </div>
	        <?php endforeach;?>
        <div class="vermas">Ver M&aacute;s</div>
        <?php echo $this->pagination->create_links(); ?>
        <?php else: ?>
        	No existen respuestas aprobadas para la empresa consultada.
       	<?php endif; ?>
</div>
