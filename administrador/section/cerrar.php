<?php
session_start(); //nota: para poder eliminar la session primero hay que iniciarla
//eliminamos la sesion del usuario
session_destroy();
header('Location:../index.php');
?>