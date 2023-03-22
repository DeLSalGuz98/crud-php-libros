<?php
  include('../config/db.php');
  include('./imgUpdate.php');
  $id_book = (isset($_POST['id_book']))?$_POST['id_book']:'';
  $name_book = (isset($_POST['name_book']))?$_POST['name_book']:'';
  $image_book = (isset($_FILES['img_book']['name']))?$_FILES['img_book']['name']:'';
  $action = (isset($_POST['action']))?$_POST['action']:'';
  if($_POST){
    if($action == 'Guardar'){
      //para modificar valores consultas elaboradas de la base de datos es mejor 'prepare'
      $sentencia_sql = $connection->prepare("INSERT INTO libro(id,name,image) VALUES (:id, :name, :image)");
      // SUBIR IMAGENES - nota funciona con cualquier tipo de archivo
      //crear nuevo nombre para la imagen
      $fecha = new DateTime();
      $nameImage = ($image_book != '')? $fecha->getTimestamp().'_'.$image_book: 'img.jpg';
      //copiamos la imagen en nuestro servidor
      $tmpImage = $_FILES['img_book']['tmp_name'];
      if($tmpImage != ''){
        //movemos la imagen subida a la carpeta imagenes del servidor
        move_uploaded_file($tmpImage, '../../image/'.$nameImage);
      }
      //guardamos los datos
      $sentencia_sql->bindParam(":id", $id_book);
      $sentencia_sql->bindParam(":name", $name_book);
      $sentencia_sql->bindParam(":image", $nameImage);
      $sentencia_sql->execute();
    }elseif($action == 'Editar'){
      //obtengo los parametros
      $id_param = $_GET['id'];
      $image_param = $_GET['image'];
      //llamamos a las funciones del modulo imgUpdate
      DeleteFile($image_param); //eliminar imagen
      $newNameImage = AddFile($image_book);
      //actualizamos los valores de la base de datos
      $sentencia_sql = $connection->prepare('UPDATE libro SET id = :newID, name = :newName, image = :newImage WHERE id= :idParam ');
      $sentencia_sql->execute([
        ":newID"=>$id_book,
        ":newName"=>$name_book,
        ":newImage"=>$newNameImage,
        ":idParam"=>$id_param
      ]);
      header('Location:productos.php');
    }
    elseif($action == 'Cancelar'){
      header('Location:productos.php');
    }
  }
  elseif($_GET){
    $id = $_GET['id'];
    $edit_book = $connection->prepare('SELECT id, name FROM libro WHERE id=:id');
    $edit_book->bindParam(':id', $id);
    $edit_book->execute();
    $data_edit_book = $edit_book->fetch(PDO::FETCH_ASSOC);
  }
  //para obtener valores o hacer consultas simples a la base de datos es mejor 'query'
  $books = $connection->query('SELECT * FROM libro');
?>
<?php include('../template/cabecera.php'); ?>
<?php include('../template/nav.php');?>
<div class="container">
  <div class="row">
    <div class="col-md-5 pt-2">
      <div class="card">
        <div class="card-header">
          Datos del Libro
        </div>
        <div class="card-body">
          <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="id_book">ID</label>
            <input type="text" class="form-control" name="id_book" <?php $_GET?print'disabled':print'' ?> value="<?php $_GET?print$data_edit_book['id']:print"" ?>" required>
          </div>
          <div class="form-group">
            <label for="name_book">Name</label>
            <input type="text" class="form-control" name="name_book" value="<?php $_GET?print$data_edit_book['name']:print"" ?>" required>
          </div>
          <div class="form-group">
            <label for="img_book">Imagen</label>
            <input type="file" class="form-control" name="img_book" required>
          </div>
          <?php if($_GET):?>
            <input type="submit" name="action" class="btn btn-warning mt-3" value="Editar">
            <a href="cancelar.php" class="btn btn-danger mt-3">Cancelar</a>
          <?php else:?>
            <input type="submit" name="action" class="btn btn-primary mt-3" value="Guardar">
          <?php endif?>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7 pt-2">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Imagen</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($books as $book): ?>
          <tr>
            <td><?= $book['id'] ?></td>
            <td><?= $book['name']?></td>
            <td><img src="<?='../../image/'.$book['image']?>" alt="<?= $book['name']?>" width="50px"></td>
            <td><a class="btn btn-warning btn-sm" href="productos.php?id=<?=$book['id']?>&image=<?=$book['image']?>">Editar</a> <a class="btn btn-danger btn-sm" href="delete.php?id=<?=$book['id']?>&image=<?=$book['image']?>">Eliminar</a></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include('../template/pie.php'); ?>