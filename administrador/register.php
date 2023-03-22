<?php 
  include('./config/db.php');
  if($_POST){
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    //encriptamos el password
    $encript_pass = password_hash($pass, PASSWORD_BCRYPT);
    //almacenamos los datos
    $sql = $connection->prepare('INSERT INTO user(username, password) VALUES(:username, :password)');
    $sql->execute([
      ":username" => $user,
      ":password" => $encript_pass
    ]);

    //iniciamos la session del usuario
    $sql = $connection->prepare('SELECT * FROM user WHERE username = :username');
    $sql->execute([":username" => $user]);
    $user_data = $sql->fetch(PDO::FETCH_ASSOC);
    //inicializamos la session con los datos del usuario
    session_start();
    $_SESSION['session_user'] = $user_data;
    header('Location:inicio.php');
  }
?>
<?php include('./template/cabecera.php') ?>
    <div class="container">
      <div class="row justify-content-center pt-5">
        <div class="card bg-light col-md-4">
          <div class="card-body">
            <h4 class="card-title">Registrar Usuario</h4>
            <form method="POST">
              <div class = "form-group">
                <label for="user">Usuario</label>
                <input type="text" class="form-control" name="user" required>
              </div>
              <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" class="form-control" name="pass" required>
              </div>
              <input type="submit" class="btn btn-primary mt-3" value="Registrar">
            </form>
          </div>
        </div>
      </div>
    </div>
<?php include('./template/pie.php') ?>