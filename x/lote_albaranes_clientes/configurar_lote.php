<?php 
include ("../conectar.php");
include ("../funciones/fechas.php");
 
$cadena_elegidos=$_GET["cadena_elegidos"];
$albaranes=substr($cadena_elegidos,1,strlen($cadena_elegidos)-2);
$albaranes=str_replace("~",",",$albaranes);

$select_albaranes="SELECT codalbaran,totalalbaran,codcliente,iva FROM albaranes WHERE codalbaran IN (".$albaranes.")";
$rs_albaranes=mysqli_query($descriptor,$select_albaranes); 

$hoy=date("d/m/Y");

?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../funciones/validar.js"></script>
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
		<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function cancelar() {
			location.href="index.php";
		}
			
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">FACTURAR ALBARANES </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_facturacion.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
					<? $contador=0;
					   $totalfactura=0;
					   $totalfacturasiniva=0;
					while ($contador < mysqli_num_rows($rs_albaranes)) {
					 	$codcliente=mysqli_result($rs_albaranes,$contador,"codcliente");
						$iva=mysqli_result($rs_albaranes,$contador,"iva"); 
						$totalalbaran=mysqli_result($rs_albaranes,$contador,"totalalbaran");
						$auxiva=($iva/100) + 1;
						$totalalbaransiniva=$totalalbaran/$auxiva;
						$totalfacturasiniva=$totalfacturasiniva+$totalalbaransiniva; 
						?>
						<tr>
							<td width="15%">C&oacute;digo de albar&aacute;n <? echo $contador+1;?></td>
						    <td width="15%"><? echo mysqli_result($rs_albaranes,$contador,"codalbaran");?></td>
				            <td width="20%">Importe sin iva</td>
							<td width="15%"><? echo number_format($totalalbaransiniva,2,",",".");?> &#8364;</td>
							<td width="20%">Importe con iva (<? echo $iva?>%)</td>
							<td width="15%"><? echo number_format($totalalbaran,2,",",".");?> &#8364;</td>
						</tr>
					<? $totalfactura=$totalfactura+mysqli_result($rs_albaranes,$contador,"totalalbaran");
					   $contador++;
						} ?>
						<tr>
							<td width="15%"></td>
						    <td width="15%"></td>
				            <td width="20%"><hr></td>
							<td width="15%"><hr></td>
							<td width="20%"><hr></td>
							<td width="15%"><hr></td>
						</tr>
						<tr>
							<td width="15%"></td>
						    <td width="15%"></td>
				            <td width="20%">Total facturaci&oacute;n sin iva</td>
							<td width="15%"><? echo number_format($totalfacturasiniva,2,",",".");?> &#8364;</td>
							<td width="20%">Total facturaci&oacute;n con iva</td>
							<td width="15%"><? echo number_format($totalfactura,2,",",".");?> &#8364;</td>
						</tr>
						<tr>
							<td width="15%">IVA</td>
						    <td width="15%"><input type="text" name="Ziva" id="Ziva" value="16" class="cajaPequena"> %</td>
				            <td width="20%"><ul id="lista-errores"></ul></td>
							<td width="15%"></td>
							<td width="20%"></td>
							<td width="15%"></td>
						</tr>	
						<tr>
							<td width="15%">Fecha</td>
						    <td width="15%"><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" value="<? echo $hoy?>" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
        <script type="text/javascript">
					Calendar.setup(
					  {
					inputField : "fecha",
					ifFormat   : "%d/%m/%Y",
					button     : "Image1"
					  }
					);
		</script></td>
				            <td width="20%"></td>
							<td width="15%"></td>
							<td width="20%"></td>
							<td width="15%"></td>
						</tr>							
					</table>
			  </div>
				<div id="botonBusqueda">
					<input type="hidden" name="id" id="id" value="">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="convertir" type="hidden">
					<input id="albaranes" name="albaranes" value="<? echo $albaranes?>" type="hidden">
					<input id="iva" name="iva" value="<? echo $iva?>" type="hidden">
					<input id="codcliente" name="codcliente" value="<? echo $codcliente?>" type="hidden">
					<input id="totalfactura" name="totalfactura" value="<? echo $totalfactura?>" type="hidden">
					<input id="totalfacturasiniva" name="totalfacturasiniva" value="<? echo $totalfacturasiniva?>" type="hidden">
			  </div>
			  </form>
			 </div>
		  </div>
		</div>
	</body>
</html>
