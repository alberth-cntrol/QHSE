<?php 
//include('./conectar.php');
$usuario=$_POST['usuario'];
$contraseña=$_POST['password'];
session_start();
$_SESSION['usuario']=$usuario;


$conexion=mysqli_connect("localhost","root","","basededatos");

$consulta="SELECT*FROM login where usuario='$usuario' and password='$contraseña  '";

$resultado=mysqli_query($conexion,$consulta);


$filas=mysqli_num_rows($resultado);
if($filas){
    header("location:x");

}else{
    ?>
    <?php
    include("index.php");
    ?>
    <h1 class="bad">Error en la autoticacion</h1>
    <?php 
}
mysqli_free_result($resultado);
mysqli_close($conexion);

?>