<?php 
  require_once '../scripts/gestionarPedidos.php';
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
      <h4>Compras por Aprobar</h4>
    </div>
		<div class="row">
  		<table class="hoverable responsive-table centered indigo lighten-5">
  			<thead>
  				<tr>
  					<th>Id Factura</th>
  					<th>Fecha</th>	
  					<th>Cliente</th>
  					<th>Total</th>
  					<th>Comision</th>	
  					<th>Ganancia</th>		
  				</tr>
  			</thead>
  			<tbody>				
  				<?php foreach ($_SESSION['pendientes'] as $elementos) {?> 
          <tr>
            <!-- *********************************************************************************************************************** -->
  					<!-- en esta parte ira la conexion para traer los datos de la base de datos y mostrarlos -->
  				  <td><?php echo $elementos['id']; ?></td>
            		  <td><?php echo $elementos['fecha']; ?></td>
            		  <td><?php echo $elementos['cliente']; ?></td>
            		  <td><?php echo $elementos['total']; ?></td>
            		  <td><?php echo $elementos['comision']; ?></td> 		  
            		  <td><?php echo $elementos['comision']*$elementos['total']; ?></td>
            		   <td> <a  class="btn-flat tooltipped" name="aprobar" id="aprobar" href="../controladores/CoordinadorVenta.php?aprobar=<?php echo $elementos['id'].'&cliente='.$elementos['cliente'] ?>" data-tooltip="Aprobar compra" data-position="right"><i class="mdi-action-done small"></i></a></td>
            <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
  				 </tr> <?php 
  				} ?>
  			</tbody>
  		</table>

      <?php if (empty($_SESSION['pendientes'])) {
        echo "<div class='row valign-wrapper'>";
            echo"<div class='col s12 m12 valign'>";
              echo"<div class='card indigo lighten-5'>";
                echo "<div class='card-content'>";
                  echo "<h6 class = 'valign' style='text-transform: uppercase;'><strong>Mensaje del sistema</strong></h6>";
                    echo "<p>Administrador, no tienes compras pendientes por aprobar.</p>";
                  echo "</div>";
                  // echo "<div class='card-action'>";
                  // echo "<a href='productos.php' >Ir a Productos en Venta</a>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
      }?>

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
								<div class="input-field col m4 l2 tooltipped" data-position="bottom" data-tooltip="Este campo es requerido">
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
	<?php if (isset($_SESSION['exitoAprobar'])) {
      echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
  } ?>
</div>

  <div id="modal11" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Has aprobado la compra</p> 
        </div>
          <?php if (isset($exitoAprobar)) {
             echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
             unset($_SESSION['exitoAprobar']);
          } ?>                      
      </div>
    </div>
      <div id="modal12" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se han eliminado los productos del carrito</p> 
        </div>
          <?php if (isset($exitoEliminarCarrito)) {
             echo "<script language='javascript'> $('#modal12').openModal(); </script>"; 
             unset($_SESSION['exitoCarritoEliminar']);
          } ?>                      
      </div>
    </div>

 <?php if (isset($_SESSION['eRegistroUsuario'])) {
      echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
    } ?>

<div id="modal2" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha creado correctamente el usuario</p> 
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
            <p>Se ha modificado correctamente el usuario</p> 
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
            <p>No se encuentra un usuario con ese documento</p> 
        </div>
          <?php if (isset($errorBuscarPerfil)) {
             echo "<script language='javascript'> $('#modal4').openModal(); </script>"; 
             unset($_SESSION['eBuscar']);
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
			<?php if (isset($_SESSION['errorComision'])) {
			echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
		} ?>
	</div>   
</body>
</html>