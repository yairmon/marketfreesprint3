
<?php 
require_once '../scripts/gestionarCategorias.php';
  if (isset($_SESSION['eBuscarP'])) {
    $errorBuscarPerfil = $_SESSION['eBuscarP'];
  }
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
    ?>
	<?php }else{ header('Location: ../index.php');}?>   

	<div class="container">
  <br>	
		<div class="row">
      <h4>Categorias</h4>
      <form action="../controladores/CoordinadorCategoriaBuscar.php" method="post">
        <div class="row">
         <div class="input-field col s6 tooltipped" data-position="right" data-tooltip="Presiona enter para buscar" >
              <i class="mdi-action-search prefix"></i>
              <input id="nombreP" type="text" class="validate" name="nombre">
              <label for="nombreP">Ingresa un nombre para buscar</label>
              <input type="submit" class="btn col s3 offset-s1" name="buscarC" value="Buscar" style='display:none;'>
            </div>
        </div>
      </form>
    </div>
		<div class="row">
		<table class="hoverable responsive-table centered indigo lighten-5">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripcion</th>				
				</tr>
			</thead>
			<tbody>				
				<?php foreach ($_SESSION['categorias'] as $elementos) {
					?> <tr>
          <!-- *********************************************************************************************************************** -->
					<!-- en esta parte ira la conexion para traer los datos de la base de datos y mostrarlos -->
				  <td><?php echo $elementos['nombre']; ?></td>
          <td><?php echo $elementos['descripcion']; ?></td>
          <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
            <td> <a href="../controladores/CoordinadorCategoriaEditar.php?edit=<?php echo $elementos['nombre'] ?>" class="btn-flat tooltipped" name="edit" id="editar" data-tooltip="Editar"><i class="mdi-image-edit"></i></a></td> <?php 
          ?> 
				 </tr> <?php 
				} ?>
			</tbody>
		</table>
		</div>
		<div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
			<a class="btn-floating btn-large waves-effect waves-light red right modal-trigger tooltipped" data-position="left" data-tooltip="Nueva Categoria" href="#modal"><i class="mdi-content-add"></i></a>
		</div>
		<div class="valign-wrapper">
			<div class="col s12 m8 offset-m2 l4 offset-l3 valign">
				<div id="modal" class="modal modalLogin">
					<div class="card login">
						<div class="card-content">
           <!-- aqui esta el formato para crear una nueva categoria -->
							<span class="card-title teal-text">Crear Categoria</span> 
							<form action="../controladores/CoordinadorCategoriaCrear.php" method="post"> 
              <?php if(isset($_SESSION['erroresCreacionCategoria'])) {
                echo "<script language='javascript'> $('#modal').openModal(); </script>"; ?> 
                <?php if (isset($_SESSION['erroresCreacionCategoria'])) {  ?>
                    <div class="card">
                      <div class="card-content">
                      <?php foreach ($_SESSION['erroresCreacionCategoria'] as $elementos) { ?>
                        <p><?php echo $elementos; ?></p>
                      <?php } ?>
                      </div>
                    </div>        
                <?php } ?> 
                <?php unset($_SESSION['erroresCreacionCategoria']);} ?>
								<div class="input-field col m4 l2 tooltipped" data-position="bottom" data-tooltip="Este campo es requerido, 4-30 caracteres alfabeticos">
									<input id="nombre" type="text" name="nombre"  required maxlength="30">
									<label for="nombre">Nombre</label>
								</div>
                <h6>Descripción:</h6>
                <p align="center"><textarea  name="diagnostico" id="diagnostico" resize="nu" cols="95" rows="10" onblur="guardar(this);"></textarea></p>
								
  								<br>
								<input class="btn-flat orange-text" type="submit" value="Crear" name="crear">
            <!-- **************************************************************************** -->
								</div>
							</form>                     
						</div>
					</div>
				</div>
			</div>    
		</div>
			<?php if (isset($_SESSION['erroresCreacionCategoria'])) {
			echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
		} ?>
	</div>
    <div id="modal2" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha creado correctamente la categoria</p> 
        </div>
          <?php if (isset($exitoCrearCategoria)) {
             echo "<script language='javascript'> $('#modal2').openModal(); </script>"; 
             unset($_SESSION['exitoCreacionCategoria']);
          } ?>                      
      </div>
    </div>
    <div id="modal3" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha editado correctamente la categoria</p> 
        </div>
          <?php if (isset($exitoEditarCategoria)) {
             echo "<script language='javascript'> $('#modal3').openModal(); </script>"; 
             unset($_SESSION['exitoEditarCategoria']);
          } ?>                      
      </div>
    </div>
     <div id="modal4" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Error</span> 
            <p>No se encuentra una categoria con ese nombre</p> 
        </div>
          <?php if (isset($errorBuscarCategoria)) {
             echo "<script language='javascript'> $('#modal4').openModal(); </script>"; 
             unset($_SESSION['errorBuscarCategoria']);
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