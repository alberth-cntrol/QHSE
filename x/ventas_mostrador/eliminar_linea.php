<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conectar.php");

$codfactura=$_GET["codfacturatmp"];
$numlinea=$_GET["numlinea"];

$consulta = "DELETE FROM factulineatmp WHERE codfactura ='".$codfactura."' AND numlinea='".$numlinea."'";
$rs_consulta = mysqli_query($descriptor,$consulta);
echo "<script>parent.location.href='frame_lineas.php?codfacturatmp=".$codfactura."';</script>";
?>
<script>parent.document.getElementById("codbarras").focus();</script>