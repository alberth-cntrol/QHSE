<?php
include ("../conectar.php");
include ("../funciones/fechas.php"); 
@$codalbaran=$_GET["codalbaran"];
@$codproveedor=$_GET["codproveedor"];
@$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT * FROM albaranesp WHERE codalbaran='$codalbaran' AND codproveedor='$codproveedor'";
$rs_query=mysqli_query($descriptor,$query);
$codproveedor=mysqli_result($rs_query,0,"codproveedor");
$fecha=mysqli_result($rs_query,0,"fecha");
$iva=mysqli_result($rs_query,0,"iva");

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
		
		function aceptar(codalbaran,codproveedor) {
			location.href="guardar_albaran.php?codalbaran=" + codalbaran + "&codproveedor=" + codproveedor + "&accion=baja" + "&cadena_busqueda=<? echo $cadena_busqueda?>";
		}
		
		function cancelar() {
			location.href="index.php?cadena_busqueda=<? echo $cadena_busqueda?>";
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">ELIMINAR ALBAR&Aacute;N </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<? 
						 $sel_cliente="SELECT * FROM proveedores WHERE codproveedor='$codproveedor'"; 
						  $rs_cliente=mysqli_query($descriptor,$sel_cliente); ?>
						<tr>
							<td width="15%">Proveedor</td>
							<td width="85%" colspan="2"><?php echo mysqli_result($rs_cliente,0,"nombre");?></td>
					    </tr>
						<tr>
							<td width="15%">NIF / CIF</td>
						    <td width="85%" colspan="2"><?php echo mysqli_result($rs_cliente,0,"nif");?></td>
					    </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php echo mysqli_result($rs_cliente,0,"direccion"); ?></td>
					  </tr>
						<tr>
						  <td>C&oacute;digo de albar&aacute;n</td>
						  <td colspan="2"><?php echo $codalbaran?></td>
					  </tr>
					  <tr>
						  <td>Fecha</td>
						  <td colspan="2"><?php echo implota($fecha)?></td>
					  </tr>
					  <tr>
						  <td>IVA</td>
						  <td colspan="2"><?php echo $iva?> %</td>
					  </tr>
					  <tr>
						  <td></td>
						  <td colspan="2"></td>
					  </tr>
				  </table>
					 <table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="5%">ITEM</td>
							<td width="20%">REFERENCIA</td>
							<td width="40%">DESCRIPCION</td>
							<td width="8%">CANTIDAD</td>
							<td width="10%">PRECIO</td>
							<td width="7%">DCTO %</td>
							<td width="10%">IMPORTE</td>
							<td width="5%">&nbsp;</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
					  <? $sel_lineas="SELECT * FROM albalineap,articulos WHERE albalineap.codalbaran='$codalbaran' AND albalineap.codproveedor='$codproveedor' AND albalineap.codigo=articulos.codarticulo AND albalineap.codfamilia=articulos.codfamilia ORDER BY albalineap.numlinea ASC";
$rs_lineas=mysqli_query($descriptor,$sel_lineas);
						for ($i = 0; $i < mysqli_num_rows($rs_lineas); $i++) {
							$numlinea=mysqli_result($rs_lineas,$i,"numlinea");
							$codfamilia=mysqli_result($rs_lineas,$i,"codfamilia");
							$codarticulo=mysqli_result($rs_lineas,$i,"codarticulo");
							$descripcion=mysqli_result($rs_lineas,$i,"descripcion");
							$referencia=mysqli_result($rs_lineas,$i,"referencia");
							$cantidad=mysqli_result($rs_lineas,$i,"cantidad");
							$precio=mysqli_result($rs_lineas,$i,"precio");
							$importe=mysqli_result($rs_lineas,$i,"importe");
							$descuento=mysqli_result($rs_lineas,$i,"dcto");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<? echo $fondolinea?>">
										<td width="5%" class="aCentro"><? echo $i+1?></td>
										<td width="20%"><? echo $referencia?></td>
										<td width="40%"><? echo $descripcion?></td>
										<td width="8%" class="aCentro"><? echo $cantidad?></td>
										<td width="10%" class="aCentro"><? echo $precio?></td>
										<td width="7%" class="aCentro"><? echo $descuento?></td>
										<td width="10%" class="aCentro"><? echo $importe?></td>
									</tr>
									<? $baseimponible=$baseimponible+$importe; ?>
					<? } ?>
					</table>
			  </div>
			  <? $baseimpuestos=$baseimponible*($iva/100);
				$preciototal=$baseimponible+$baseimpuestos;
				$preciototal=number_format($preciototal,2); ?>
					<div id="frmBusqueda">
					<table width="25%" border=0 align="right" cellpadding=3 cellspacing=0 class="fuente8">
						<tr>
							<td width="15%">Base imponible</td>
							<td width="15%"><?php echo number_format($baseimponible,2);?> &#8364;</td>
						</tr>
						<tr>
							<td width="15%">IVA</td>
							<td width="15%"><?php echo number_format($baseimpuestos,2);?> &#8364;</td>
						</tr>
						<tr>
							<td width="15%">Total</td>
							<td width="15%"><?php echo $preciototal?> &#8364;</td>
						</tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<div align="center">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar('<? echo $codalbaran?>',<? echo $codproveedor?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
