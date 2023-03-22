<?php
  //verificamos que el usaurio haiga iniciado sesion
  session_start();
  $url = "http://".$_SERVER['HTTP_HOST']."/phpProjects/CRUD";
  if(!isset($_SESSION['session_user'])){
    header('Location:'.$url.'/administrador/index.php');
    return;
  }
?>
<nav class="navbar navbar-expand navbar-dark bg-primary">
  <ul class="nav navbar-nav">
    <li class="nav-item">
      <a class="nav-link active" href="#" aria-current="page">Administrador de la Aplicacion<span class="visually-hidden">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $url?>/administrador/inicio.php">Inicio</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $url?>/administrador/section/productos.php">Libros</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $url?>/administrador/section/cerrar.php"">Cerrar</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo $url?>">Sitio Web</a>
    </li>
  </ul>
</nav>