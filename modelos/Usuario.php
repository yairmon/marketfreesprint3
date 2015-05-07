<?php
	/**
	* 
	*/

	require_once '../libs/rb.php';
	require_once 'ConexionBD.php';

	class Usuario 
	{
		
		function __construct()
		{
			
		}

		public function registrarUsuario($documento, $nombre, $apellidos, $email, 
			$nombreUsuario, $password, $ID, $estado)
		{
			R::selectDatabase('default');
        	$usuario = R::dispense('usuario');
        	$usuario->documento = $documento;
        	$usuario->nombre = $nombre;
        	$usuario->apellidos = $apellidos;
        	$usuario->email = $email;
        	$usuario->nombreUsuario = $nombreUsuario;
        	$usuario->password = $password;
        	$usuario->tipo_perfil = $ID;
        	$usuario->estado = 1;
        	R::store($usuario);
        	R::close();
		}

		/*public function asignarPerfil($nombrePerfil, $documento)
		{
			R::selectDatabase('default');
        	$perfil = R::findOne('perfil','nombre =?',[$nombrePerfil]);
        	$usuario = R::findOne('usuario','documento =?',[$documento]);
        	$usuario->tipoPerfil = $perfil['id'];
        	R::store($usuario);
        	R::close();
		}*/

		public function modificarUsuario($documento,$documentoN, $nombre, $apellidos, $email, 
			$nombreUsuario, $perfil, $estado)
		{
			R::selectDatabase('default');
			$where = array();
			$where[] = $documento;
        	$usuario = R::findOne('usuario', 'documento = ?',$where);
        	$usuario->documento = $documentoN;
        	$usuario->nombre = $nombre;
        	$usuario->apellidos = $apellidos;
        	$usuario->email = $email;
        	$usuario->nombreUsuario = $nombreUsuario;
        	$usuario->tipoPerfil = $perfil;
        	$usuario->estado = $estado;
        	R::store($usuario);
        	R::close();
		}

		public function modificarMiUsuario($documento, $nombre, $apellidos, $email, 
			$nombreUsuario, $nombreUsuarioN)
		{
			R::selectDatabase('default');
			$where = array();
			$where[] = $nombreUsuario;
        	$usuario = R::findOne('usuario', 'nombre_usuario = ?',$where);
        	$usuario->documento = $documento;
        	$usuario->nombre = $nombre;
        	$usuario->apellidos = $apellidos;
        	$usuario->email = $email;
        	$usuario->nombreUsuario = $nombreUsuarioN;
        	R::store($usuario);
        	R::close();
		}

		public function buscarUsuario($parametro)
		{
			R::selectDatabase('default');

			$where = array();
			$where[] = $parametro;
        	if (ctype_digit(($parametro))) 
        	{
				$usuario = R::findOne('usuario', 'documento = ?',$where);
				R::close();
				return $usuario;
        	}
        	else if(ctype_alnum($parametro))
        	{
        		$usuario = R::findOne('usuario', 'nombre_usuario = ?',$where);
        		R::close();
				return $usuario;
        	}
        	else{
        		$usuario = R::findOne('usuario', 'email = ?',$where);
        		R::close();
        		return $usuario;
        	}
		}

		/*public function buscarUsuarioE($email)
		{
			R::selectDatabase('default');
			$usuario = R::findOne('usuario', 'email = ?',[$parametro]);
        	R::close();
        	return $usuario;

		}

		public function consultarUsuario($email)
		{
			R::selectDatabase('default');
			$usuario = R::findOne('usuario', 'email = ?',[$email]);
        	R::close();
			return $usuario;
		}*/

		public function darDeBajaUsuario($documento)
		{
			$where = array();
			$where[] = $documento;
			R::selectDatabase('default');
			$usuario = R::findOne('usuario', 'documento = ?',$where);
			$usuario->estado = false;
			R::store($usuario);
			R::close();
		}

		public function getUsuarios()
		{
			R::selectDatabase('default');
        	$usuarios = R::findAll('usuario');
        	R::close();
        	return $usuarios;
		}

		public function getAdmin()
		{
			R::selectDatabase('default');
			$admin = R::findAll('usuario', 'tipo_perfil = 1');
			R::close();
			return $admin;
		}

		public function cambiarPass($username, $password)
		{
			$where = array();
			$where[] = $username;
			R::selectDatabase('default');
			$usuario = R::findOne('usuario', 'nombre_usuario = ?',$where);
			$usuario->password = $password;
			R::store($usuario);
			R::close();
		}
	}

	    //$user = new Usuario();
	    //$admins = $user->getAdmin();
	    //foreach ($admins as $key) {
	    //	echo $key['email'];
	    //}
	//  $user->registrarUsuario(116264525, "Juan", "Velasquez", "Velasquez94@hotmail.com", "juseve","j89s1994","Admin");
	//  $user->asignarPerfil("Gasimba",116264525);
	   // $a = $user->buscarUsuario("116264525");
	  // echo $a;
?>