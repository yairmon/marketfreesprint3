<?php
	/**
	* 	Esta clase se encarga de manejar los seguidores de los usuarios
	*/

require_once '../modelos/Seguir.php';

class CoordinadorSeguir 
{
	private $modeloSeguir;
	
	function __construct()
	{
		$this->modeloSeguir = new Seguir();
	}

	/**
	 * [obtenerSeguidos description]
	 * Devuelve un array con los usuarios a quien el parametro de entrada esta siguiendo
	 * @param  [String] $nombreUsuario	[Es el nombre del usuario]
	 */
	public function obtenerSeguidos($nombreUsuario)
	{
		return $this->modeloSeguir->obtenerSeguidos($nombreUsuario);
	}

	/**
	 * [agregarSeguido description]
	 * Agrega un usuario a la lista de seguidos
	 * @param  [String] $nombreUsuario	[Es el nombre del usuario]
	 * @param  [String] $nombreSeguido	[Es el nombre del usuario al que se quiere seguir]
	 */
	public function agregarSeguido($nombreUsuario, $nombreSeguido)
	{
		return $this->modeloSeguir->agregarSeguido($nombreUsuario, $nombreSeguido);
	}

	/**
	 * [dejarDeSeguir description]
	 * Elimina un usuario de la lista de seguidos
	 * @param  [String] $nombreUsuario	[Es el nombre del usuario]
	 * @param  [String] $nombreSeguido	[Es el nombre del usuario al que se quiere seguir]
	 */
	public function dejarDeSeguir($nombreUsuario, $nombreSeguido)
	{
		return $this->modeloSeguir->dejarDeSeguir($nombreUsuario, $nombreSeguido);
	}
}
?>