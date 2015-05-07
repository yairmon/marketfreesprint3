<?php 
  $id_factura = $_GET['id_factura'];
  $estado = $_GET['estado'];
 
  session_start();
 
  if (isset($_SESSION['exitoRegistrar'])) {
    $exitoRegistrar = $_SESSION['exitoRegistrar'];
  }
  if (isset($_SESSION['exitoModificar'])) {
    $exitoModificar = $_SESSION['exitoModificar'];
  }
  if (isset($_SESSION['eBuscar'])) {
    $eBuscar = $_SESSION['eBuscar'];
  } 
  if(isset($_SESSION['erroresEditarCategoria'])){
    $errorEditarCategoria = $_SESSION['erroresEditarCategoria'];
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
   }else{ header('Location: ../index.php');}?> 
<div class="container">
  <div class="row">   
  <div class="col s12 m8 offset-m2 l6 offset-l3">
    <div class="card login">
      <div class="card-content">
        <span class="card-title teal-text">Cambiar Estado de Venta</span>  
        <form action="../controladores/CoordinadorVenta.php" method="post">   
          <div class="row">
            <div class="input-field col s7">
             <p align="center"> <input id="idFactura" type="text" class="validate" name="idFactura"  value="<?php echo $id_factura; ?>" data-position="left" readonly>
              <label for="nombre">Id Factura</label></p>
            </div>  
            <div class="input-field col s6">
              <!-- <h6>Estado:</h6>-->
              <input id="estado" type="text" class="validate" name="estado" value="<?php echo $estado; ?>" readonly>
              <label for="username">Estado de la Factura</label>
               <p>
                  <input type="checkbox" class="filled-in" id="filled-in-box"  value="enviado" name="group1"/>
                  <label for="filled-in-box">Enviado</label>
              </p>
            </div>
          </div>            
          </div>
          <input class="btn-flat orange-text" type="submit" value="Guardar Estado" name="guardar">
            <a  href="visualizarPedido.php" class="button" type="submit" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Atras</a>
        </form> 
        <?php if (isset($_SESSION['exitoAgregarCarrito'])) {
      echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
  } ?>
</div>

  <div id="modal11" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Has cambiado el estado de tu venta a Enviado</p> 
        </div>
          <?php if (isset($exitoCambiarEstadoPedido)) {
             echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
             unset($_SESSION['exitoCambiarEstadoPedido']);
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


<?php if (isset($_SESSION['erroresCarritoAgregar'])) {  ?>          
    <div class="row valign-wrapper">
        <div class="col s12 m4 valign">
          <div class="card indigo lighten-5 ">
            <div class="card-content">
                <h6 class = "valign" style="text-transform: uppercase;"><strong>¡ Error !</strong></h6>
                <p>Se han detectado los siguientes errores</p>
              <?php foreach ($erroresCarritoAgregar as $key) { ?>
                <p><strong><?php echo $key; ?></strong></p>
                
            <?php unset($_SESSION['erroresCarritoAgregar']);} ?>
            </div>
            <div class="card-action">
              <a href="productos.php" >Vuelva a intentar</a>
              <!-- <a href='#'>This is a link</a> -->
            </div>
          </div>
        </div>
      </div>     
<?php } ?> 

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
  </div>
</body>
</html>