<?php  
  // Se mandarán por GET los parametros actuales a la vista de editar Producto
require'../scripts/gestionarCategorias.php';
  $nuevoNombre = $_GET['nombre'];
  $nuevaCantidad = $_GET['cantidad'];
  // $nuevaCategoria = $_GET['categoria'];
  $nuevoValor = $_GET['valor'];
  $nuevaUrl = $_GET['url'];
  $nuevoEstado = $_GET['estado'];
  // session_start();
 
  if (isset($_SESSION['exitoRegistrar'])) {
    $exitoRegistrar = $_SESSION['exitoRegistrar'];
  }
  if (isset($_SESSION['exitoModificar'])) {
    $exitoModificar = $_SESSION['exitoModificar'];
  }
  if (isset($_SESSION['eBuscar'])) {
    $eBuscar = $_SESSION['eBuscar'];
  }
  
  #Hago una variable que me almacena los posibles errores cuando quiero editar el producto
  if(isset($_SESSION['erroresEditarProducto'])){
    $errorEditarProducto = $_SESSION['erroresEditarProducto'];
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
      <!-- EDITAR PRODUCTO -->
        <span class="card-title teal-text">Editar producto</span>  
        <?php #$perfiles = $_SESSION['perfiles']; ?>
        <form action="../controladores/CoordinadorProductoEditar.php" method="POST">
        <?php if (isset($_SESSION['erroresEditarProducto'])) {  ?>
                <div class="card">
                  <div class="card-content">
                  <?php foreach ($_SESSION['erroresEditarProducto'] as $key) { ?>
                    <p><?php echo $key;?></p>
                  <?php } ?>
                  </div>
                </div>        
            <?php unset($_SESSION['erroresEditarProducto']);} ?>      
          <div class="row">
            <div class="input-field col s6">
              <input id="nombre" type="text" class="validate tooltipped" name="nombre" value="<?php echo $nuevoNombre;?>" data-position="left" data-tooltip="Este campo es requerido, 3-30 caracteres alfabeticos">
              <label for="nombre">Nombre</label>
            </div>
          <input type="hidden" name="antiguo" value="<?php echo $nuevoNombre; ?>">          
            <div class="input-field col s6">
              <input id="cantidad" type="text" class="validate tooltipped" name="cantidad" value="<?php echo $nuevaCantidad;?>" data-position="right" data-tooltip="Este campo es requerido y es numérico" >
              <label for="cantidad">Cantidad</label>
            </div>
          </div>
          <div class="row">
          <?php $categorias = $_SESSION['categorias']?>
            <div class="input-field col s6">
              <select name="categoria" id="">
                <?php foreach ($categorias as $key) { ?>
                  <option value="<?php echo $key['id']; ?>"> <?php echo $key['nombre']; ?> </option>
                <?php } ?>
                <option value=""></option>
              </select>
            <!-- <div class="input-field col s6">
              <input id="categoria" type="text" class="validate tooltipped" name="categoria" value="?php echo $nuevaCategoria;?>" data-position="left" data-tooltip="Este campo es requerido y es numérico">
              <label for="categoria">Categoria</label>
            </div> -->
            <div class="input-field col s6">
              <input id="valor" type="text" class="validate tooltipped" name="valor" value="<?php echo $nuevoValor;?>" data-position="right" data-tooltip="Este campo es requerido y es numérico">
              <label for="valor">Valor Unitario</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <input id="url" type="url" class="validate tooltipped" name="url" value="<?php echo $nuevaUrl?>" data-position="left" data-tooltip="Este campo es requerido, use el formato https://www.example.com.co">
              <label for="url">URL de la imagen</label>
            </div>
  
              <div class="input-field col s6 tooltipped" data-tooltip="Eliga el estado de su producto">
                <h6>&nbsp;&nbsp;&nbsp;Estado :</h6>
                <p>
                  <input type="radio" id="enVenta" class="validate"  value = "en_venta" name="estado"<?php if ($nuevoEstado == "En venta"){ echo "checked"; }?>>
                  <label for="enVenta">En venta</label>
                </p>
                <p>
                  <input type="radio" id="vendido" value = "ven_dido"name="estado"<?php if ($nuevoEstado == "Vendido"){ echo "checked"; }?>>
                  <label for="vendido">Vendido</label>
                </p>
              </div>
            
          </div>
          <!-- BOTON QUE GUARDA LA EDICION DE LOS DATOS DE UN PRODUCTO -->
          <input class="btn-flat orange-text" type="submit" value="Guardar" name="guardarEditada">
          <a  href="crearProducto.php" class="button" type="submit" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Atras</a>
        </form>                     
      </div>
    </div>
  </div>
  </div>
  <!-- MuestraMensajes -->
    <div id="modal2" class="modal modalLogin">
      <div class="card login">
        <div class="card-content">
            <span class="card-title teal-text">Exito</span> 
            <p>Se ha creado Editado el Producto</p> 
        </div>
          <?php if (isset($exitoCrearProducto)) {
             echo "<script language='javascript'> $('#modal2').openModal(); </script>"; 
             unset($_SESSION['exitoCrearProducto']);
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