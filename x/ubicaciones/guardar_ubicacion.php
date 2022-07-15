<?
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombre=$_POST["Anombre"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO ubicaciones (codubicacion, nombre, borrado) 
					VALUES ('', '$nombre', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="La ubicaci&oacute;n ha sido dada de alta correctamente"; }
	$cabecera1="Inicio >> Ubicaciones &gt;&gt; Nueva Ubicaci&oacute;n ";
	$cabecera2="INSERTAR UBICACI&Oacute;N ";
	$sel_maximo="SELECT max(codubicacion) as maximo FROM ubicaciones";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codubicacion=mysqli_result($rs_maximo,0,"maximo");
}

if ($accion=="modificar") {
	$codubicacion=$_POST["Zid"];
	$query="UPDATE ubicaciones SET nombre='$nombre', borrado=0 WHERE codubicacion='$codubicacion'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos de la ubicaci&oacute;n han sido modificados correctamente"; }
	$cabecera1="Inicio >> Ubicaciones &gt;&gt; Modificar Ubiaci&oacute;n ";
	$cabecera2="MODIFICAR UBICACI&Oacute;N ";
}

if ($accion=="baja") {
	$codubicacion=$_GET["codubicacion"];
	$query_comprobar="SELECT * FROM articulos WHERE codubicacion='$codubicacion' AND borrado=0";
	$rs_comprobar=mysqli_query($descriptor,$query_comprobar);
	if (mysqli_num_rows($rs_comprobar) > 0 ) {
		?><script>
			alert ("No se puede eliminar esta ubicacion porque tiene articulos asociados.");
			location.href="eliminar_ubicacion.php?codubicacion=<? echo $codubicacion?>";
		</script>
		<?
	} else {
		$query="UPDATE ubicaciones SET borrado=1 WHERE codubicacion='$codubicacion'";
		$rs_query=mysqli_query($descriptor,$query);
		if ($rs_query) { $mensaje="La ubicaci&oacute;n ha sido eliminada correctamente"; }
		$cabecera1="Inicio >> Ubicaciones &gt;&gt; Eliminar Ubicaci&oacute;n ";
		$cabecera2="ELIMINAR UBICACI&Oacute;N ";
		$query_mostrar="SELECT * FROM ubicaciones WHERE codubicacion='$codubicacion'";
		$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
		$codubicacion=mysqli_result($rs_mostrar,0,"codubicacion");
		$nombre=mysqli_result($rs_mostrar,0,"nombre");
	}
}

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function aceptar() {
			location.href="index.php";
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
							<td width="85%" colspan="2"><?php echo $codubicacion?></td>
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
