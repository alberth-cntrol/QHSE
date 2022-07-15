<?
$usuarios_sesion="prueba";

session_name($usuarios_sesion);

session_start();

session_destroy();

header ("Location: central2.php");
?>
