<html>
<head>
<title>Observaciones</title>
<script>
var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
</script>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="pagina">
	<div id="zonaContenido">
		<div align="center">
			<div id="tituloForm" class="header">Observaciones</div>
			<div id="frmBusqueda">
<? $observaciones=$_GET["observaciones"]; ?>
<table width="100%" border="0">
  <tr>
    <td><div align="center">
      <textarea name="observaciones" cols="30" rows="5" class="areaTexto" readonly="readonly"><? echo $observaciones?></textarea>
    </div></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td><div align="center">
      <img src="../img/botoncerrar.jpg" width="70" height="22" onClick="window.close()" border="1" onMouseOver="style.cursor=cursor">
    </div></td>
  </tr>
</table>
</div>
</div>
</div>
</body>
</html>
