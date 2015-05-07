<?php
require_once '../modelos/ValidarComision.php';
require_once 'CoordinadorNotificacion.php';

if (isset($_POST['guardar'])) 
{
	$nuevaComision = $_POST['porcentaje'];		
	$CoordinadorComision = new CoordinadorComision();
	$CoordinadorComision->coordinadorComision($nuevaComision);

}

Class CoordinadorComision
{
	private $validaComision;

	/**
	 * [__construct description]
	 */
	function __construct()
	{
		$this->validaComision = new ValidarComision();
	}

	public function coordinadorComision($comision)
	{
		$this->validaComision->validaComision($comision);
		$errorComision = $this->validaComision->getResponseComision();
		if (!empty($errorComision)) {
			session_start();
			$_SESSION['errorComision'] = $errorComision;
			header('Location: ../vistas/comision.php');		
		}
		else{
			session_start();
			$_SESSION['exitoComision'] = "Edicion exitosa";
			unset($_SESSION['errorComision']);

			# El administridor le envia correo a los vendedores de que se ha modificado la comision
			$notifica = new CoordinadorNotificacion();
			$notifica->notificaVendedorCambioComision($comision);

			header('Location: ../vistas/comision.php');
		}
	}
}
?>