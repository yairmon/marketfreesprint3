<nav class="teal">
  <div class="nav-wrapper">
    <div class="col s12">
     <a href="../index.php" class="brand-logo" style ="font-family: 'Dancing Script', cursive;"><img src="../assets/images/Imagen1.png">MarketFree...</a><!-- imagen de logo responsiva-->       
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <ul class="right hide-on-med-and-down">
        <li> <a href="../index.php"><i class="mdi-action-home left" class="modal-trigger"></i> Home </a></li>
        <li><a  href="productos.php" ><i class = "mdi-maps-layers left"></i>Productos de venta&nbsp; </a></li>
        <li><a  href="compras.php" ><i class = " mdi-action-shopping-cart left"></i>Compra&nbsp; </a></li>
        <li><a class="dropdown-button" href="#!" data-activates="dropdown3"><i class="mdi-social-person left"></i>Mi Perfil&nbsp;&nbsp;<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
          <?php if (!(($_SESSION['permisoDeGestionarPerfiles'] == 0) and ($_SESSION['permisoDeGestionarUsuarios'] == 0))) { ?>
        <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="mdi-file-folder-shared left"></i>Modulos<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
          <?php } ?>
      </ul>      
      <ul id ="dropdown1" class="dropdown-content">
        <?php if ($_SESSION['permisoDeGestionarPerfiles'] == 1) { ?>
        <li><a href="gestionarPerfiles.php">Perfiles</a></li>
        <?php } ?>
        <?php if ($_SESSION['permisoDeGestionarPerfiles'] == 1) { ?>
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