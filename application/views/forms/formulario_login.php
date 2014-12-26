<div class="content loginform">
	<div class="title">
		LOGIN
    </div>
    <form action="<?php echo base_url() . "inicio/form_validation";?>" method="POST">
		<?php echo validation_errors(); ?>
		<p>
			Email : <input type="text" name="email" value="<?php echo set_value("email"); ?>" id="email" />
		</p>
		<p>
			Password : <input type="password" name="password" id="password" />
		</p>
		<p>
			<input type="submit" name="submit" value="Login" />
		</p>
	</form>
</div>