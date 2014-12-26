<div class="content">
	<div class="title">
		<h2>Estad&iacute;sticas</h2>
	</div>
	<div class="fEmpresa">
		<label for="filtroEmpresa">Seleccione Empresa:</label>
		<form action="<?php echo base_url() . "estadisticas"; ?>" method="POST" id="eForm">
			<select name="filtroEmpresa" id="filtroEmpresa" onChange="$('#eForm').submit();">
				<?php if ( !empty($empresas) ): ?>
					<?php foreach ( $empresas as $index => $empresa ): ?> 
						<option value="<?php echo $empresa->id; ?>" <?php if ( set_value("filtroEmpresa") == $empresa->id ):?>selected="selected"<?php endif;?>><?php echo $empresa->nombre; ?></option>
					<?php endforeach; ?>
				<?php endif;?>
			</select>
		</form>
	</div>
	<div class="estadisticas">
		<br /><br /><h2>Fecha Ingreso - Fecha Respuesta</h2>
		<table cellpadding="10" class="estadistica">
			<thead>
				<tr>
					<?php if ( !empty($tipoIncidencias) ): ?>
						<?php foreach( $tipoIncidencias as $tipoIncidencia ) : ?>
							<th style="width: 220px;"><?php echo $tipoIncidencia->nombre; ?></th>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>Promedio:</p> 
							<div class="chart-inner">
								<?php if ( isset($data1["promedio1"]) ): ?>
									<?php $minutos = explode(":",$data1["promedio1"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data1["promedio1"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["promedio2"]) ): ?>
									<?php $minutos = explode(":",$data1["promedio2"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data1["promedio2"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["promedio3"]) ): ?>
									<?php $minutos = explode(":",$data1["promedio3"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data1["promedio3"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["promedio4"]) ): ?>
									<?php $minutos = explode(":",$data1["promedio4"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data1["promedio4"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>M&iacute;nimo:</p> 
							<div class="chart-inner">
								<?php if ( isset($data1["minimo1"]) ): ?>
									<?php $minutos = explode(":",$data1["minimo1"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["minimo1"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["minimo2"]) ): ?>
									<?php $minutos = explode(":",$data1["minimo2"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["minimo2"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["minimo3"]) ): ?>
									<?php $minutos = explode(":",$data1["minimo3"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["minimo3"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["minimo4"]) ): ?>
									<?php $minutos = explode(":",$data1["minimo4"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["minimo4"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>M&aacute;ximo:</p> 
							<div class="chart-inner">
								<?php if ( isset($data1["maximo1"]) ): ?>
									<?php $minutos = explode(":",$data1["maximo1"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["maximo1"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["maximo2"]) ): ?>
									<?php $minutos = explode(":",$data1["maximo2"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["maximo2"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["maximo3"]) ): ?>
									<?php $minutos = explode(":",$data1["maximo3"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["maximo3"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data1["maximo4"]) ): ?>
									<?php $minutos = explode(":",$data1["maximo4"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data1["maximo4"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<!-- <tr>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder1)?$sinResponder1:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder2)?$sinResponder2:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder3)?$sinResponder3:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder4)?$sinResponder4:'0'; ?></b>
					</td>
				</tr> -->
			</tbody>
		</table>
		<hr />
		<!-- ################################################# -->
		<h2>Fecha Ingreso - Fecha Proceso</h2>
		<table cellpadding="10" class="estadistica">
			<thead>
				<tr>
					<?php if ( !empty($tipoIncidencias) ): ?>
						<?php foreach( $tipoIncidencias as $tipoIncidencia ) : ?>
							<th style="width: 220px;"><?php echo $tipoIncidencia->nombre; ?></th>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>Promedio:</p> 
							<div class="chart-inner">
								<?php if ( isset($data2["promedio1"]) ): ?>
									<?php $minutos = explode(":",$data2["promedio1"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data2["promedio1"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["promedio2"]) ): ?>
									<?php $minutos = explode(":",$data2["promedio2"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data2["promedio2"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["promedio3"]) ): ?>
									<?php $minutos = explode(":",$data2["promedio3"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data2["promedio3"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["promedio4"]) ): ?>
									<?php $minutos = explode(":",$data2["promedio4"]); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data2["promedio4"]; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>M&iacute;nimo:</p> 
							<div class="chart-inner">
								<?php if ( isset($data2["minimo1"]) ): ?>
									<?php $minutos = explode(":",$data2["minimo1"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["minimo1"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["minimo2"]) ): ?>
									<?php $minutos = explode(":",$data2["minimo2"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["minimo2"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["minimo3"]) ): ?>
									<?php $minutos = explode(":",$data2["minimo3"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["minimo3"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["minimo4"]) ): ?>
									<?php $minutos = explode(":",$data2["minimo4"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["minimo4"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>M&aacute;ximo:</p> 
							<div class="chart-inner">
								<?php if ( isset($data2["maximo1"]) ): ?>
									<?php $minutos = explode(":",$data2["maximo1"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["maximo1"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["maximo2"]) ): ?>
									<?php $minutos = explode(":",$data2["maximo2"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["maximo2"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["maximo3"]) ): ?>
									<?php $minutos = explode(":",$data2["maximo3"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["maximo3"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data2["maximo4"]) ): ?>
									<?php $minutos = explode(":",$data2["maximo4"]);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data2["maximo4"];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<!-- <tr>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder1)?$sinResponder1:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder2)?$sinResponder2:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder3)?$sinResponder3:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($sinResponder4)?$sinResponder4:'0'; ?></b>
					</td>
				</tr> -->
			</tbody>
		</table>
		<hr />
		<!-- ################################################# -->
		<h2>Fecha Proceso - Fecha Respuesta</h2>
		<table cellpadding="10" class="estadistica">
			<thead>
				<tr>
					<?php if ( !empty($tipoIncidencias) ): ?>
						<?php foreach( $tipoIncidencias as $tipoIncidencia ) : ?>
							<th style="width: 220px;"><?php echo $tipoIncidencia->nombre; ?></th>
						<?php endforeach; ?>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>Promedio:</p> 
							<div class="chart-inner">
								<?php if ( isset($data3['promedio1']) ): ?>
									<?php $minutos = explode(":",$data3['promedio1']); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data3['promedio1']; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['promedio2']) ): ?>
									<?php $minutos = explode(":",$data3['promedio2']); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data3['promedio2']; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['promedio3']) ): ?>
									<?php $minutos = explode(":",$data3['promedio3']); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data3['promedio3']; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['promedio4']) ): ?>
									<?php $minutos = explode(":",$data3['promedio4']); ?>
									<?php if ( $minutos[0] == 0 ): ?>
										<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<?php else: ?>
										<div class="color" data-color="<?php echo $minutos[0]; ?>"></div>
									<?php endif;?>
									<p><?php echo $data3['promedio4']; ?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>M&iacute;nimo:</p> 
							<div class="chart-inner">
								<?php if ( isset($data3['minimo1']) ): ?>
									<?php $minutos = explode(":",$data3['minimo1']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['minimo1'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['minimo2']) ): ?>
									<?php $minutos = explode(":",$data3['minimo2']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['minimo2'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['minimo3']) ): ?>
									<?php $minutos = explode(":",$data3['minimo3']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['minimo3'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['minimo4']) ): ?>
									<?php $minutos = explode(":",$data3['minimo4']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['minimo4'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<div class="chart-wrap">
							<p>M&aacute;ximo:</p> 
							<div class="chart-inner">
								<?php if ( isset($data3['maximo1']) ): ?>
									<?php $minutos = explode(":",$data3['maximo1']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['maximo1'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['maximo2']) ): ?>
									<?php $minutos = explode(":",$data3['maximo2']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['maximo2'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['maximo3']) ): ?>
									<?php $minutos = explode(":",$data3['maximo3']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['maximo3'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
					<td>
						<div class="chart-wrap">
							<div class="chart-inner">
								<?php if ( isset($data3['maximo4']) ): ?>
									<?php $minutos = explode(":",$data3['maximo4']);?>
									<div class="color" data-color="<?php echo $minutos[1]; ?>"></div>
									<p><?php echo $data3['maximo4'];?></p>
								<?php endif; ?>
							</div>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<b>#insidencias sin responder: <?php echo isset($data3['sinResponder1'])?$data3['sinResponder1']:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($data3['sinResponder2'])?$data3['sinResponder2']:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($data3['sinResponder3'])?$data3['sinResponder3']:'0'; ?></b>
					</td>
					<td>
						<b>#insidencias sin responder: <?php echo isset($data3['sinResponder4'])?$data3['sinResponder4']:'0'; ?></b>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>