<?php 
	require_once '../controladores/CoordinadorSeguir.php';

	# Esto redirecciona al index sin hacer ninguna accion 
	# En caso de que no haya iniciado sesión

	$nombreUsuario = $_GET['usuarioSeguidor'];
	$nombreSeguido = $_GET['usuarioSeguido'];

	$coordinadorSeguir = new CoordinadorSeguir();
	$exito = $coordinadorSeguir->dejarDeSeguir($nombreUsuario, $nombreSeguido); 
	if($exito)
		header('Location: ../vistas/productos.php?noSeguir='.$nombreSeguido);
	else 
		header('Location: ../vistas/productos.php?noSeguir=error');

 ?>