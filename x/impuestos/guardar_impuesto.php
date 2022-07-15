<?
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombre=$_POST["Anombre"];
$valor=$_POST["Qvalor"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO impuestos (codimpuesto, nombre, valor, borrado) 
					VALUES ('', '$nombre', '$valor', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="El impuesto ha sido dado de alta correctamente"; }
	$cabecera1="Inicio >> Impuestos &gt;&gt; Nuevo Impuesto ";
	$cabecera2="INSERTAR IMPUESTO ";
	$sel_maximo="SELECT max(codimpuesto) as maximo FROM impuestos";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codimpuesto=mysqli_result($rs_maximo,0,"maximo");
}

if ($accion=="modificar") {
	$codimpuesto=$_POST["Zid"];
	$query="UPDATE impuestos SET nombre='$nombre', valor='$valor', borrado=0 WHERE codimpuesto='$codimpuesto'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos del impuesto han sido modificados correctamente"; }
	$cabecera1="Inicio >> Impuestos &gt;&gt; Modificar Impuesto ";
	$cabecera2="MODIFICAR IMPUESTO ";
}

if ($accion=="baja") {
	$query="UPDATE impuestos SET borrado=1 WHERE codimpuesto='$codimpuesto'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="El impuesto ha sido eliminado correctamente"; }
	$cabecera1="Inicio >> Impuestos &gt;&gt; Eliminar Impuesto ";
	$cabecera2="ELIMINAR IMPUESTO ";
	$query_mostrar="SELECT * FROM impuestos WHERE codimpuesto='$codimpuesto'";
	$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
	$codimpuesto=mysqli_result($rs_mostrar,0,"codimpuesto");
	$nombre=mysqli_result($rs_mostrar,0,"nombre");
	$valor=mysqli_result($rs_mostrar,0,"valor");
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
							<td width="85%" colspan="2"><?php echo $codimpuesto?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre?></td>
					    </tr>
						<tr>
							<td width="15%">Valor</td>
							<td width="85%" colspan="2"><?php echo $valor?> %</td>
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
