<?php
require_once '../modelos/Notificacion.php';
require_once '../libs/rb.php';
require_once '../modelos/ConexionBD.php';

/**
 * Esta clase se encarga de manejar los correos que envia  el usuario Comprador
 */

Class CoordinadorNotificacionComprador
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
	 * [notificaVendedor description]
	 * Enviar al usuario vendedor la notificacion de que ya se ha recibido el producto
	 * @param  [String] $nVendedor 	[Es el nombre de usuario del vendedor]
	 * @param  [String] $nProducto 	[Es el nombre del producto]
	 */
	public function notificaVendedor($nVendedor,$nProducto)
	{
		$correo = "";
		$asunto = "Confirmacion de que la compra ha llegado a su destino";
		$contenido = "";
		$listaProductos = "";

		try
		{

			R::selectDatabase('default');
			$correo = R::getCell( "SELECT email FROM usuario WHERE nombre_usuario = '$nVendedor' LIMIT 1" );
			echo "<br>El vendedor que me dieron es = $nVendedor"."<br>";
			echo "<br>El correo que me dieron es = '$correo'"."<br>";
			R::close();
			$contenido = "Se ha confirmado que el producto <i>$nProducto</i>, ha llegado a su destino.<p><i>Atentamente: Equipo de MarketFree.</i>";

			$this->notifica->enviarEmail($correo,$asunto,$contenido);


		}catch(Exception $e){}

	}

	/**
	 * [notificaAdministradorCancelacion description]
	 * Enviar al usuario administrador la notificacion de que se ha cancelado un producto
	 * @param  [int] $idFactura 	[Es el id de la factura]
	 * @param  [String] $nProducto 	[Es el nombre del producto]
	 */
	public function notificaAdministradorCancelacion($idFactura,$nProducto)
	{
		$correo = "";
		$asunto = "Cancelacion de un producto";
		$contenido = "";

		try
		{

			R::selectDatabase('default');

			$administradores = R::getAll( "SELECT email FROM usuario INNER JOIN perfil ON perfil.id = usuario.tipo_perfil
				WHERE perfil.permiso_gestionar_usuarios = 1 AND perfil.permiso_gestionar_perfiles = 1" );
			$nombre = R::getCell( "SELECT usuario.nombre,usuario.apellidos,usuario.nombre_usuario FROM usuario 
				INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			$apellido = R::getCell( "SELECT usuario.apellidos FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			$usuario = R::getCell( "SELECT usuario.nombre_usuario FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );

			R::close();


			$correos = array();

			foreach ($administradores as $key) {
				$correos[] = $key["email"];
			}


			$comprador = $nombre . " " . $apellido . " (Usuario: " . $usuario . ")";

			$contenido = "El usuario <i>$comprador</i>, ha cancelado la compra del producto <i>$nProducto</i>.<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";
			
			$this->notifica->enviarVariosEmail($correos,$asunto,$contenido);
			

		}catch(Exception $e){}

	}

	/**
	 * [notificaVendedorCancelacion description]
	 * Enviar al usuario vendedor la notificacion de que se ha cancelado un producto
	 * @param  [int] $idFactura 	[Es el id de la factura]
	 * @param  [String] $nProducto 	[Es el nombre del producto]
	 */
	public function notificaVendedorCancelacion($idFactura,$nProducto)
	{
		$correo = "";
		$asunto = "Cancelacion de un producto";
		$contenido = "";

		try
		{

			R::selectDatabase('default');

			$vendedor = R::getCell( "SELECT usuario.email FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura" );
			$nombre = R::getCell( "SELECT usuario.nombre,usuario.apellidos,usuario.nombre_usuario FROM usuario 
				INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			$apellido = R::getCell( "SELECT usuario.apellidos FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			$usuario = R::getCell( "SELECT usuario.nombre_usuario FROM usuario INNER JOIN factura ON factura.id_cliente = usuario.id
				WHERE factura.id = $idFactura LIMIT 1" );
			R::close();

			$comprador = $nombre . " " . $apellido . " (Usuario: " . $usuario . ")";

			$contenido = "El usuario <i>$comprador</i>, ha cancelado la compra del producto <i>$nProducto</i>.
				<p><i>Atentamente: Equipo de MarketFree.</i>
				<p><img src='https://scontent-dfw.xx.fbcdn.net/hphotos-xfp1/v/t1.0-9/11204889_796310270499350_215609620662733233_n.jpg?oh=de7f27b60d444d8010a60b585d3142b8&oe=55E4B4E5'>";
			
			$this->notifica->enviarEmail($vendedor,$asunto,$contenido);
			

		}catch(Exception $e){}

	}
}




?>