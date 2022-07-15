<?
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conectar.php"); 
include ("../funciones/fechas.php");
include ("../barcode/barcode.php");

@$codarticulo=$_GET["codarticulo"];
@$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT * FROM articulos WHERE codarticulo='$codarticulo'";
$rs_query=mysqli_query($descriptor,$query);
$codigobarras=mysqli_result($rs_query,0,"codigobarras");

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
		
		function aceptar(codarticulo) {
			location.href="guardar_articulo.php?codarticulo=" + codarticulo + "&accion=baja" + "&cadena_busqueda=<? echo $cadena_busqueda?>";
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
				<div id="tituloForm" class="header">ELIMINAR ARTICULO </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="22%">Codigo:</td>
						    <td width="38%"><? echo mysqli_result($rs_query,0,"codarticulo")?></td>
					        <td width="40%" rowspan="11" align="center" valign="top"><img src="../fotos/<? echo mysqli_result($rs_query,0,"imagen")?>" width="160px" height="140px" border="1"></td>
						</tr>
						<tr>
							<td width="22%">Referencia</td>
							<?php $referencia=mysqli_result($rs_query,0,"referencia");?>
							<td width="38%"><? echo mysqli_result($rs_query,0,"referencia")?></td>
				        </tr>
						<?php
						$codfamilia=mysqli_result($rs_query,0,"codfamilia");
					  	$query_familia="SELECT * FROM familias WHERE codfamilia='$codfamilia'";
						$res_familia=mysqli_query($descriptor,$query_familia);
						$nombrefamilia=mysqli_result($res_familia,0,"nombre");
					  ?>
						<tr>
							<td width="22%">Familia</td>
							<td width="38%"><?php echo $nombrefamilia?></td>
				        </tr>
						<tr>
							<td width="22%">Descripci&oacute;n</td>
						    <td width="38%"><? echo mysqli_result($rs_query,0,"descripcion")?></td>
				        </tr>
						<tr>
						  <td>Impuesto</td>
						  <td><? echo mysqli_result($rs_query,0,"impuesto")?> %</td>
				      </tr>
					  <?php
					  	$codproveedor1=mysqli_result($rs_query,0,"codproveedor1");
					  	if ($codproveedor1<>0) {
							$query_proveedor="SELECT * FROM proveedores WHERE codproveedor='$codproveedor1'";
							$res_proveedor=mysqli_query($descriptor,$query_proveedor);
							$nombreproveedor=mysqli_result($res_proveedor,0,"nombre");
						} else {
							$nombreproveedor="Sin determinar";
						}
					  ?>
						<tr>
							<td width="22%">Proveedor1</td>
							<td width="38%"><?php echo $nombreproveedor?></td>
				        </tr>
					<?php
						$codproveedor2=mysqli_result($rs_query,0,"codproveedor2");
					  	if ($codproveedor2<>0) {
							$query_proveedor="SELECT * FROM proveedores WHERE codproveedor='$codproveedor2'";
							$res_proveedor=mysqli_query($descriptor,$query_proveedor);
							$nombreproveedor=mysqli_result($res_proveedor,0,"nombre");
						} else {
							$nombreproveedor="Sin determinar";
						}
					  ?>
						<tr>
							<td width="22%">Proveedor2</td>
							<td width="38%"><?php echo $nombreproveedor?></td>
				        </tr>
						<tr>
							<td width="22%">Descripci&oacute;n corta</td>
						    <td width="38%"><?php echo mysqli_result($rs_query,0,"descripcion_corta")?></td>
				        </tr>
						<?php
						$codubicacion=mysqli_result($rs_query,0,"codubicacion");
					  	if ($codubicacion<>0) {
							$query_ubicacion="SELECT * FROM ubicaciones WHERE codubicacion='$codubicacion'";
							$res_ubicacion=mysqli_query($descriptor,$query_ubicacion);
							$nombreubicacion=mysqli_result($res_ubicacion,0,"nombre");
						} else {
							$nombreubicacion="Sin determinar";
						}
					  ?>
						<tr>
							<td width="22%">Ubicaci&oacute;n</td>
							<td width="38%"><?php echo $nombreubicacion?></td>
				        </tr>
						<tr>
							<td>Stock</td>
							<td><?php echo mysqli_result($rs_query,0,"stock")?> unidades</td>
					    </tr>
						<tr>
							<td>Stock minimo</td>
							<td><?php echo mysqli_result($rs_query,0,"stock_minimo")?> unidades</td>
					    </tr>
						<tr>
							<td>Aviso M&iacute;nimo</td>
							<td colspan="2"><?php if (mysqli_result($rs_query,0,"aviso_minimo")==0) { echo "No"; } else { echo "Si"; }?></td>
						</tr>
						<tr>
							<td width="22%">Datos del producto</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"datos_producto")?></td>
					    </tr>
						<tr>
							<td width="22%">Fecha de alta</td>
							<td colspan="2"><?php echo implota(mysqli_result($rs_query,0,"fecha_alta"))?></td>
					    </tr>
						<?php
						$codembalaje=mysqli_result($rs_query,0,"codembalaje");
					  	if ($codembalaje<>0) {
							$query_embalaje="SELECT * FROM embalajes WHERE codembalaje='$codembalaje'";
							$res_embalaje=mysqli_query($descriptor,$query_embalaje);
							$nombreembalaje=mysqli_result($res_embalaje,0,"nombre");
						} else {
							$nombreembalaje="Sin determinar";
						}
					  ?>
						<tr>
							<td width="22%">Embalaje</td>
							<td colspan="2"><?php echo $nombreembalaje?></td>
					    </tr>
						<tr>
							<td>Unidades por caja</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"unidades_caja")?> unidades</td>
						</tr>
						<tr>
							<td>Preguntar precio ticket</td>
							<td colspan="2"><?php if (mysqli_result($rs_query,0,"precio_ticket")==0) { echo "No"; } else { echo "Si"; }?></td>
						</tr>
						<tr>
							<td>Modificar descrip. ticket</td>
							<td colspan="2"><?php if (mysqli_result($rs_query,0,"modificar_ticket")==0) { echo "No"; } else { echo "Si"; }?></td>
						</tr>
						<tr>
							<td>Observaciones</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"observaciones")?></td>
						</tr>
						<tr>
							<td>Precio de compra</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"precio_compra")?> &#8364;</td>
						</tr>
						<tr>
							<td>Precio almac&eacute;n</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"precio_almacen")?> &#8364;</td>
						</tr>												
						<tr>
							<td>Precio en tienda</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"precio_tienda")?> &#8364;</td>
						</tr>
						<!--<tr>
							<td>Pvp</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"precio_pvp")?> &#8364;</td>
						</tr>-->
						<tr>
							<td>Precio con iva</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"precio_iva")?> &#8364;</td>
						</tr>
							<tr>
							<td>Codigo de barras</td>							
							<td colspan="2"><?php echo "<img src='../barcode/barcode.php?encode=EAN-13&bdata=".$codigobarras."&height=50&scale=2&bgcolor=%23FFFFEC&color=%23333366&type=jpg'>"; ?></td>
						</tr>
					</table>			  </div>
				<div id="botonBusqueda">
				<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<? echo $codarticulo?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			 </div>
		  </div>
		</div>
	</body>
</html>
