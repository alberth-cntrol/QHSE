<?php 
include ("../conectar.php"); 

?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function ventanaArticulos(){
			miPopup = window.open("ver_articulos.php","miwin","width=700,height=500,scrollbars=yes");
		}
		
		function imprimir() {
			var codigo=document.getElementById("codbarras").value;
			if (codigo=="") {
				alert ("Debe seleccionar un articulo antes de imprimir el codigo de barras");
			} else {
				window.open("../fpdf/codigo.php?codigo="+codigo);
			}
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
				<div id="tituloForm" class="header">Buscar ARTICULO </div>
			  <div id="frmBusqueda">
				<form id="formulario_lineas" name="formulario_lineas" method="post" action="frame_lineas.php" target="frame_lineas">
				<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
				  <tr>
					<td width="15%">Codigo barras </td>
					<td colspan="8" valign="middle"><input NAME="codbarras" type="text" class="cajaMedia" id="codbarras" size="15" maxlength="15" readonly><img src="../img/ver.png" width="16" height="16" onClick="ventanaArticulos()"></td>
				    <td valign="middle">&nbsp;</td>
				    <td rowspan="2" valign="bottom"><div align="center"><img src="../img/codigobarras.jpg" border="1" align="absbottom" onClick="imprimir()" onMouseOver="style.cursor=cursor"></div></td>
				  </tr>
				  <tr>
					<td>Descripcion</td>
					<td><input NAME="descripcion" type="text" class="cajaGrande" id="descripcion" size="50" maxlength="50" readonly></td>
				  </tr>
				</table>
				</div>
				<br>			
			  </div>
			  		<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
