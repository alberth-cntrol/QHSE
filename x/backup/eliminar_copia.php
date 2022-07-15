<?
include ("../conectar.php"); 
include ("../funciones/fechas.php");

$id=$_GET["id"];

$sel_borrar="DELETE FROM tabbackup WHERE id='$id'";
$rs_borrar=mysqli_query($descriptor,$sel_borrar);

$archivo="../copias/copia".$id.".sql";

unlink ($archivo);

$mensaje="La copia de seguridad se ha eliminado correctamente."; 
$cabecera2="ELIMINAR COPIA DE SEGURIDAD";

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="restaurarbak.php";
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
							<td width="15%">Proceso</td>
							<td width="85%" colspan="2">Borrado correctamente</td>
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
