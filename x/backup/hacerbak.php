<?php 
include ("../conectar.php"); 
$hoy=date("d/m/Y");
$hora=date("H:i:s");
?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../funciones/validar.js"></script>
		<script language="javascript">
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function limpiar() {
			document.getElementById("formulario").reset();
		}
			
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">NUEVA COPIA DE SEGURIDAD</div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_copia.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="14%">Denominacion</td>
						    <td width="36%"><input NAME="Adenominacion" type="text" class="cajaGrande" id="denominacion" size="50" maxlength="50"></td>
				            <td width="50%"><ul id="lista-errores"></ul></td>
						</tr>
						<tr>
							<td width="14%">Fecha</td>
						    <td width="36%"><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="12" maxlength="12" value="<? echo $hoy?>" readonly="yes"></td>
				            <td width="50%"></td>
						</tr>
						<tr>
							<td width="14%">Hora</td>
						    <td width="36%"><input NAME="hora" type="text" class="cajaPequena" id="hora" size="12" maxlength="12" value="<? echo $hora?>" readonly="yes"></td>
				            <td width="50%"></td>
						</tr>							
					</table>
			  </div>
				<div id="botonBusqueda">
					<input type="hidden" name="id" id="id" value="">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
