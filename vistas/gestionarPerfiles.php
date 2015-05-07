<?php 
include_once '../scripts/gestionarPerfiles.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../assets/materialize/css/materialize.min.css" type="text/css">
	<link rel="stylesheet" href="../assets/css/styles.css" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Dancing+Script:400,700' rel='stylesheet' type='text/css'/>
	<script src="../assets/jquery-2.1.3.min.js"></script>
	<script src="../assets/materialize/js/materialize.min.js"></script>
	<script src="../assets/js/styles.js"></script>
	<title>Desarrollo2</title>
</head>
<body>
	<?php if ((isset($_SESSION['logueado']))){
      include("barraMenu.php");
  }else{ header('Location: ../index.php');}?>    
	<div class="container">	
  <br>	
		<div class="row">
      <h4>Perfiles</h4>
      <form action="../controladores/CoordinadorPerfil.php" method="post">
        <div class="row">
         <div class="input-field col s6 tooltipped" data-position="right" data-tooltip="Presiona enter para buscar" >
              <i class="mdi-action-search prefix"></i>
              <input id="nombreP" type="text" class="validate" name="nombreP">
              <label for="nombreP">Ingresa un nombre para buscar</label>
              <input type="submit" class="btn col s3 offset-s1" name="buscarP" value="Buscar" style='display:none;'>
            </div>
        </div>
      </form>
    </div>
		<div class="row">
    <!-- EDITAR PERFILES -->
		<table class="hoverable responsive-table centered indigo lighten-5">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Gestionar Usuarios</th>
					<th>Vender</th>
					<th>Gestionar Perfiles</th>
				</tr>
			</thead>
			<tbody>				
				<?php foreach ($_SESSION['perfiles'] as $key) {
					?> <tr>
					<td> <?php echo $key['nombre'];?> </td>
					<td> <?php echo $key['permiso_gestionar_usuarios'];?> </td>
					<td> <?php echo $key['permiso_vender'];?> </td>      
					<td> <?php echo $key['permiso_gestionar_perfiles'];?> </td>
					<td><a href="../controladores/CoordinadorPerfil.php?edit=<?php echo $key["nombre"] ?>" class="btn-flat tooltipped" name="edit" id="edit" data-position="right" data-tooltip="Editar"><i class="mdi-image-edit"></i></a></td> <?php
					?> </tr> <?php 
				} ?>
			</tbody>
		</table><!-- final editar perfiles -->
		</div>
		<div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
			<a class="btn-floating btn-large waves-effect waves-light red right modal-trigger tooltipped" data-position="left" data-tooltip="Nuevo Perfil" href="#modal"><i class="mdi-content-add"></i></a>
		</div>
    <!-- CREAR PERFILES -->
		<div class="valign-wrapper">
			<div class="col s12 m8 offset-m2 l4 offset-l3 valign">
				<div id="modal" class="modal modalLogin">
					<div class="card login">
						<div class="card-content">
							<span class="card-title teal-text">Crear Perfil</span> 
              <!-- Formulario por metodo post --> 
							<form action="../controladores/CoordinadorPerfil.php" method="post"> 
              <!-- Muestro errores --> 
								<?php if (isset($_SESSION['eRegistroPerfil'])) {	?>					
								<div class="card">
									<div class="card-content">
									<?php foreach ($_SESSION['eRegistroPerfil'] as $key) { ?>
										<p><?php echo $key; ?></p>
									<?php } ?>
									</div>
								</div>        
								<?php
                  unset($_SESSION['eRegistroPerfil']);  
                  } ?>  
								<div class="input-field col m4 l2 tooltipped" data-position="bottom" data-tooltip="Este campo es requerido, 4-30 caracteres alfabeticos">
									<input id="nombre" type="text" name="nombre"  required maxlength="30">
									<label for="nombre">Nombre</label>
								</div>
								<div class="tooltipped" data-position="bottom" data-tooltip="Selecciona minimo un permiso">						
								<h6>Permisos:</h6>
								<p>
    								<input type="checkbox" id="permiso1" name="permiso1" >
    								<label for="permiso1">Gestionar Usuarios</label>
  								</p>
   								<p>
    								<input type="checkbox" id="permiso2" name="permiso2"/>
    								<label for="permiso2">Vender</label>
  								</p>
  								<p>
    								<input type="checkbox" id="permiso3" name="permiso3"/>
    								<label for="permiso3">Gestionar Perfiles</label>
  								</p>
  								<br>
								<input class="btn-flat orange-text" type="submit" value="Crear" name="crear">
								</div>
							</form>                     
						</div>
					</div>
				</div>
			</div>    
		</div><!-- FIN CREAR PERFILES -->
			<?php if (isset($_SESSION['eRegistroPerfil'])) {
			echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
		} ?>
	</div>
	<div id="modal2" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha creado correctamente el perfil</p> 
        </div>
          <?php if (isset($exitoRegistrar)) {
             echo "<script language='javascript'> $('#modal2').openModal(); </script>"; 
             unset($_SESSION['exitoRegistrar']);
          } ?>                      
      </div>
    </div>
     <div id="modal3" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha modificado correctamente el perfil</p> 
        </div>
          <?php if (isset($exitoModificar)) {
             echo "<script language='javascript'> $('#modal3').openModal(); </script>"; 
             unset($_SESSION['exitoModificar']);
          } ?>                      
      </div>
    </div> 
     <div id="modal4" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Error</span> 
            <p>No se encuentra un perfil con ese nombre</p> 
        </div>
          <?php if (isset($eBuscar)) {
             echo "<script language='javascript'> $('#modal4').openModal(); </script>"; 
             unset($_SESSION['eBuscarP']);
          } ?>                      
      </div>
    </div>
    <div id="modal7" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
          <span class="card-title teal-text">Cambiar Contrasena</span>  
          <form action="../controladores/CoordinadorUsuario.php" method="post">   
              <?php if (isset($erroresCambiarPass)) {  ?>          
                <div class="card">
                  <div class="card-content">
                  <?php foreach ($erroresCambiarPass as $key) { ?>
                    <p><?php echo $key; ?></p>
                  <?php } ?>
                  </div>
                </div>        
              <?php } ?>           
            <div class="input-field">
              <input id="password" type="password" class="validate" name="passwordVieja">
              <label for="password">Contrasena Actual</label>
            </div> 
            <div class="input-field">
              <input id="password" type="password" class="validate" name="passwordNueva">
              <label for="password">Contrasena Nueva</label>
            </div>  
            <div class="input-field">
              <input id="password" type="password" class="validate" name="passwordNuevaC">
              <label for="password">Repite la Contrasena</label>
            </div>  
            <input class="btn-flat orange-text" type="submit" value="Guardar" name="cambiarPass">        
          </form>            
           <?php if (isset($erroresCambiarPass)) {
             echo "<script language='javascript'> $('#modal7').openModal(); </script>"; 
             unset($erroresCambiarPass);
             unset($_SESSION['eCambiarPass']);
             // header('Location: index.php');
          } ?>               
        </div>
      </div>
    </div>
</body>
</html>