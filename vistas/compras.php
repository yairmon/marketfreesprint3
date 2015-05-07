<?php 
  require_once '../modelos/Usuario.php';
	include_once '../scripts/gestionarUsuarios.php';
  include_once '../scripts/gestionarCarrito.php';

  
  $usuarioComprador = new Usuario();
  $_SESSION['clienteFactura'] = $usuarioComprador->buscarUsuario($_SESSION['user']);
  // $_SESSION['exitoComprar'] = 0;
  // require_once '../controladores/CoordinadorCarrito.php';

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
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="container">
   <div class="divider"></div>
  <div class="section">
    <!-- -->

     
    <br>
    <div class="row"> 
      <h4><i class="mdi-action-shopping-cart left" class="modal-trigger"></i>Tu carrito de Compras</h4><br>
    
    </div>
        
             
        <?php  if(isset($_SESSION['carrito'])){?>
              <table class="hoverable responsive-table indigo lighten-5">
                <thead>
                  <tr>
                    <th>Imagen</th>
                    <th>Fecha de la compra</th>
                    <th>Nombre de producto</th>
                    <th>Cantidad</th>
                    <th>Valor unitario</th>
                    <th>Valor neto</th>
                   <!--  <th>valor total de los productos</th> -->
                   
                  </tr>
                </thead>
            <?php $suma = 0;
            foreach ($_SESSION['carrito'] as $key) { #print_r($_SESSION['carrito']); 
              $valorNeto = $key['valor']*$key['cantidad'];
              $suma = $suma + $key['valor']*$key['cantidad'];
            #print_r($key)."<br>";?>
                <!-- envio de datos a la base de datos -->
                <tbody>
              
                <tr>
                   <td><?php echo '<img class="responsive-img circle" src="'.$key["url"].'" width="130" height="130" alt="Imagen">';?></td> 
                   <td><?php echo date("d/m/Y")?></td> 
                   <td><?php echo $key["nombre"]; ?></td>
                   <td><?php echo $key["cantidad"] ?></td>
                   <td><?php echo $key["valor"]?></td>
                   <td><?php echo $valorNeto?></td> 
                   <td></td> 
                   
                   <td><a href="../controladores/CoordinadorCarrito.php?nombre=<?php echo $key['nombre']?>" class="grey-text text-darken-3 tooltipped" name="down" id="down" data-tooltip="Remover del carrito" data-position="right"><i class="mdi-action-highlight-remove small"></i></a></td>
                </tr> 
          <?php } ?>
    <!-- cuando no esta seteado el carro, entonces se ocultan los botones flotantes de comprar y seguir comprando -->
          <div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
            <a class="btn-floating btn-large waves-effect waves-light red right  tooltipped" data-position="rigth" data-tooltip="Seguir Comprando" href="productos.php"><i class="mdi-action-add-shopping-cart"></i></a>
          </div>
          <div class="fixed-action-btn" style="bottom: 45px; right: 200px;">
            <a class="btn-floating btn-large waves-effect waves-light red right modal-trigger tooltipped" data-position="left" data-tooltip="Comprar" href="#modal"><i class="mdi-maps-local-atm "></i> Comprar</a>
          </div>
        <?php }?>
        <?php if (! isset($_SESSION['carrito'])) { 
          echo "<div class='row valign-wrapper'>";
            echo"<div class='col s12 m12 valign'>";
              echo"<div class='card indigo lighten-5'>";
                echo "<div class='card-content'>";
                  echo "<h6 class = 'valign' style='text-transform: uppercase;'><strong>Mensaje del Sistema</strong></h6>";
                    echo "<p>No tienes productos en tu carrito de compras, ¡ ve a la sección de Productos en venta y llénalo !</p>";
                  echo "</div>";
                  echo "<div class='card-action'>";
                  echo "<a href='productos.php' >Ir a Productos en Venta</a>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";        
          }?>
        
      </tbody>
    </table>
    
  </div>
</div>

  <div class="col s12 m8 offset-m2 l6 offset-l3">
   <div id="modal" class="modal ">
    <div class="card login ">
      <div class="card-content">
        <span class="card-title teal-text">Factura</span>  
        <form action="../controladores/CoordinadorVenta.php" method="post">            
          <div class="row">
            <div class="input-field col s6">
              <input id="estado" type="text" class="validate" name="estado" value="Pendiente" readonly="aaa">
              <label for="last_name">Estado</label>
            </div>
            <div class="input-field col s6">
              <?php $miUsuario = $_SESSION['clienteFactura']; ?>
              <input type="hidden" name="idCliente" value="<?php echo $miUsuario['id']; ?>">
              <input id="icon_prefix" type="text" class="validate" value="<?php echo $miUsuario['nombre']." ".$miUsuario['apellidos'];  ?>" readonly>
              <label for="icon_prefix">Cliente</label>
            </div>         
            <div class="input-field col s6">
              <input id="fecha" type="text" class="validate" name="fecha" value="<?php echo date("d/m/y"); ?>" readonly>
              <label for="fecha">Fecha</label>
            </div>
            <div class="row">
              <table class="hoverable responsive-table striped">
                <thead>
                <tr>
                <th>Nombre</th>
                <th>Cantidad</th> 
                <th>Valor Unitario</th>   
                <th>Total</th>
                <th>Vendedor</th>    
                </tr>
                </thead>
                <tbody>
                <?php foreach ($_SESSION['carrito'] as $products) {
                ?> <tr>       
                    <td><?php echo $products['nombre']; ?></td>
                    <td><?php echo $products['cantidad']; ?></td>
                    <td><?php echo $products['valor']; ?></td>
                    <td><?php echo $products['cantidad']*$products['valor']; ?></td>
                    <td><?php echo $products['username']; ?></td>
                  </tr><?php } ?>
                </tbody>
             </table>
            </div>
            <div class="row">
              <div class="input-field col s6">
              <input id="total" type="text" class="validate" name="total" value="<?php echo $suma; ?>" readonly>
              <label for="total">Total</label>
            </div>
          </div>
        </div> 
        <input class="btn-flat orange-text" type="submit" value="Confirmar Pago" name="comprar">
        </div>  
          </form>
         </div> 
          </div>                    
      </div>
    </div>
  </div>
  
 <?php if (isset($_SESSION['exitoAgregarCarrito'])) {
      echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
  } ?>
</div>
  <div id="modal11" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>El producto se ha añadido al carrito de compras</p> 
        </div>
          <?php if (isset($exitoAgregarCarrito)) {
             echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
             unset($_SESSION['exitoAgregarCarrito']);
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

