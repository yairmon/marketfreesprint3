
    <?php  
   require_once '../controladores/CoordinadorVogoo.php';

   
    $nUsuario = $_SESSION['user'];
    $vogoo = new CoordinadorVogoo();
    $recomendados = $vogoo->verRecomendados($nUsuario);
    if(empty($recomendados)){

      echo '<h5><i class="mdi-maps-layers left" class="modal-trigger"></i>No tenemos recomendaciones para ti :(</h5>';

    }else{
    ?>
<div class="row">
  <h5><i class="mdi-maps-layers left" class="modal-trigger"></i>Productos recomendados</h5>
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
  <tbody>  
<?php
foreach ($recomendados as $registro){
        $imagen = $registro['url_imagen'];
        if($registro['usuario_username'] == $nUsuario)
          continue; # En caso de que me recomiende un producto mio, se lo salta
        ?>
     <tr>
         <td><?php echo $registro['usuario_username'];?></td> 
         <td><?php echo $registro['nombre'];?></td> 
         <form action="../controladores/CoordinadorCarrito.php" method="GET">
         <input type="hidden" value="<?php echo $registro['nombre']?>" name="nameProduct">
         <td>
             <div class="input-field col s6">
                <input id="cantidad" type="text" class="validate tooltipped" data-tooltip = "Hay <?php echo $registro['cantidad'] ?> cantidad(es) disponible(s)" name="cantidadAComprar">
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
          <button class="btn teal darken-2 waves-effect waves-light validate tooltipped" data-tooltip = "Desabilitar notificaciones del usuario"  data-position="right" type="submit" name="agregarAlCarrito"><i class="mdi-navigation-cancel"></i> </button></td>
          </form>';
        }
        elseif (!(in_array($registro['usuario_username'], $siguiendo))  && $_SESSION['user'] != $registro['usuario_username']) {
          echo '<form action="../scripts/seguirUsuario.php?usuarioSeguidor='.$_SESSION['user'].'&usuarioSeguido='.$registro['usuario_username'].'" method="POST">
          <button class="btn teal darken-2 waves-effect waves-light validate tooltipped" data-tooltip = "Habilitar notificaciones del usuario"  data-position="right" type="submit" name="agregarAlCarrito"><i class="mdi-social-person-add"></i> </button></td>
          </form></tr>';
        }
      }
    } ?> 
  </tbody>
</table> 