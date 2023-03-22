<?php
  include('../config/db.php');
  $id = $_GET['id'];
  $image = $_GET['image'];
  try {
    //ELIMINAR IMAGEN - nota funciona con cualquier archivo
    $path_image = '../../image/';
    if(isset($image) && $image != 'img.jpg'){
      //buscamos si existe el archivo 
      if(file_exists($path_image.$image)){
        unlink($path_image.$image); //elimina el archivo
      }
    }
    //Eliminamos el elemento de la base de datos
    $sql = $connection->prepare('DELETE FROM libro WHERE id=:id');
    $sql->bindParam(':id', $id);
    $sql->execute();
    header('Location:productos.php');
  } catch (Exception $e) {
    echo $e->getMessage();
  }
?>