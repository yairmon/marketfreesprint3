<?php 
	require_once '../controladores/CoordinadorVogoo.php';

	# Esto redirecciona al index sin hacer ninguna accion 
	# En caso de que no haya iniciado sesión


session_start();
	$nUsuario = $_SESSION['user'];
	$vogoo = new CoordinadorVogoo();
	$vogoo->verRecomendados($nUsuario);

 ?>