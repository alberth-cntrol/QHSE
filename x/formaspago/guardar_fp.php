<?
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombrefp=$_POST["Anombrefp"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO formapago (codformapago, nombrefp, borrado) 
					VALUES ('', '$nombrefp', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="La forma de pago ha sido dada de alta correctamente"; }
	$cabecera1="Inicio >> Formas de pago &gt;&gt; Nueva Forma de Pago ";
	$cabecera2="INSERTAR FORMA DE PAGO ";
	$sel_maximo="SELECT max(codformapago) as maximo FROM formapago";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codformapago=mysqli_result($rs_maximo,0,"maximo");
}

if ($accion=="modificar") {
	$codformapago=$_POST["Zid"];
	$query="UPDATE formapago SET nombrefp='$nombrefp', borrado=0 WHERE codformapago='$codformapago'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos de la forma de pago han sido modificados correctamente"; }
	$cabecera1="Inicio >> Forma de pago &gt;&gt; Modificar Forma de Pago ";
	$cabecera2="MODIFICAR FORMA DE PAGO ";
}

if ($accion=="baja") {
	$codformapago=$_GET["codformapago"];
	$query_comprobar="SELECT * FROM clientes WHERE codformapago='$codformapago' AND borrado=0";
	$rs_comprobar=mysqli_query($descriptor,$query_comprobar);
	if (mysqli_num_rows($rs_comprobar) > 0 ) {
		?><script>
			alert ("No se puede eliminar esta forma de pago porque tiene clientes asociados.");
			location.href="eliminar_fp.php?codformapago=<? echo $codformapago?>";
		</script>
		<?
	} else {
		$query="UPDATE formapago SET borrado=1 WHERE codformapago='$codformapago'";
		$rs_query=mysqli_query($descriptor,$query);
		if ($rs_query) { $mensaje="La forma de pago ha sido eliminada correctamente"; }
		$cabecera1="Inicio >> Formas de pago &gt;&gt; Eliminar Forma de Pago ";
		$cabecera2="ELIMINAR FORMA DE PAGO ";
		$query_mostrar="SELECT * FROM formapago WHERE codformapago='$codformapago'";
		$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
		$codformapago=mysqli_result($rs_mostrar,0,"codformapago");
		$nombrefp=mysqli_result($rs_mostrar,0,"nombrefp");
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
							<td width="85%" colspan="2"><?php echo $codformapago?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombrefp?></td>
					    </tr>						
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
		  </div>
		</div>
	</body>
</html>
