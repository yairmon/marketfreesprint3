<?php
require_once '../modelos/Venta.php';
require_once '../modelos/Carrito.php';
require_once '../modelos/Comision.php';
require_once '../modelos/Usuario.php';
require_once '../modelos/ProductoBuscar.php';
require_once 'CoordinadorNotificacionVendedor.php';
require_once 'CoordinadorNotificacionComprador.php';
require_once 'CoordinadorNotificacion.php';

session_start();

if (isset($_GET['edit'])) {
	$idFactura = $_GET['edit'];
	$factura = new Venta();
	$facturaRegistro = $factura->getFactura($idFactura);
	header('Location: ../vistas/editarPedido.php?id_factura='.$facturaRegistro['id'].'&estado='
		.$facturaRegistro['estado']);
}

if(isset($_POST['guardar']))#Se da click en el boton guardar estado
{
	$_SESSION['exitoCambiarEstadoPedido'] = 0; #Se setea una variable para usarla en el modal
	$facturita = $_POST['idFactura'];
	$nuevoEstado = $_POST['group1'];
	$actualizaEstado = new CoordinadorVenta();
	$actualizaEstado->cambiarEstado($facturita, $nuevoEstado);
	header('Location: ../vistas/visualizarPedido.php');
	$actualizaEstado->actualizarCantidad($facturita);
}

if (isset($_GET['down'])) 
{
	$_SESSION['exitoCancelar'] = 0; # Se setea solo cuando pueda cancelar una compra, es decir cuando el estado de la misma permita esta accion
	$idfact = $_GET['down'];
	$nombreProduct = $_GET['product'];
	$estadoProduct = $_GET['estado'];
	echo "<br>Aqui en cancelar la compra: El estado: " . $estadoProduct;
	if($estadoProduct == "pendiente")
	{
		# Notificar al administrador que el producto ha sido cancelado
		$notificarAdmin = new CoordinadorNotificacionComprador();
		$notificarAdmin->notificaAdministradorCancelacion($idfact,$nombreProduct);
	}else #if($estadoProduct == "aprovado")
	{
		# Notificar al vendedor que el producto ha sido cancelado
		$notificarVendedor = new CoordinadorNotificacionComprador();
		$notificarVendedor->notificaVendedorCancelacion($idfact,$nombreProduct);
	}

	$producto = new ProductoBuscar();
	$miProducto = $producto->getProductoPorNombre($nombreProduct);
	$idProduct = $miProducto['id'];
	$fact = new CoordinadorVenta();
	$fact->cancelar($idfact, $idProduct);

;
}

if(isset($_POST['comprar']))
{
	$_SESSION['exitoComprar'] = 0; #Seteo una variable de sesssion con cualquier valor, para usarla en las vistas para mostrar el modal de exito
	$fact = new Venta();
	$facturacion = new CoordinadorVenta();
	$comision = new Comision();
	$productoCarrito = new Carrito();
	$total = $_POST['total'];
	$cliente = $_POST['idCliente'];
	$comisionActual = $comision->mostrarComision();
	foreach ($comisionActual as $key) {
		$laComision = $key['id']; //identificador de la comision actual
	}
	$facturacion->factura($cliente, $laComision, $total);
	$idFactura = $fact->getUltimaFactura();
	foreach ($_SESSION['carrito'] as $key) {
		$producto = $productoCarrito->obtenerProducto($key["nombre"]);
		$idProductoCarrito = $producto['id'];
		$cantidad = $key["cantidad"];
		$facturacion->detalle($idProductoCarrito, $cantidad, $idFactura);
	}
	unset($_SESSION['carrito']); #Si se da click en el botón Confirmar Pago, entonces el carrito se vacea de manera automática
	header('Location: ../vistas/estadoCompras.php');

	//Se notifica al administrador que se ha realizado una venta
	$notificar = new CoordinadorNotificacion();
	$administrador = new Usuario();
	$admin = $administrador->getAdmin();
	$asunto = "Compra Realizada";
	$contenido = "Una compra ha sido realizada y debe ser aprobada";
	foreach ($admin as $key) {
		$correo = $key['email']; //correo del administrador de la aplicacion
	}	
	$notificar->enviaMail($correo, $asunto, $contenido); //envia el email al admin
}

if (isset($_GET['aprobar'])) {
	$_SESSION['exitoAprobar'] = 0; #Seteo una variable de session para usarla como condicion en un modal de Facturas Admin
	$idfact = $_GET['aprobar'];
	$nombreCliente = $_GET['cliente'];

	# Notificar al vendedor que una compra ha sido aprobada
	$notificarVendedor = new CoordinadorNotificacion();
	$notificarVendedor->notificaVendedorAprobacion($idfact);
	$notificarVendedor->notificaCompradorAprobacion($nombreCliente);

	$fact = new CoordinadorVenta();
	$fact->cambiarEstado($idfact, "aprobado"); //el admin aprueba las compras

	header('Location: ../vistas/facturasAdmin.php');
}

Class CoordinadorVenta
{
	private $ventaModelo;

	/**
	 * [__construct description]
	 */
	function __construct()
	{
		$this->ventaModelo = new Venta();
	}

	/**
	 * [cambiarEstado description]
	 * @param  [type] $id     [id de la factura que se actuliza]
	 * @param  [type] $estado [puede cambiar el estado a "enviado","recibido","aprobado"...]
	 */
	public function cambiarEstado($id, $estado)
	{
		$this->ventaModelo->setEstado($id, $estado);
		#Si el estado es verdadero (Que se aprobo la compra entonces se le envia un correo al comprador notificando)
		if($estado == "enviado"){
			$notifica = new CoordinadorNotificacionVendedor();
			$notifica->notificarComprador($id);
		}
	}

	/**
	 * [actualizarCantidad description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function actualizarCantidad($id)
	{
		$this->ventaModelo->actualizarStock($id);
	}

	/**
	 * [cancelar description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function cancelar($idFactura, $idProducto)
	{
		$this->ventaModelo->cancelarCompra($idFactura, $idProducto);
		header('Location: ../vistas/estadoCompras.php');
	}

	/**
	 * [factura description]
	 * @param  [type]
	 * @param  [type]
	 * @param  [type]
	 * @return [type]
	 */
	public function factura($cliente, $comision, $total)
	{
		$this->ventaModelo->crearFactura($cliente, $comision, $total);
	}

	/**
	 * [detalle description]
	 * @param  [type]
	 * @param  [type]
	 * @param  [type]
	 * @return [type]
	 */
	public function detalle($producto, $cantidad, $factura)
	{
		$this->ventaModelo->guardarDetalleFactura($producto, $cantidad, $factura);
	}
}

?>