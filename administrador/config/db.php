<?php
//conect bd
$host = 'localhost';
$db = 'libros';
$usuario='root';
$password='';
try {
  $connection = new PDO("mysql:host=$host;dbname=$db",$usuario, $password);
} catch(PDOException $error){
  print("ERROR!!: ". $error ->getMessage(). "<br/>");
  die();
}
?>