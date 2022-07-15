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
	$act_factura="UPDATE facturas SET estado='$estado' WHERE codfactura='$codfactura'";
	$rs_act=mysqli_query($descriptor,$act_factura);
?>
</body>
</html>
