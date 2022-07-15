<?
include ("../conectar.php"); 
include ("../funciones/fechas.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$codfacturatmp=$_POST["codfacturatmp"];
$codcliente=$_POST["codcliente"];
$fecha=explota($_POST["fecha"]);
$iva=$_POST["iva"];
$minimo=0;

if ($accion=="alta") {
	$query_operacion="INSERT INTO facturas (codfactura, fecha, iva, codcliente, estado, borrado) VALUES ('', '$fecha', '$iva', '$codcliente', '1', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	$codfactura=mysqli_insert_id($descriptor);
	if ($rs_operacion) { $mensaje="La factura ha sido dada de alta correctamente"; }
	$query_tmp="SELECT * FROM factulineatmp WHERE codfactura='$codfacturatmp' ORDER BY numlinea ASC";
	$rs_tmp=mysqli_query($descriptor,$query_tmp);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysqli_num_rows($rs_tmp)) {
		$codfamilia=mysqli_result($rs_tmp,$contador,"codfamilia");
		$numlinea=mysqli_result($rs_tmp,$contador,"numlinea");
		$codigo=mysqli_result($rs_tmp,$contador,"codigo");
		$cantidad=mysqli_result($rs_tmp,$contador,"cantidad");
		$precio=mysqli_result($rs_tmp,$contador,"precio");
		$importe=mysqli_result($rs_tmp,$contador,"importe");
		$baseimponible=$baseimponible+$importe;
		$dcto=mysqli_result($rs_tmp,$contador,"dcto");
		$sel_insertar="INSERT INTO factulinea (codfactura,numlinea,codfamilia,codigo,cantidad,precio,importe,dcto) VALUES 
		('$codfactura','$numlinea','$codfamilia','$codigo','$cantidad','$precio','$importe','$dcto')";
		$rs_insertar=mysqli_query($descriptor,$sel_insertar);		
		$sel_articulos="UPDATE articulos SET stock=(stock-'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_articulos=mysqli_query($descriptor,$sel_articulos);
		$sel_minimos = "SELECT stock,stock_minimo,descripcion FROM articulos where codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_minimos= mysqli_query($descriptor,$sel_minimos);
		if ((mysqli_result($rs_minimos,0,"stock") < mysqli_result($rs_minimos,0,"stock_minimo")) or (mysqli_result($rs_minimos,0,"stock") <= 0))
	   		{ 
		  		@$mensaje_minimo=$mensaje_minimo . " " . mysqli_result($rs_minimos,0,"descripcion")."<br>";
				$minimo=1;
   			};
		$contador++;
	}
	$baseimpuestos=$baseimponible*($iva/100);
	$preciototal=$baseimponible+$baseimpuestos;
	//$preciototal=number_format($preciototal,2);	
	$sel_act="UPDATE facturas SET totalfactura='$preciototal' WHERE codfactura='$codfactura'";
	$rs_act=mysqli_query($descriptor,$sel_act);
	$baseimpuestos=0;
	$baseimponible=0;
	$preciototal=0;
	$cabecera1="Inicio >> Ventas &gt;&gt; Venta Mostrador ";
	$cabecera2="NUEVA VENTA ";
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
		
		function imprimir(codfactura) {
			window.open("../fpdf/imprimir_factura.php?codfactura="+codfactura);
		}
		
		function efectuarpago(codfactura,codcliente,importe) {
			miPopup = window.open("efectuarpago.php?codfactura="+codfactura+"&codcliente="+codcliente+"&importe="+importe,"miwin","width=500,height=360,scrollbars=yes");			
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
						<? if ($minimo==1) { ?>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensajeminimo">Los siguientes art&iacute;culos est&aacute;n bajo m&iacute;nimo:<br><?php echo $mensaje_minimo;?></td>
					    </tr>
						<? } 
						 $sel_cliente="SELECT * FROM clientes WHERE codcliente='$codcliente'"; 
						  $rs_cliente=mysqli_query($descriptor,$sel_cliente); ?>
						<tr>
							<td width="15%">Cliente</td>
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
						  <td>C&oacute;digo de factura</td>
						  <td colspan="2"><?php echo $codfactura?></td>
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
							<td width="20%">FAMILIA</td>
							<td width="15%">REFERENCIA</td>
							<td width="30%">DESCRIPCION</td>
							<td width="7%">CANTIDAD</td>
							<td width="8%">PRECIO</td>
							<td width="7%">DCTO %</td>
							<td width="8%">IMPORTE</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
					  <? $sel_lineas="SELECT factulinea.*,articulos.*,familias.nombre as nombrefamilia FROM factulinea,articulos,familias WHERE factulinea.codfactura='$codfactura' AND factulinea.codigo=articulos.codarticulo AND factulinea.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulinea.numlinea ASC";
$rs_lineas=mysqli_query($descriptor,$sel_lineas);
						for ($i = 0; $i < mysqli_num_rows($rs_lineas); $i++) {
							$numlinea=mysqli_result($rs_lineas,$i,"numlinea");
							$codfamilia=mysqli_result($rs_lineas,$i,"codfamilia");
							$nombrefamilia=mysqli_result($rs_lineas,$i,"nombrefamilia");
							$codarticulo=mysqli_result($rs_lineas,$i,"codarticulo");
							$referencia=mysqli_result($rs_lineas,$i,"referencia");
							$descripcion=mysqli_result($rs_lineas,$i,"descripcion");
							$cantidad=mysqli_result($rs_lineas,$i,"cantidad");
							$precio=mysqli_result($rs_lineas,$i,"precio");
							$importe=mysqli_result($rs_lineas,$i,"importe");
							$baseimponible=$baseimponible+$importe;
							$descuento=mysqli_result($rs_lineas,$i,"dcto");
							if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; } ?>
									<tr class="<? echo $fondolinea?>">
										<td width="5%" class="aCentro"><? echo $i+1?></td>
										<td width="20%"><? echo $nombrefamilia?></td>
										<td width="15%"><? echo $referencia?></td>
										<td width="30%"><? echo $descripcion?></td>
										<td width="7%" class="aCentro"><? echo $cantidad?></td>
										<td width="8%" class="aCentro"><? echo $precio?></td>
										<td width="7%" class="aCentro"><? echo $descuento?></td>
										<td width="8%" class="aCentro"><? echo $importe?></td>
									</tr>
					<? } ?>
					</table>
			  </div>
				  <?
				  $baseimpuestos=$baseimponible*($iva/100);
			      $preciototal=$baseimponible+$baseimpuestos;
			      $preciototal=number_format($preciototal,2);
			  	  ?>
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
					  <img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
					   <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir(<? echo $codfactura?>)" onMouseOver="style.cursor=cursor">
				        </div>
						<br>
						<div align="center" id="cajareg">
					  <img src="../img/caja.jpg" width="80" height="77" border="1" onClick="efectuarpago(<? echo $codfactura?>,<? echo $codcliente?>,<? echo $preciototal?>)" onMouseOver="style.cursor=cursor" title="Efectuar pago">
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
