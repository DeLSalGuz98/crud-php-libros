<?php
  include('./config/db.php');
  session_start();
  if(isset($_SESSION['session_user'])){
    header('Location:inicio.php');
    return;
  }
  if($_POST){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $sql = $connection->prepare('SELECT * FROM user WHERE username = :username');
    $sql->execute([":username"=>$user]);
    //verificar contraseña
    if($sql->rowCount() != 0){
      $data_user = $sql->fetch(PDO::FETCH_ASSOC);
      if(password_verify($pass, $data_user['password'])){
        //creamos la session del usuario
        session_start();
        $_SESSION['session_user'] = $data_user;
        header('Location:inicio.php');
      }
    }
  }
?>
<?php include('./template/cabecera.php') ?>
    <div class="container">
      <div class="row justify-content-center pt-5">
        <div class="card bg-light col-md-4">
          <div class="card-body">
            <h4 class="card-title">Login Form</h4>
            <form method="POST">
              <div class = "form-group">
                <label for="user">Usuario</label>
                <input type="text" class="form-control" name="user">
              </div>
              <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" class="form-control" name="pass">
              </div>
              <input type="submit" class="btn btn-primary mt-3" value="Entrar al Administrador">
              <br>
              <a href="register.php" class="btn btn-link">Registrar Usuario</a>
            </form>
          </div>
        </div>
      </div>
    </div>
<?php include('./template/pie.php') ?>