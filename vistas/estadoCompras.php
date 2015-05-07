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
	<?php if ((isset($_SESSION['logueado']))){ ?>
  
  <nav class="teal">
    <div class="nav-wrapper">
      <div class="col s12">
       <a href="../index.php" class="brand-logo" style ="font-family: 'Dancing Script', cursive;"><img src="../assets/images/Imagen1.png">MarketFree...</a><!-- imagen de logo responsiva-->       
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
        <ul class="right hide-on-med-and-down">
          <li> <a href="../index.php"><i class="mdi-action-home left" class="modal-trigger"></i> Home </a></li>
          <li><a  href="productos.php" ><i class = "mdi-maps-layers left"></i>Productos de venta&nbsp; </a></li>
          <li><a  href="compras.php" ><i class = " mdi-action-shopping-cart left"></i>Compra&nbsp; </a></li>
           <!-- <li><a class="dropdown-button" href="#!" data-activates="dropdown2"><i class="mdi-action-account-box left"></i>Mi Cuenta&nbsp;<i class="mdi-navigation-arrow-drop-down right"></i></a></li> -->
            <li><a class="dropdown-button" href="#!" data-activates="dropdown3"><i class="mdi-social-person left"></i>Mi Perfil&nbsp;&nbsp;<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
            <?php if (!(($_SESSION['permisoDeGestionarPerfiles'] == 0) and ($_SESSION['permisoDeGestionarUsuarios'] == 0))) { ?>
          <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="mdi-file-folder-shared left"></i>Modulos<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
            <?php } ?>

          

        </ul>      
        <ul id ="dropdown1" class="dropdown-content">
          <?php if ($_SESSION['permisoDeGestionarPerfiles'] == 1) { ?>
            <li><a href="gestionarPerfiles.php">Perfiles</a></li>
          <?php } ?>
          <?php if ($_SESSION['permisoDeGestionarUsuarios'] == 1) { ?>
            <li><a href="gestionarUsuarios.php">Usuarios</a></li>
          <?php } ?>
           <?php if ($_SESSION['permisoDeGestionarUsuarios'] == 1) { ?>
            <li><a href="categorias.php">Categorias</a></li>
          <?php } ?>
          <?php if ($_SESSION['permisoDeGestionarUsuarios'] == 1) { ?>
            <li><a href="comision.php">Comision</a></li>
          <?php } ?>
          <?php if ($_SESSION['permisoDeGestionarUsuarios'] == 1) { ?>
            <li><a href="facturasAdmin.php">Facturas</a></li>
          <?php } ?>
        </ul>
      <ul id="dropdown3" class="dropdown-content">
              <li><a href="crearProducto.php"> Mis<br> productos</a></li>
              <li><a href="visualizarPedido.php"> Visualizar<br> Pedidos</a></li>
               <li><a href="estadoCompras.php"> Mis<br> Compras</a></li>
              <li><a href="../controladores/CoordinadorUsuario.php?user=<?php echo $userMod ?>" >Modificar <br>mis datos</a></li>
              <li><a href="#modal7" class="modal-trigger">Cambiar<br> contrasena</a></li>
              <li><a href="../scripts/salir.php">Salir</a></li>
        </ul> 

        <!-- responsive navbar -->
           <ul class="side-nav" id="mobile-demo">
            <img src="../assets/images/logo.png">
          <li> <a href="../index.php"><i class="mdi-action-home left" class="modal-trigger"></i> Home </a></li>
           <li><a  href="compras.php" ><i class = " mdi-action-shopping-cart left" class="modal-trigger"></i>Compra </a></li>
           <li><a class="dropdown-button" href="#!" data-activates="dropdown1" class="modal-trigger">&nbsp;&nbsp;Modulos <i class="mdi-navigation-arrow-drop-down right"></i></a></li>
           <li><a class="dropdown-button" href="#!" data-activates="dropdown2" class="modal-trigger">&nbsp;&nbsp;Mi cuenta <i class="mdi-navigation-arrow-drop-down right"></i></a></li>
           <li><a class="dropdown-button" href="#!" data-activates="dropdown3" class="modal-trigger">&nbsp;&nbsp;Mi perfil <i class="mdi-navigation-arrow-drop-down right"></i></a></li>

          <li><a href="scripts/salir.php" class="modal-trigger">&nbsp;&nbsp;Salir</a></li>
           <li><a href="#" >&nbsp;&nbsp;Opciones</a></li>
        </ul> 
        
      </div>
    </div>
  </nav>
 <?php }else{ header('Location: ../index.php');}?> 
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<!--<?php $perfiles = $_SESSION['perfiles']; ?>-->

  <div class="container">   
    <br>
    <div class="row">
      <h4>Estado de mis Compras</h4>
    </div>
    <!--  -Se genera una tabla con todas la facturas que se hayan creado- 
    -para visualizar la factura se dará  "CLICK" sobre la factura que se quiere visualizar en caso de que sea administrador y vendedor para editar el estado de la factura
     -para vsaber el estado de la compra solo se mostrata la información que contiene la factura y su estado, en caso de que sea admin o comprador   -->
    <?php if (! empty($_SESSION['comprasCliente'])) {?>
     
    <table class="hoverable responsive-table indigo lighten-5">
      <thead>
        <tr>
          <th>Id Factura</th>
          <th>Fecha</th>
          <th>Nombre del Vendedor</th>
          <th>Nombre del producto</th>
          <th>Valor Unitario</th>
          <th>Cantidad</th>
          <th>Estado </th>
        </tr>
      </thead>
      <!-- envio de datos a la base de datos -->
      <tbody>       
        <?php foreach ($_SESSION['comprasCliente'] as $key) {
          ?> <tr>
             <td><?php echo $key['id_factura']; ?></td> 
             <td><?php echo $key['fecha']; ?></td> 
             <td><?php echo $key['vendedor']; ?></td>
             <td><?php echo $key['nombre']; ?></td>
             <td><?php echo $key['valor_unitario']; ?></td>
             <td><?php echo $key['cantidad']; ?></td> 
            <td><?php echo $key['estado']; ?></td>
            <?php if ($key['estado']=="aprobado" or $key['estado']=="pendiente") {
            ?><td><a href="../controladores/CoordinadorVenta.php?down=<?php echo $key['id_factura']."&product=".$key['nombre']."&estado=".$key['estado'] ?>" class="grey-text text-darken-3 tooltipped" name="down" id="down" data-tooltip="Cancelar" data-position="right"><i class="mdi-action-highlight-remove small"></i></a></td> 
            <?php }else{ ?>
              <td><a href="#" class="grey-text text-darken-3 tooltipped" name="down" id="down" data-tooltip="El pedido no puede ser cancelado" data-position="right"><i class="mdi-action-highlight-remove small"></i></a></td> 
            <?php } 
            if($key['estado']=="enviado"){
            ?>

              <td><a href="../scripts/marcarProductoRecibido.php?factura=<?php echo $key['id_factura']."&vendedor=".$key['vendedor']."&producto=".$key['nombre'] ?>" class="grey-text text-darken-3 tooltipped" name="recibido" id="recibido" data-tooltip="Marcar Recibido" data-position="right"><i class="mdi-action-assignment-turned-in small"></i></a></td> 
            </tr> <?php }
        } ?> 
      </tbody>
    </table>  
    <?php }?>
    <?php if (empty($_SESSION['comprasCliente'])) {?>
    <div class='row valign-wrapper'>
      <div class='col s12 m12 valign'>
          <div class='card indigo lighten-5'>
              <div class='card-content'>
                <h6 class = 'valign' style='text-transform: uppercase;'><strong>Mensaje del Sistema</strong></h6>
                <p>No has comprado nada aún, dirigite a la sección de Productos en venta y descubre artículos
                que quizá te interese comprar.</p>
              </div>
              <div class='card-action'>
                <a href='productos.php' >Ir a Productos en venta</a>
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
        <?php if (isset($_SESSION['exitoAgregarCarrito'])) {
      echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
  } ?>
</div>

  <div id="modal11" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Tu compra se ha llevado a cabo de manera exitosa <strong>pero aún falta que sea aprobada por el Administrador</strong></p> 
        </div>
          <?php if (isset($exitoComprar)) {
             echo "<script language='javascript'> $('#modal11').openModal(); </script>"; 
             unset($_SESSION['exitoComprar']);
          } ?>                      
      </div>
    </div>
      <div id="modal12" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha cancelado tu compra, se procederá a reembolsar el dinero en las próximas horas</p> 
        </div>
          <?php if (isset($exitoCancelar)) {
             echo "<script language='javascript'> $('#modal12').openModal(); </script>"; 
             unset($_SESSION['exitoCancelar']);
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
    <div id="modalRecibido" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">&Eacute;xito</span> 
            <p>Se ha marcado el producto como recibido.</p>       
           <?php if ($_GET['modal'] == "modalRecibido") {
             echo "<script language='javascript'> $('#modalRecibido').openModal(); </script>"; 
          } ?>  
      </div>
    </div>                     
      </div>
    </div>
</div>
</div>
</body>
</html>