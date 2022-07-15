<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
</head>
<? include ("../conectar.php"); 
include ("../funciones/fechas.php");
?>
<body>
<?
	$idmov=$_GET["idmov"];
	$codfactura=$_GET["codfactura"];
	$fechacobro=$_GET["fechacobro"];
	$importe=$_GET["importe"];
	$importe="-".$importe;
	$fecha=explota($fechacobro);
	$act_factura="DELETE FROM cobros WHERE idmov='$idmov' AND codfactura='$codfactura'";
	$rs_act=mysqli_query($descriptor,$act_factura);
	
	//1 compra
	//2 venta
	
	$sel_libro="INSERT INTO librodiario (id,fecha,tipodocumento,coddocumento,codcomercial,codformapago,numpago,total) VALUES 
	('','$fecha','2','$codfactura','','','','$importe')";
	$rs_libro=mysqli_query($descriptor,$sel_libro);
?>
</body>
</html>
