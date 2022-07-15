<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
</head>
<? include ("../conectar.php"); ?>
<body>
<?
	$estado=$_GET["estado"];
	$codfactura=$_GET["codfactura"];
	$codproveedor=$_GET["codproveedor"];
	$act_factura="UPDATE facturasp SET estado='$estado' WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
	$rs_act=mysqli_query($descriptor,$act_factura);
?>
</body>
</html>
