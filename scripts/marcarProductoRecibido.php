<?php 
	require_once '../controladores/CoordinadorNotificacionComprador.php';
	require_once '../controladores/CoordinadorVenta.php';
	require_once '../libs/rb.php';
	require_once '../controladores/CoordinadorVogoo.php';

	# Esto redirecciona al index sin hacer ninguna accion 
	# En caso de que no haya iniciado sesión

	echo "<br>aqui1";

	if (!(isset($_SESSION['logueado'])))
	{
		header('Location: ../index.php');
		exit();
	}

	$idfact = $_GET['factura'];
	$fact = new CoordinadorVenta();
	$fact->cambiarEstado($idfact, "Recibido"); //el comprador recibe el pedido

	$notificaAVendedor = new CoordinadorNotificacionComprador();
	$nVendedor = $_GET['vendedor'];
	$nProducto = $_GET['producto'];
	$notificaAVendedor->notificaVendedor($nVendedor,$nProducto);

	$nUsuario = $_SESSION['user'];
	$vogoo = new CoordinadorVogoo();
	$vogoo->agregarProducto($nUsuario,$idfact);

	echo exec();
	header('Location: ../vogoo/cronlinks.php');

 ?>