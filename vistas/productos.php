<?php 
#Debi colocar tal cual el script de gestionar categorias aca porque de incluirlo, daba una Notice relacio-
#nado con en el session_start().
require'../scripts/gestionarProductos.php';
#++++++++++++++++++PONGO EL SCRIPT DE gestionarCategorias+++++++++++++++++
require_once'../modelos/CategoriaBuscar.php';
require_once'../controladores/CoordinadorSeguir.php';
$busquedaCat = new CategoriaBuscar();

$_SESSION['categorias'] = $busquedaCat->mostrarCategorias();
if(isset($_SESSION['exitoBuscarCategoria'])){
  $exitoBuscarCategoria = $_SESSION['exitoBuscarCategoria'];
}
#===========================================================
if(isset($_SESSION['exitoEditarCategoria'])){
  $exitoEditarCategoria = $_SESSION['exitoEditarCategoria'];
}
#===========================================================
if(isset($_SESSION['exitoCrearCategoria'])){
  $exitoCrearCategoria = $_SESSION['exitoCrearCategoria'];
} 
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  if (isset($_SESSION['exitoRegistrar'])) {
    $exitoRegistrar = $_SESSION['exitoRegistrar'];
  }
  if (isset($_SESSION['exitoModificar'])) {
    $exitoModificar = $_SESSION['exitoModificar'];
  }
  if (isset($_SESSION['eBuscar'])) {
    $eBuscar = $_SESSION['eBuscar'];
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
  <?php #aca iba a $perfiles ?>
 <!--  #================================================================== -->
  <div class="container ">   
    <?php include("tablaRecomendados.php"); ?>
    <br>
    <div class="row">
      <h4><i class="mdi-maps-layers left" class="modal-trigger"></i>Productos a la venta</h4>
      <form action="../controladores/CoordinadorProductoBuscar.php" method="POST">
        <div class="row">
         <div class="input-field col s6 tooltipped" data-position="right" data-tooltip="Presiona enter para buscar" >
              <i class="mdi-action-search prefix"></i>
              <!-- Input donde se digita al nombre para buscar un producto -->
              <input id="productoBuscar" type="text" class="validate" name="searchProducto">
              <label for="productoBuscar">Ingresa el nombre del producto</label>
              <input type="submit" class="btn col s3 offset-s1" name="buscar" value="Buscar" style='display:none;'>
            </div>
        </div>
      </form>
    </div>
    <table class="hoverable responsive-table centered indigo lighten-5">
    <?php $categorias = $_SESSION['categorias']?>
      <thead>
        <tr>
          <th><strong>Vendedor</strong></th>
          <th width="50">Nombre</th>
          <th>Cantidad</th>
          <th>Categoria</th>
          <th>Valor Unitario</th>
          <th>Imagen</th>
          <th>Estado</th>
          <th>Carrito</th>
          <th>Notificaciones</th>
        </tr>
      </thead>
      <!-- Tabla que muestra los productos en la vista -->
      <!-- '<img src="'.$registro['url_imagen'].'" width="130" height="130">' -->
      <tbody>  
        <?php  foreach ($_SESSION['todosLosProductos'] as $registro){
                $imagen = $registro['url_imagen'];?>
         <tr>
             <td><?php echo $registro['usuario_username'];?>
             </td> 
             <td><?php echo $registro['nombre'];?></td> 
             <form action="../controladores/CoordinadorCarrito.php" method="GET">
             <input type="hidden" value="<?php echo $registro['nombre']?>" name="nameProduct">
             <td>
                 <div class="input-field col s6">
                    <input id="cantidad" value = "1" type="text" class="validate tooltipped" data-tooltip = "Hay <?php echo $registro['cantidad'] ?> cantidad(es) disponible(s)" name="cantidadAComprar">
                    <label for="cantidad">¿Cuántas quieres?</label>
                 </div> 
             </td> 
             <td><?php $cat = $categorias[$registro['categoria_id']];
                       echo $cat['nombre'];?>
             </td>
             <td><?php echo $registro['valor_unitario'];?></td>
             <td><?php echo '<img class="responsive-img circle" src="'.$imagen.'" width="100" height="130" alt="Imagen">';?></td>
             <td><?php echo $registro['estado'];?></td> 
             <td> <button class="btn teal darken-2 waves-effect waves-light validate tooltipped" data-tooltip = "Agregar al Carrito"  data-position="right" type="submit" name="agregarAlCarrito"><i class="mdi-action-add-shopping-cart"></i>
  </button></td>

              </form>
            <td>


            <?php
            # Aqui ponemos el boton dependiendo si puede seguir al usuario o ya lo esta siguiendo
            $seguidores = new CoordinadorSeguir();
            $siguiendo = $seguidores->obtenerSeguidos($_SESSION['user']);
            if (in_array($registro['usuario_username'], $siguiendo) && $_SESSION['user'] != $registro['usuario_username']) {
              echo '<form action="../scripts/dejarDeSeguirUsuario.php?usuarioSeguidor='.$_SESSION['user'].'&usuarioSeguido='.$registro['usuario_username'].'" method="POST">
              <button class="btn teal darken-2 waves-effect waves-light validate tooltipped" data-tooltip = "Desabilitar notificaciones del usuario"  data-position="right" type="submit" name="deshabilitar"><i class="mdi-navigation-cancel"></i> </button></td>
              </form>';
            }
            elseif (!(in_array($registro['usuario_username'], $siguiendo))  && $_SESSION['user'] != $registro['usuario_username']) {
              echo '<form action="../scripts/seguirUsuario.php?usuarioSeguidor='.$_SESSION['user'].'&usuarioSeguido='.$registro['usuario_username'].'" method="POST">
              <button class="btn teal darken-2 waves-effect waves-light validate tooltipped" data-tooltip = "Habilitar notificaciones del usuario"  data-position="right" type="submit" name="habilitar"><i class="mdi-social-person-add"></i> </button></td>
              </form>';
            }
            ?>


            
             <!-- <td><a href="" class="grey-text text-darken-3 tooltipped" name="down" id="down" data-tooltip="Remover de la lista"><i class="mdi-action-highlight-remove small"></i></a></td> --> <?php
          ?> </tr>
          <?php } ?> 
      </tbody>
    </table>  
  </div>
  <div class="fixed-action-btn" style="bottom: 45px; right: 45px;">
    <a class="btn-floating btn-large waves-effect waves-light red right modal-trigger tooltipped" href="#modal" data-tooltip="Nuevo Producto"><i class="mdi-content-add"></i></a>
  </div>
  <div class="col s12 m8 offset-m2 l4 offset-l3 valign">
   <div id="modal" class="modal modalLogin">
    <div class="card login">
      <div class="card-content">
      <!-- #==================Crear Producto===================== -->
        <span class="card-title teal-text">Crear Producto</span>  
        <form action="../controladores/CoordinadorProductoCrear.php" method="POST">
        <!-- Muestro los errores al crear un producto -->
        <?php if(isset($_SESSION['erroresCrearProducto'])) {
          echo "<script language='javascript'> $('#modal').openModal(); </script>"; ?>
          <?php if (isset($_SESSION['erroresCrearProducto'])) {  ?>          
            <div class="card">
              <div class="card-content">
                <?php foreach ($_SESSION['erroresCrearProducto'] as $key) { ?>
                  <p><?php echo $key; ?></p>
                <?php } ?>
              </div>
            </div>        
          <?php } ?>           
        <?php unset($_SESSION['erroresCrearProducto']);} ?> <!-- Destruye esa variable de sesion para liberar memoria y para que no me aparezca el modal cada que recarge la pagina -->             
          <div class="row">
            <div class="input-field col s6">
              <input id="nombre" type="text" class="validate tooltipped" data-tooltip="Este campo es requerido, 3-30 caractéres alfanuméricos" name="nombre">
              <label for="nombre">Nombre</label>
            </div>
            <div class="input-field col s6">
              <input id="cantidad" type="text" class="validate tooltipped" name="cantidad" data-tooltip="Este campo es requerido y es numérico">
              <label for="cantidad">Cantidad</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <select name="categoria" id="">
                <?php foreach ($categorias as $key) { ?>
                  <option value="<?php echo $key['id']; ?>"> <?php echo $key['nombre']; ?> </option>
                <?php } ?>
               
              </select>
              <!-- <input id="categorias" type="text" class="validate tooltipped" name="categoria" data-tooltip="Este campo es requerido y es numérico">
              <label for="categoria">Categoria</label> -->

            </div>
            
          </div>
          <div class="row">
            <div class="input-field col s6">
              <input id="valor_unitario" type="text" class="validate tooltipped" data-tooltip="Este campo es requerido y es numérico" name="valorUnitario">
              <label for="valor_unitario">Valor Unitario</label>
            </div>

            <div class="input-field col s6">
              <input id="email" type="url" class="validate tooltipped" data-tooltip="Este campo es requerido, use el formato https://www.example.com" name="url">
              <label for="url"><i class="mdi-editor-insert-photo left"></i>URL de la imagen</label>
            </div>
          </div>
        </div>
          <!-- Boton para crear Producto -->  
          <input class="btn-flat orange-text " type="submit" value="Crear Producto" name="crearProducto">
          <!--  FALTA DARLE FUNCINALIDAD PARA REGRESAR  -->
        </form><!-- Cierra formulario crear prducto -->                     
      </div>
    </div>
  </div>
  <!-- Notificacion de exito al editar -->
  <?php if (isset($_SESSION['erroresCrearProducto'])) {
      echo "<script language='javascript'> $('#modal').openModal(); </script>"; 
    } ?>
</div>

    <div id="modal2" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha creado correctamente el Producto</p> 
        </div>
          <?php if (isset($exitoCrearProducto)) {
             echo "<script language='javascript'> $('#modal2').openModal(); </script>"; 
             unset($_SESSION['exitoCrearProducto']);
          } ?>                      
      </div>
    </div>
    <div id="modal4" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Error</span> 
            <p>No se encuentra un producto con ese nombre</p> 
        </div>
          <?php if (isset($errorBuscarProducto)) {
             echo "<script language='javascript'> $('#modal4').openModal(); </script>"; 
             unset($_SESSION['errorBuscarProducto']);
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



    <div id="modalNoSiguiendo" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Advertencia</span> 
            <p>Ha ocurrido un error al tratar de habilitar las notificaciones de este usuario</p> 
        </div>
      </div>
    </div>

    <div id="modalSiguiendo" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">&Eacute;xito</span> 
            <p>Usted ahora est&aacute; recibiendo notificaciones de este usuario</p> 
        </div>
          <?php 
          if(isset($_GET["siguiendoUsuario"]))
          {
            if ($_GET["siguiendoUsuario"] != "error") 
               echo "<script language='javascript'> $('#modalSiguiendo').openModal(); </script>"; 
            else
               echo "<script language='javascript'> $('#modalNoSiguiendo').openModal(); </script>"; 
            
          }
          
          ?>                      
      </div>
    </div>

    <div id="modalNoSeguir" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Advertencia</span> 
            <p>Ha ocurrido un error al tratar de deshabilitar las notificaciones de este usuario</p> 
        </div>
      </div>
    </div>

    <div id="noSeguir" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">&Eacute;xito</span> 
            <p>Usted ahora no est&aacute; recibiendo notificaciones de este usuario</p> 
        </div>
          <?php 
          if(isset($_GET["noSeguir"]))
          {
            if ($_GET["noSeguir"] != "error") 
               echo "<script language='javascript'> $('#noSeguir').openModal(); </script>"; 
            else
               echo "<script language='javascript'> $('#modalNoSeguir').openModal(); </script>"; 
            
          }
          
          ?>                      
      </div>
    </div>

</body>
</html>


