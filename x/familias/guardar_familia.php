<?
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombre=$_POST["Anombre"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO familias (codfamilia, nombre, borrado) 
					VALUES ('', '$nombre', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="La familia ha sido dada de alta correctamente"; }
	$cabecera1="Inicio >> Familias &gt;&gt; Nueva Familia ";
	$cabecera2="INSERTAR FAMILIA ";
	$sel_maximo="SELECT max(codfamilia) as maximo FROM familias";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codfamilia=mysqli_result($rs_maximo,0,"maximo");
}

if ($accion=="modificar") {
	$codfamilia=$_POST["Zid"];
	$query="UPDATE familias SET nombre='$nombre', borrado=0 WHERE codfamilia='$codfamilia'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos de la familia han sido modificados correctamente"; }
	$cabecera1="Inicio >> Familias &gt;&gt; Modificar Familia ";
	$cabecera2="MODIFICAR FAMILIA ";
}

if ($accion=="baja") {
	$codfamilia=$_GET["codfamilia"];
	$query_comprobar="SELECT * FROM articulos WHERE codfamilia='$codfamilia' AND borrado=0";
	$rs_comprobar=mysqli_query($descriptor,$query_comprobar);
	if (mysqli_num_rows($rs_comprobar) > 0 ) {
		?><script>
			alert ("No se puede eliminar esta familia porque tiene articulos asociados.");
			location.href="eliminar_familia.php?codfamilia=<? echo $codfamilia?>";
		</script>
		<?
	} else {
		$query="UPDATE familias SET borrado=1 WHERE codfamilia='$codfamilia'";
		$rs_query=mysqli_query($descriptor,$query);
		if ($rs_query) { $mensaje="La familia ha sido eliminada correctamente"; }
		$cabecera1="Inicio >> Familias &gt;&gt; Eliminar Familia ";
		$cabecera2="ELIMINAR FAMILIA ";
		$query_mostrar="SELECT * FROM familias WHERE codfamilia='$codfamilia'";
		$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
		$codfamilia=mysqli_result($rs_mostrar,0,"codfamilia");
		$nombre=mysqli_result($rs_mostrar,0,"nombre");
	}
}

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="index.php";
		}
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php echo $mensaje;?></td>
					    </tr>
						<tr>
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codfamilia?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre?></td>
					    </tr>						
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>
