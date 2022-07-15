<?
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombre=$_POST["Anombre"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO embalajes (codembalaje, nombre, borrado) 
					VALUES ('', '$nombre', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="El embalaje ha sido dado de alta correctamente"; }
	$cabecera1="Inicio >> Embalajes &gt;&gt; Nuevo Embalaje ";
	$cabecera2="INSERTAR EMBALAJE ";
	$sel_maximo="SELECT max(codembalaje) as maximo FROM embalajes";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codembalaje=mysqli_result($rs_maximo,0,"maximo");
}

if ($accion=="modificar") {
	$codembalaje=$_POST["Zid"];
	$query="UPDATE embalajes SET nombre='$nombre', borrado=0 WHERE codembalaje='$codembalaje'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos del embalaje han sido modificados correctamente"; }
	$cabecera1="Inicio >> Embalajes &gt;&gt; Modificar Embalaje ";
	$cabecera2="MODIFICAR EMBALAJE ";
}

if ($accion=="baja") {
	$codembalaje=$_GET["codembalaje"];
	$query_comprobar="SELECT * FROM articulos WHERE codembalaje='$codembalaje' AND borrado=0";
	$rs_comprobar=mysqli_query($descriptor,$query_comprobar);
	if (mysqli_num_rows($rs_comprobar) > 0 ) {
		?><script>
			alert ("No se puede eliminar este embalaje porque tiene articulos asociados.");
			location.href="eliminar_ubicacion.php?codubicacion=<? echo $codubicacion?>";
		</script>
		<?
	} else {
		$query="UPDATE embalajes SET borrado=1 WHERE codembalaje='$codembalaje'";
		$rs_query=mysqli_query($descriptor,$query);
		if ($rs_query) { $mensaje="El embalaje ha sido eliminada correctamente"; }
		$cabecera1="Inicio >> Embalajes &gt;&gt; Eliminar Embalaje ";
		$cabecera2="ELIMINAR EMBALAJE ";
		$query_mostrar="SELECT * FROM embalajes WHERE codembalaje='$codembalaje'";
		$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
		$codembalaje=mysqli_result($rs_mostrar,0,"codembalaje");
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
							<td width="85%" colspan="2"><?php echo $codembalaje?></td>
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
