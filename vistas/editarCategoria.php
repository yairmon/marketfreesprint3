<?php 
  $nombre = $_GET['nombre'];
  $diagnostico = $_GET['diagnostico'];
 
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
        <span class="card-title teal-text">Editar categoria</span>  
        <form action="../controladores/CoordinadorCategoriaEditar.php" method="post">  
          <?php if (isset($_SESSION['erroresEditarCategoria'])) {  ?>
                <div class="card">
                  <div class="card-content">
                  <?php foreach ($_SESSION['erroresEditarCategoria'] as $key) { ?>
                    <p><?php echo $key; ?></p>
                  <?php } ?>
                  </div>
                </div>        
            <?php } ?> 
          <div class="row">
            <div class="input-field col s7">
             <p align="center"> <input id="nombre" type="text" class="validate tooltipped" name="nombre"  value="<?php echo $nombre; ?>" data-position="left" data-tooltip="Este campo es requerido, 3-30 caracteres alfabeticos">
              <label for="nombre">Nombre</label></p>
            </div>
          <input type="hidden" name="antiguo" value="<?php echo $nombre; ?>">  
            <div class="input-field col s6">
                <textarea id ="descripcion"class="materialize-textarea" name="diagnostico" id="diagnostico" resize="nu" cols="95" rows="10" onblur="guardar(this);"><?php echo $diagnostico; ?></textarea>
                <label for="descripcion">Descripción</label>
            </div>
          </div>            
          </div>
          <input class="btn-flat orange-text" type="submit" value="Guardar" name="editar">
            <a  href="categorias.php" class="button" type="submit" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Atras</a>
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
            <p>Edicion categoria</p> 
        </div>
          <?php if (isset($erroresEditarCategoria)) {
             echo "<script language='javascript'> $('#modal2').openModal(); </script>"; 
             unset($_SESSION['erroresEditarCategoria']);
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