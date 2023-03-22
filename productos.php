<?php
include('./administrador/config/db.php');
$books = $connection->query('SELECT * FROM libro');
?>
<?php include( './templates/cabecera.php'); ?>
<?php foreach($books as $book):?>
<div class="col-sm-12 col-md-3">
  <div class="card">
    <div class="card-body">
      <img src="./image/<?=$book['image']?>" class="card-img-top" alt="<?=$book['name']?>" width="200px" height="300px">
      <h4 class="card-title"><?=$book['name']?></h4>
      <button type="button" class="btn btn-primary">Ver mas</button>
    </div>
  </div>
</div>
<?php endforeach?>
<?php include( './templates/pie.php'); ?>