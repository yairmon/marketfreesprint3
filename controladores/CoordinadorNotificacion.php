<?php
require_once '../modelos/Notificacion.php';
require_once '../libs/rb.php';

/**
 * Esta clase se encarga de manejar los correos que envia
 * el admin
 */

Class CoordinadorNotificacion
{
	private $notifica;

	/**
	 * [__construct description]
	 */
	function __construct()
	{
		$this->notifica = new Notificacion();
	}

	/**
	 * [enviaMail description]
	 * @param  [string] $correo    [description]
	 * @param  [string] $asunto    [description]
	 * @param  [string] $contenido [description]
	 */
	public function enviaMail($correo, $asunto, $contenido)
	{
		$this->notifica->enviarEmail($correo, $asunto, $contenido);
	}

	/**
	 * [notificaVendedorAprobacion description]
	 * Enviar al usuario vendedor la notificacion de que se ha aprobado una compra
	 * @param  [int] $idFactura 	[Es el id de la factura]
	 */
	public function notificaVendedorAprobacion($idFactura)
	{
		$correo = "";
		$asunto = "Aprobacion de pedido";
		$contenido = "";

		try
		{
			R::selectDatabase('default');
			$nombreVendedor = R::getCell( "SELECT producto.usuario_username FROM producto 
				INNER JOIN detalle ON producto.id = detalle.id_producto
				INNER JOIN factura ON factura.id = detalle.id_factura
				WHERE factura.id = $idFactura" );
			$correoVendedor = R::getCell( "SELECT usuario.email FROM usuario WHERE usuario.nombre_usuario = '$nombreVendedor' LIMIT 1" );
			/*
			$apellido = R::getCell( "SELECT usuario.apellidos FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			$usuario = R::getCell( "SELECT usuario.nombre_usuario FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			R::close();

			#$comprador = $nombre . " " . $apellido . " (Usuario: " . $usuario . ")";
			*/
			$contenido = "<p>El administrador ha aprobado un pedido a su nombre
				<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";

			$this->notifica->enviarEmail($correoVendedor,$asunto,$contenido);
			

		}catch(Exception $e){}

	}

	/**
	 * [notificaCompradorAprobacion description]
	 * Enviar al usuario comprador la notificacion de que se ha aprobado una compra
	 * @param  [int] $nombreUsuario	[Es el nombre del usuario comprador]
	 */
	public function notificaCompradorAprobacion($nombreUsuario)
	{
		$correo = "";
		$asunto = "Aprobacion de pedido";
		$contenido = "";

		try
		{
			R::selectDatabase('default');
			$correoComprador = R::getCell( "SELECT usuario.email FROM usuario 
				WHERE usuario.nombre_usuario = '$nombreUsuario'" );

			#$correoVendedor = R::getCell( "SELECT usuario.email FROM usuario WHERE usuario.nombre_usuario = '$nombreVendedor' LIMIT 1" );

			$contenido = "<p>El administrador ha aprobado un pedido que usted ha realizado
				<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";

			$this->notifica->enviarEmail($correoComprador,$asunto,$contenido);
			

		}catch(Exception $e){}

	}

	/**
	 * [notificaVendedorCambioComision description]
	 * Enviar a los usuarios vendedores la notificacion de que se ha cambiado el valor de la comision
	 * @param  [double] $valorComision	[Es el valor de la nueva comision]
	 */
	public function notificaVendedorCambioComision($valorComision)
	{
		$correo = "";
		$asunto = "Cambio de comision";
		$contenido = "";

		try
		{
			R::selectDatabase('default');
			$usuariosVendedores = R::getAll( "SELECT DISTINCT usuario.email FROM usuario INNER JOIN producto ON producto.usuario_username = usuario.nombre_usuario" );
			$destinos = array();
			
			foreach ($usuariosVendedores as $key) {
				$destinos[] = $key['email'];
			}


			$contenido = "<p>El administrador ha modificado el valor de la comision, ahora tiene un valor de <b><i>$valorComision</i></b>
				<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";

			$this->notifica->enviarVariosEmail($destinos,$asunto,$contenido);

		}catch(Exception $e){}

	}




}
//$coordinador = new CoordinadorNotificacion();
//$coordinador->enviaMail("vazuluagab@gmail.com", "prueba controlador notificacion", "esto es una prueba");
?>