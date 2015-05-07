<?php 
	require_once '../controladores/CoordinadorVogoo.php';

	# Esto redirecciona al index sin hacer ninguna accion 
	# En caso de que no haya iniciado sesión

	session_start();

	if (!(isset($_SESSION['logueado'])))
	{
		header('Location: ../index.php');
		exit();
	}



	$nUsuario = $_SESSION['user'];
#	$nUsuario = "yairmon";
	$vogoo = new CoordinadorVogoo();
	$recomendados = $vogoo->verRecomendados($nUsuario);
	foreach ($recomendados as $key) {
		echo "<br>array = " . $key;
	}
	echo "<br>_Esto es el tama&ntilde;o->".count($recomendados);

 ?>