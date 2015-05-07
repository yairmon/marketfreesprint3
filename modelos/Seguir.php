<?php
	/**
	* 	Esta clase se encarga de manejar los seguidores de los usuarios
	*/

require_once '../libs/rb.php';
require_once 'ConexionBD.php';

class Seguir 
{
	
	function __construct()
	{
		
	}


	/**
	 * [obtenerSeguidos description]
	 * Devuelve un array con los usuarios a quien el parametro de entrada esta siguiendo
	 * @param  [String] $nombreUsuario	[Es el nombre del usuario]
	 */
	public function obtenerSeguidos($nombreUsuario)
	{
		R::selectDatabase('default');
		$query = "SELECT DISTINCT u2.nombre_usuario FROM usuario AS u1 INNER JOIN seguir ON seguir.seguidor = u1.id INNER JOIN usuario AS u2 ON u2.id = seguir.seguido
					WHERE u1.nombre_usuario = '$nombreUsuario' AND seguir.estado = 1";
    	$seguidos = R::getAll($query);
    	R::close();

    	$salida = array();

    	foreach ($seguidos as $key) {
    		$salida[] = $key['nombre_usuario'];
    	}

    	return $salida;

	}

	/**
	 * [agregarSeguido description]
	 * Agrega un usuario a la lista de seguidos
	 * @param  [String] $nombreUsuario	[Es el nombre del usuario]
	 * @param  [String] $nombreSeguido	[Es el nombre del usuario al que se quiere seguir]
	 */
	public function agregarSeguido($nombreUsuario, $nombreSeguido)
	{
		R::selectDatabase('default');

		$usuarioSeguidor = R::findOne('usuario', 'nombre_usuario = ?',[$nombreUsuario]);
		$usuarioSeguido = R::findOne('usuario', 'nombre_usuario = ?',[$nombreSeguido]);

		
			
		$seguir = R::findOne('seguir', 'seguidor = ? AND seguido = ?',[$usuarioSeguidor->id,$usuarioSeguido->id]);
		if (empty($seguir)) {
			$seguir = R::dispense('seguir');
	    	$seguir->seguidor = $usuarioSeguidor->id;
	    	$seguir->seguido = $usuarioSeguido->id;	
		}else{
			$seguir->estado = 1;		
		}

    	R::store($seguir);
    	R::close();
    	return true;		
	}

	/**
	 * [dejarDeSeguir description]
	 * Elimina un usuario de la lista de seguidos
	 * @param  [String] $nombreUsuario	[Es el nombre del usuario]
	 * @param  [String] $nombreSeguido	[Es el nombre del usuario al que se quiere seguir]
	 */
	public function dejarDeSeguir($nombreUsuario, $nombreSeguido)
	{
		R::selectDatabase('default');

		$usuarioSeguidor = R::findOne('usuario', 'nombre_usuario = ?',[$nombreUsuario]);
		$usuarioSeguido = R::findOne('usuario', 'nombre_usuario = ?',[$nombreSeguido]);

    	$seguir = R::findOne('seguir', 'seguidor = ? AND seguido = ?',[$usuarioSeguidor->id,$usuarioSeguido->id]);
    	$seguir->estado = 0;
    	R::store($seguir);
    	R::close();

    	return true;

	}
}
?>