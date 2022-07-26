<?php 
//include('./conectar.php');
$usuario=$_POST['usuario'];
$contraseña=$_POST['password'];
session_start();
$_SESSION['usuario']=$usuario;


$conexion=mysqli_connect("localhost","root","","basededatos");

////////
$consulta="SELECT*FROM clientes where nombre='$usuario' and password='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_fetch_array($resultado);

if($filas['codprovincia']==1){ //administrador
    header("location:x");

}else
if($filas['codprovincia']==4){ //cliente
header("location:x/albaranes_clientes/index.php");
}
else{
    ?>
    <?php
    include("index.html");
    ?>
    <h1 class="bad">ERROR EN LA AUTENTIFICACION</h1>
    <?php
}
?>