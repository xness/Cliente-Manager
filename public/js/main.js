$(document).on('ready', function(){
	
	// Altura content
	$('.content').css({'min-height':''+$(window).height()-171+'px'});
	
	// validation login
	$('.loginform form').on('submit', function(){
		var valido = true;
		var fields = $('input[type=text], input[type=password]',this);
		
		$.each(fields, function(key,el){
			if ( $.trim($(el).val()) == '' )
			{
				$(el).addClass('error');
				valido = false;
			} else {
				if ( $(el).attr('id') == 'email' )
				{
					if ( !validarEmail($(el).val()) ) {
						$(el).addClass('error');
						valido = false;
					}
				}
			}
		});
		
		$('input.error').first().focus();		
		
		return valido;	
	});
	
	$('.loginform form').on('keyup','#email,#password', function(){
		if ( $(this).hasClass('error') ) $(this).removeClass('error');
	});
	
	// validation form incidencia
	$('form#incidencia').on('submit', function(){
		var valido = true;
		var fields = $('input[type=text]:not(#telefono,#rut),select,textarea:not(#respuesta)',this);
		
		$.each(fields, function(key,el){
			if ( $.trim($(el).val()) == '' )
			{
				$(el).addClass('error');
				valido = false;
			} else {
				if ( $(el).attr('id') == 'email' )
				{
					if ( !validarEmail($(el).val()) )
					{
						$(el).addClass('error');
						valido = false;
					}
				}
			}
		});
		
		$('.error').first().focus();
		
		if ( valido ) $('div.mask').show();
		
		return valido;
	});
	
	$('form#incidencia').on('keyup','textarea', function(){
		if ( $(this).hasClass('error') ) $(this).removeClass('error');
		countMaxChars($(this));
	});
	
	$('form#incidencia').on('keyup','input[type=text]', function(){
		if ( $(this).hasClass('error') ) $(this).removeClass('error');
	});
	
	if ( $('form#incidenciaEdit select#empresa').val() != '' && $('form#incidencia select#tipoincidencia').val() != '') {
		$('div.botonaprobada').show();
	}
	
	$('form#incidencia').on('change','select', function(){		
		if ( $(this).hasClass('error') ) $(this).removeClass('error');
	});
	
	// funcion respuesta aprobadas
	$('div.botonaprobada').on('click', function(){
		loadContainerAprobadas();
	});
	
	$('div.respuestasAprobadas').on('click','.close', function(e){
		e.preventDefault();
		$('body').removeClass('fixed');
		$(this).parent().parent().fadeOut('slow');
	});
	
	// eventos dentro de respuestas aprobadas
	$(document).on('click', '.contenido_respuesta', function(){
		var el = $(this);
		$('textarea#respuesta').val($.trim(el.find('.textorespuesta').html()));
		$('div.respuestasAprobadas').stop().fadeOut('slow');
		$('body').removeClass('fixed');
		$('body,html').stop().animate({
			scrollTop : $("textarea#respuesta").position().top
		}, 500, 'swing');
	});
	
	// editar incidencia | respuesta | etc
	$('form#incidenciaEdit').on('submit', function(){
		var valido = true;
		var field = $('textarea#respuesta',this);
		if ( $.trim(field.val()) == '' )
		{
			field.addClass('error');
			valido = false;
		}
		
		$('.error').first().focus();
		
		if ( valido ) $('div.mask').show();
		
		return valido;
		
	});
	
	$('form#incidenciaEdit').on('keyup','textarea#respuesta', function(){
		if ( $(this).hasClass('error') ) $(this).removeClass('error');
		countMaxChars($(this));
	});
	
	// Estadisticas
	$('.chart-inner .color').each(function(){
		$(this).stop().animate({
			width : '+=' + $(this).data('color')
		},800);
	});
	
});

function validarEmail(str)
{
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
	
	if(!emailReg.test(str)) {  
        return false;
    } 
	
	return true;
}

function countMaxChars(str)
{
    var len = str.val().length;
    var cNum = 255 - len;
    if (len >= 255) {
      str.val(str.val().substring(0, 255));
      if ( cNum < 0 ) cNum = 0;
    } 
    
    $('#charNum').text(cNum);
}

function loadContainerAprobadas()
{
	var container = $('div.respuestasAprobadas .respuestasInner');
	var baseUrl = $('body').data('baseurl');
	if ( !container.is(':visible') )
	{
		container.empty();
		$.ajax({
			method : 'POST',
			url    :  baseUrl + 'respuestas/aprobadas',
			data   : { id : $('#empresa').val() , idtipo : $('#tipoincidencia').val() },
			beforeSend : function(){
				$('body,html').stop().animate({
					scrollTop : '0'
				},500, 'swing');
				$('body').addClass('fixed');
			},
			success : function(list){
				container.html(list)
				.parent()
				.fadeIn('slow');
			}
		});
	}
}

function filtrarByEmpresa()
{
	if ( $('#formE select').val() == 0 ) {
		window.location.href = $('body').data('baseurl') + 'incidencias/todas';
	} else {
		$('#formE').submit();
	}
}

function filtrarByFecha()
{
	$('#formF').submit();
}