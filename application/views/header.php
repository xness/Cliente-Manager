<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>
	<link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/mod.css">
	<!-- Scripts -->
	<script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/js/vendor/jquery-migrate-1.2.1.min.js"></script>
</head>
<body data-baseurl="<?php echo base_url(); ?>">
	<div class="header">
		<div class="header_content">
            <div class="logo">
            	<?php if ( isset($rol) && $rol != 1 ): ?>
            		<a href="<?php echo base_url(); ?>">
            			<img src="<?php echo base_url();?>public/images/empresa/<?php echo $imagenEmpresa; ?>" alt="" />
            		</a>
            	<?php else: ?>
            		<a href="<?php echo base_url(); ?>">
            			<img src="<?php echo base_url() . "public/images/logo_default.png"; ?>" alt="" />
            		</a>
            	<?php endif;?>
            </div>
            <div class="separador"></div>
            <div class="title_head">
                servicio al cliente manager
            </div>
            <?php if ( $this->session->userdata("is_logged_in") ): ?>
	            <div class="user">
	                <div class="icono">
	                    <img src="<?php echo base_url() . "public/" . $imagen; ?>" />
	                </div>
	                <div class="rol">
	                    <?php echo htmlentities($nombre, ENT_QUOTES | ENT_IGNORE, "UTF-8"); ?>
	                </div>
	                <div class="salir">
	                   |   &nbsp;&nbsp;&nbsp;<a href="<?php echo base_url() . "inicio/logout"; ?>">Salir</a>
	                </div>
	            </div>
	        <?php endif; ?>
        </div>
    </div>
	<!-- Main content -->