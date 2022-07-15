<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
</head>
<script language="javascript">

function pon_prefijo(descripcion,precio_pvp) {
	opener.document.formulario_lineas.descripcion.value=descripcion;
	opener.document.formulario_lineas.precio.value=precio_pvp;
	opener.document.formulario_lineas.importe.value=precio_pvp;
}

function limpiar() {
	opener.document.formulario_lineas.descripcion.value="";
	opener.document.formulario_lineas.precio.value="";
	opener.document.formulario_lineas.codbarras.value="";
	opener.document.formulario_lineas.codbarras.focus();
}

</script>
<? include ("../conectar.php"); ?>
<body>
<?
	$codbarras=$_GET["codbarras"];
	$consulta="SELECT * FROM articulos WHERE codigobarras='$codbarras' AND borrado=0";
	$rs_tabla = mysqli_query($descriptor,$consulta);
	if (mysqli_num_rows($rs_tabla)>0) {
		?>
		<script languaje="javascript">
		pon_prefijo('<? echo mysqli_result($rs_tabla,0,descripcion) ?>','<? echo mysqli_result($rs_tabla,0,precio_pvp) ?>');
		</script>
		<? 
	} else { ?>
	<script>
	alert ("No existe ningun articulo con ese codigo de barras");
	limpiar();
	</script>
	<? }
?>
</div>
</body>
</html>
