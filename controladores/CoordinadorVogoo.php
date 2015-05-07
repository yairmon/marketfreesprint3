<?php
require_once '../modelos/Notificacion.php';
require_once '../libs/rb.php';
require_once '../modelos/ConexionBD.php';

/**
 * Esta clase se encarga de manejar los correos que envia  el vendedor
 */

Class CoordinadorVogoo
{

	/**
	 * [__construct description]
	 */
	function __construct()
	{
	}

	/**
	 * [agregarProducto description]
	 * Se encarga de agregar los productos en la tabla de vogoo para las recomendaciones
	 * @param  [int] $nUsuario [Nombre del usuario comprador]
	 * @param  [int] $idFactura [Id de la factura]
	 */
	public function agregarProducto($nUsuario,$idfact)
	{

		R::selectDatabase('default');

		$usuario = R::findOne('usuario', 'nombre_usuario = ?',[$nUsuario]);
		$idUsuario = $usuario->id;

		$productos = R::getAll( "SELECT DISTINCT producto.id, producto.categoria_id FROM producto INNER JOIN detalle ON detalle.id_producto = producto.id
					INNER JOIN factura ON factura.id = detalle.id_factura WHERE factura.id = $idfact" );
		

		foreach ($productos as $key) {
			$productosID = $key['id'];
			$categoriaID = $key['categoria_id'];

			include("../vogoo/vogoo.php");
			$vogoo->set_rating($idUsuario,$productosID,1.0,$categoriaID);

		}

	}

	/**
	 * [verRecomendados description]
	 * Se encarga de mostrar los productos recomendados para este usuario
	 * @param  [int] $nUsuario [Nombre del usuario comprador]
	 */
	public function verRecomendados($nUsuario)
	{

		R::selectDatabase('default');

		$usuario = R::findOne('usuario', 'nombre_usuario = ?',[$nUsuario]);
		$idUsuario = $usuario->id;

		include("../vogoo/items.php");
		$items = $vogoo_items->member_get_recommended_items($nUsuario);

echo "<br>>>>>>>>>>>>>>>>>>items<br>";
		if(!(empty($items))){

			foreach ($items as $key) {
				echo "<br>Item = $key";
			}
		}

	}



}




?>