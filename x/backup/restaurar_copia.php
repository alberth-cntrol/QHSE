<?php
include ("../conectar.php"); 
include ("../funciones/fechas.php");

$id=$_GET["id"];
$fecha=date("d/m/Y");
$hora=time();

$archivo="../copias/copia".$id.".sql";

$sistema="show variables where variable_name= 'basedir'";
$rs_sistema=mysqli_query($descriptor,$sistema);
$DirBase=mysqli_result($rs_sistema,0,"value");
$primero=substr($DirBase,0,1);
if ($primero=="/") {
	$DirBase="mysql";
} else {
	$DirBase=$DirBase."\bin\mysql";
}

$executa = "$DirBase -h $Servidor -u $Usuario --password=$Password  $BaseDeDatos < $archivo";

system($executa, $resultado);


if ($resultado) { echo "<H1>Error ejecutando comando: $executa</H1>\n"; } 


if ($resultado) {
	$mensaje="ERROR. La copia de seguridad no se ha restaurado completamente.";
	$cabecera2="COPIA DE SEGURIDAD NO RESTAURADA";
} else {
	$mensaje="La copia de seguridad se ha restaurado correctamente."; 
	$cabecera2="COPIA DE SEGURIDAD RESTAURADA";
}

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
							<td width="15%">Estado</td>
							<td width="85%" colspan="2">Restauraci&oacute;n correcta</td>
					    </tr>
						<tr>
							<td width="15%">Fecha</td>
						    <td width="85%" colspan="2"><?php echo $fecha?></td>
					    </tr>
						<tr>
							<td width="15%">Hora</td>
						    <td width="85%" colspan="2"><?php echo $hora?></td>
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
