<?php
require_once '../modelos/Notificacion.php';
require_once '../libs/rb.php';

/**
 * Esta clase se encarga de manejar los correos que envia  el vendedor
 */

Class CoordinadorNotificacionVendedor
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
	 * [notificarComprador description]
	 * Enviar al usuario comprador la notificacion de que ya se ha enviado el producto
	 * @param  [int] $idFactura
	 */
	public function notificarComprador($idFactura)
	{
		$correo = "";
		$asunto = "Confirmacion de envio de compra";
		$contenido = "";
		$listaProductos = "";

		try
		{

			R::selectDatabase('default');
			$correo = R::getCell( "SELECT usuario.email FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id WHERE factura.id = $idFactura LIMIT 1" );
			$query = "SELECT producto.nombre FROM producto INNER JOIN detalle ON detalle.id_producto = producto.id
					INNER JOIN factura ON factura.id = detalle.id_factura WHERE factura.id = $idFactura";
			$productos =   R::getAll( $query );

			foreach ($productos as $key) 
			{
				$listaProductos = $listaProductos.$key['nombre']."<br>";
			}

			R::close();
			$contenido = "Se ha confirmado la compra que ha realizado, los siguientes productos se han enviado:<p>".$listaProductos."
				<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";
			echo "El contenido = ".$contenido."<br>";
			#echo "<br> Estamos en la clase CoordinadorNotificacionVendedor <br>";
			$this->notifica->enviarEmail($correo,$asunto,$contenido);


		}catch(Exception $e){}

	}

	/**
	 * [notificarComprador description]
	 * Enviar a los usuarios compradores que estan siguiendo al usuario vendedor, la notificiacion de que se ha creado un nuevo producto
	 * @param  [String] $nombreProducto [Nombre del producto nuevo]
	 * @param  [String] $nombreVendedor [Nombre del usuario vendedor]
	 * @param  [String] $url  			[La imagen del producto]
	 */
	public function notificarProductoNuevoComprador($nombreProducto,$nombreVendedor,$url)
	{
		$correo = "";
		$asunto = "Un nuevo producto";
		$contenido = "";
		$listaProductos = "";

		try
		{

			R::selectDatabase('default');
			$seguidores = R::getAll( "SELECT DISTINCT u1.email FROM usuario AS u2 
				INNER JOIN seguir ON seguir.seguido = u2.id
				INNER JOIN usuario AS u1 ON seguir.seguidor = u1.id
			 WHERE u2.nombre_usuario = '$nombreVendedor' AND seguir.estado = 1" );
			
			$correos = array();

			foreach ($seguidores as $key) 
				$correos[] = $key['email'];

			R::close();
			$contenido = "El usuario <i>$nombreVendedor</i> ha publicado un nuevo producto:<b><i>".$nombreProducto."</i></b>
				<br><img src = '$url' height='300'>
				<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";
			echo "El contenido = ".$contenido."<br>";
			#echo "<br> Estamos en la clase CoordinadorNotificacionVendedor <br>";
			$this->notifica->enviarVariosEmail($correos,$asunto,$contenido);


		}catch(Exception $e){}

	}
}




?>