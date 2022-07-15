<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
</head>
<script language="javascript">

function pon_prefijo(nombre) {
	parent.document.form_busqueda.nombre.value=nombre;
}

function limpiar() {
	parent.document.form_busqueda.nombre.value="";
	parent.document.form_busqueda.codcliente.value="";
}

</script>
<? include ("../conectar.php"); ?>
<body>
<?
	$codcliente=$_GET["codcliente"];
	$consulta="SELECT * FROM clientes WHERE codcliente='$codcliente' AND borrado=0";
	$rs_tabla = mysqli_query($descriptor,$consulta);
	if (mysqli_num_rows($rs_tabla)>0) {
		?>
		<script languaje="javascript">
		pon_prefijo("<? echo mysqli_result($rs_tabla,0,nombre) ?>");
		</script>
		<? 
	} else { ?>
	<script>
	alert ("No existe ningun cliente con ese codigo");
	limpiar();
	</script>
	<? }
?>
</div>
</body>
</html>
