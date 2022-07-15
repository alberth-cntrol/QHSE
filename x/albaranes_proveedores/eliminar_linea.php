<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conectar.php");

$codalbaran=$_GET["codalbarantmp"];
$numlinea=$_GET["numlinea"];

$consulta = "DELETE FROM albalineaptmp WHERE codalbaran ='".$codalbaran."' AND numlinea='".$numlinea."'";
$rs_consulta = mysqli_query($descriptor,$consulta);
echo "<script>parent.location.href='frame_lineas.php?codalbarantmp=".$codalbaran."';</script>";

?>