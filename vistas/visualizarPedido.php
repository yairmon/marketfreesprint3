<?php 
	include_once '../scripts/gestionarPedidos.php';
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
<!--<?php $perfiles = $_SESSION['perfiles']; ?>-->

  <div class="container">   
    <br>
    <div class="row">
      <h4>Visualizar pedidos</h4>
    </div>
    <!--  -Se genera una tabla con todas la facturas que se hayan creado- 
    -para visualizar la factura se dará  "CLICK" sobre la factura que se quiere visualizar en caso de que sea administrador y vendedor para editar el estado de la factura
     -para vsaber el estado de la compra solo se mostrata la información que contiene la factura y su estado, en caso de que sea admin o comprador   -->
    <?php if (! empty($_SESSION['pedidosVendedor'])) {?>
    <table class="hoverable responsive-table indigo lighten-5">
      <thead>
        <tr>
          <th>Id Factura</th>
          <th>Fecha</th>
          <th>Nombre del comprador</th>
          <th>Nombre del producto</th>
          <th>Valor Unitario</th>
          <th>Cantidad</th>
          <th>Estado </th>
        </tr>
      </thead>
      <!-- envio de datos a la base de datos -->
      <tbody>       
        <?php foreach ($_SESSION['pedidosVendedor'] as $key) {
          ?> <tr>
             <td><?php echo $key['id_factura']; ?></td> 
             <td><?php echo $key['fecha']; ?></td> 
             <td><?php echo $key['comprador']; ?></td>
             <td><?php echo $key['nombre']; ?></td>
             <td><?php echo $key['valor_unitario']; ?></td>
             <td><?php echo $key['cantidad']; ?></td> 
            <td><?php echo $key['estado']; ?></td>
             <td> <a  class="btn-flat tooltipped" name="edit" id="edit" href="../controladores/CoordinadorVenta.php?edit=<?php echo $key['id_factura'] ?>" data-tooltip="Cambiar estado de venta" data-position="right"><i class="mdi-image-edit small"></i></a></td>
              <?php
          ?> </tr> <?php 
        } ?> 
      </tbody>
    </table>  
     
    <?php }?>
    <?php if (empty($_SESSION['pedidosVendedor'])) {?>
    <div class='row valign-wrapper'>
      <div class='col s12 m12 valign'>
          <div class='card indigo lighten-5'>
              <div class='card-content'>
                <h6 class = 'valign' style='text-transform: uppercase;'><strong>Mensaje del Sistema</strong></h6>
                <p>No tienes pedidos pendientes, crea productos y súbelos a la plataforma para que otras personas puedan verlos,
                       y así tener mas oportunidades de aumentar tus pedidos</p>
              </div>
              <div class='card-action'>
                <a href='crearProducto.php' >Ir a Crear Productos</a>
              </div>
        </div>
      </div>
    </div> 
    <?php }?>
      

  </div>

   <div class="col s12 m8 offset-m2 l6 offset-l3">
   <div id="modal" class="modal ">
    <div class="card login ">
      <div class="card-content">
        <span class="card-title teal-text">Cambiar Estado de Venta</span>  
        <form action="" method="post"> 
          <?php if (isset($_SESSION['eRegistroUsuario'])) { ?>          
        <div class="card">
          <div class="card-content">
            <?php foreach ($_SESSION['eRegistroUsuario'] as $key) { ?>
              <p><?php echo $key; ?></p>
            <?php } ?>
          </div>
        </div>        
      <?php } ?>             
          <div class="row">
            <div class="input-field col s6">
              <input id="username" type="text" class="validate" name="idfactura">
              <label for="username">Id de la factura</label>
            </div>
            <div class="input-field col s6">
              <input id="username" type="text" class="validate" name="estado">
              <label for="username">Estado de la Factura</label>
            <form action="#">
                    <p>
                        <input name="group1" type="radio" id="test1" />
                        <label for="test1">Despachado</label>
                    </p>
                    <p>
                        <input name="group1" type="radio" id="test2" />
                        <label for="test2">Cancelado</label>
                    </p>
          </form>
            </div>
          </div>
          </div>
          <!-- al dar click en confirmar pago se realizar´n las notificaciones requeridas por el sistema (Historias de Usuario) -->
           <input class="btn-flat orange-text" type="submit" value="Guardar" name="guardar">
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
            <p>Has cambiado el estado de tu pedido</p> 
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
