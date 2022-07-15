<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$fechainicio=$_GET["fechainicio"];
$minimo=$_GET["minimo"];
$maximo=$_GET["maximo"];
$neto=$_GET["neto"];
$iva=$_GET["iva"];
$total=$_GET["total"];
$contado=$_GET["contado"];
$tarjeta=$_GET["tarjeta"];

 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<script language="javascript">
function imprimir() {
	window.print();
	window.close();
}
</script>
</head>

<body onLoad="imprimir()">
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>

<table width="85%" border="0">
  <tr>
    <td><span class="Estilo3">CODEKA</span></td>
  </tr>
  <tr>
    <td><span class="Estilo3">C/. XXXXXXXXXXXX</span></td>
  </tr>
  <tr>
    <td><span class="Estilo3">Tel.: 000 000 000</span></td>
  </tr>
  <tr>
    <td><span class="Estilo3">00000 - XXXXXXXXX</span></td>
  </tr>
  <tr>
    <td><span class="Estilo3">DEL TICKET N.: <? echo $minimo?> AL TICKET N.: <? echo $maximo?></span></td>
  </tr>
  <tr>
    <td><span class="Estilo3">NETO: <? echo number_format($neto,2,",",".")?> + 16% IVA: <? echo number_format($iva,2,",",".")?></span></td>
  </tr>
  <tr>
    <td><span class="Estilo3">TOTAL: <? echo number_format($total,2,",",".")?> euros</span></td>
  </tr>
   <tr>
    <td><span class="Estilo3">TOTAL CONTADO: <? echo number_format($contado,2,",",".")?> euros</span></td>
  </tr>
   <tr>
    <td><span class="Estilo3">TOTAL TARJETA: <? echo number_format($tarjeta,2,",",".")?> euros</span></td>
  </tr>
   <tr>
    <td><span class="Estilo3">TOTAL: <? echo number_format($total,2,",",".")?> euros</span></td>
  </tr>
</table>
</body>
</html>