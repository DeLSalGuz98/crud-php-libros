<?php
//eliminar archivo
function DeleteFile($image){
  $path_image = '../../image/';
  if(isset($image) && $image != 'img.jpg'){
    //buscamos si existe el archivo 
    if(file_exists($path_image.$image)){
      unlink($path_image.$image); //elimina el archivo
    }
  }
}
//agregar archivo
function AddFile($image){
  //crear nuevo nombre para la imagen
  $fecha = new DateTime();
  $nameImage = ($image != '')? $fecha->getTimestamp().'_'.$image: 'img.jpg';
  //copiamos la imagen en nuestro servidor
  $tmpImage = $_FILES['img_book']['tmp_name'];
  if($tmpImage != ''){
    //movemos la imagen subida a la carpeta imagenes del servidor
    move_uploaded_file($tmpImage, '../../image/'.$nameImage);
  }

  return $nameImage;
}

?>