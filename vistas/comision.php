
<?php 
  require_once '../scripts/gestionarComision.php';
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
      <h4>Comision</h4>
    </div>
		<div class="row">
		<table class="hoverable responsive-table centered indigo lighten-5">
			<thead>
				<tr>
					<th>Porcentaje</th>
					<th>Fecha Asignacion</th>				
				</tr>
			</thead>
			<tbody>				
				<?php foreach ($_SESSION['comision'] as $elementos) {
					?> <tr>
          <!-- *********************************************************************************************************************** -->
					<!-- en esta parte ira la conexion para traer los datos de la base de datos y mostrarlos -->
				  <td><?php echo $elementos['porcentaje']; ?></td>
          <td><?php echo $elementos['fecha']; ?></td>
          <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
				 </tr> <?php 
				} ?>
			</tbody>
		</table>
		</div>
		<div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
			<a class="btn-floating btn-large waves-effect waves-light red right modal-trigger tooltipped" data-position="left" data-tooltip="Editar" href="#modal"><i class="mdi-editor-border-color"></i></a>
		</div>
		<div class="valign-wrapper">
			<div class="col s12 m8 offset-m2 l4 offset-l3 valign">
				<div id="modal" class="modal modalLogin">
					<div class="card login">
						<div class="card-content">
           <!-- aqui esta el formato para modificar comision -->
				<span class="card-title teal-text">Cambiar Comision</span> 
				<form action="../controladores/CoordinadorComision.php" method="post"> 
              		<?php if(isset($_SESSION['errorComision'])) {
                		echo "<script language='javascript'> $('#modal').openModal(); </script>"; ?> 
                		<?php if (isset($_SESSION['errorComision'])) {  ?>
                    	<div class="card">
                      	<div class="card-content">
                      		<?php foreach ($_SESSION['errorComision'] as $elementos) { ?>
                        	<p><?php echo $elementos; ?></p>
                      		<?php } ?>
                      	</div>
                    	</div>        
                		<?php } ?> 
                		<?php unset($_SESSION['errorComision']);} ?>
						<div class="input-field col m4 l2 tooltipped" data-position="bottom" data-tooltip="Usa el punto (.) como separador, ej: 0.1">
								<input id="nombre" type="text" name="porcentaje"  required maxlength="15">
								<label for="nombre">Porcentaje</label>
						</div>						
  								<br>
								<input class="btn-flat orange-text" type="submit" value="Guardar" name="guardar">
            <!-- **************************************************************************** -->
								</div>
							</form>                     
						</div>
					</div>
				</div>
			</div>    
		</div>
			<?php if (isset($_SESSION['errorComision'])) {
			echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
		} ?>
	</div> 
	 <div id="modal2" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha editado correctamente la comision</p> 
        </div>
          <?php if (isset($exitoComision)) {
             echo "<script language='javascript'> $('#modal2').openModal(); </script>"; 
             unset($_SESSION['exitoComision']);
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