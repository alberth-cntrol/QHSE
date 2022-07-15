<?
include ("../conectar.php"); 
include ("../funciones/fechas.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$codfacturatmp=$_POST["codfacturatmp"];
$codfactura=$_POST["cfactura"];
$codproveedor=$_POST["codproveedor"];
$fecha=explota($_POST["fecha"]);
$iva=$_POST["iva"];
$minimo=0;

if ($accion=="alta") {
	$query_comprobar="SELECT * FROM facturasp WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
	$rs_comprobar=mysqli_query($descriptor,$query_comprobar);
	if (mysqli_num_rows($rs_comprobar) > 0 ) {
			?><script>
				alert ("No se puede dar de alta este numero de factura con este proveedor, ya existe uno en el sistema.");
				location.href="index.php";
			</script><?
	} else {
			$query_operacion="INSERT INTO facturasp (codfactura, codproveedor, fecha, iva, estado) VALUES ('$codfactura', '$codproveedor', '$fecha', '$iva', '1')";					
			$rs_operacion=mysqli_query($descriptor,$query_operacion);
			if ($rs_operacion) { $mensaje="La factura ha sido dada de alta correctamente"; }
			$query_tmp="SELECT * FROM factulineaptmp WHERE codfactura='$codfacturatmp' ORDER BY numlinea ASC";
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
				$sel_insertar="INSERT INTO factulineap (codfactura,codproveedor,numlinea,codfamilia,codigo,cantidad,precio,importe,dcto) VALUES 
				('$codfactura','$codproveedor','$numlinea','$codfamilia','$codigo','$cantidad','$precio','$importe','$dcto')";
				$rs_insertar=mysqli_query($descriptor,$sel_insertar);		
				$sel_articulos="UPDATE articulos SET stock=(stock+'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
				$rs_articulos=mysqli_query($descriptor,$sel_articulos);
				$sel_comprobar="SELECT codarticulo FROM artpro WHERE codarticulo='".$codigo."' AND codfamilia='$codfamilia' AND codproveedor='".$codproveedor."'";
				$rs_comprobar=mysqli_query($descriptor,$sel_comprobar);
				$precio=sprintf("%01.2f",$precio);
				if (mysqli_num_rows($rs_comprobar) > 0) {
					$sentencia="UPDATE artpro SET precio='".$precio."' WHERE codarticulo='".$codigo."' AND codfamilia='$codfamilia' AND codproveedor='".$codproveedor."'";         } else {
					$sentencia="INSERT into artpro (codarticulo,codfamilia,codproveedor,precio) VALUES ('$codigo','$codfamilia','$codproveedor','$precio')";		
				}
				$ejecutar=mysqli_query($descriptor,$sentencia);
				$sentencia2="UPDATE articulos SET ultimo_precio_costo='".$precio."' AND codproveedor='$codproveedor' WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
				$ejecutar=mysqli_query($descriptor,$sentencia2);
				$contador++;
			}
			$baseimpuestos=$baseimponible*($iva/100);
			$preciototal=$baseimponible+$baseimpuestos;
			//$preciototal=number_format($preciototal,2);	
			$sel_act="UPDATE facturasp SET totalfactura='$preciototal' WHERE codfactura='$codfactura'";
			$rs_act=mysqli_query($descriptor,$sel_act);
			$baseimpuestos=0;
			$preciototal=0;
			$baseimponible=0;
			$cabecera1="Inicio >> Compras &gt;&gt; Nueva Factura ";
			$cabecera2="INSERTAR FACTURA";
		}
} 

if ($accion=="modificar") {
	$codfactura=$_POST["codfactura"];
	$act_albaran="UPDATE facturasp SET fecha='$fecha', iva='$iva' WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
	$rs_albaran=mysqli_query($descriptor,$act_albaran);
	$sel_lineas = "SELECT codigo,codfamilia,cantidad FROM factulineap WHERE codfactura='$codfactura' AND codproveedor='$codproveedor' order by numlinea";
	$rs_lineas = mysqli_query($descriptor,$sel_lineas);
	$contador=0;
	while ($contador < mysqli_num_rows($rs_lineas)) {
		$codigo=mysqli_result($rs_lineas,$contador,"codigo");
		$codfamilia=mysqli_result($rs_lineas,$contador,"codfamilia");
		$cantidad=mysqli_result($rs_lineas,$contador,"cantidad");
		$sel_actualizar="UPDATE `articulos` SET stock=(stock+'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_actualizar = mysqli_query($descriptor,$sel_actualizar);
		$contador++;
	}
	$sel_borrar = "DELETE FROM factulineap WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
	$rs_borrar = mysqli_query($descriptor,$sel_borrar);
	$sel_lineastmp = "SELECT * FROM factulineaptmp WHERE codfactura='$codfacturatmp' ORDER BY numlinea";
	$rs_lineastmp = mysqli_query($descriptor,$sel_lineastmp);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysqli_num_rows($rs_lineastmp)) {
		$numlinea=mysqli_result($rs_lineastmp,$contador,"numlinea");
		$codigo=mysqli_result($rs_lineastmp,$contador,"codigo");
		$codfamilia=mysqli_result($rs_lineastmp,$contador,"codfamilia");
		$cantidad=mysqli_result($rs_lineastmp,$contador,"cantidad");
		$precio=mysqli_result($rs_lineastmp,$contador,"precio");
		$importe=mysqli_result($rs_lineastmp,$contador,"importe");
		$baseimponible=$baseimponible+$importe;
		$dcto=mysqli_result($rs_lineastmp,$contador,"dcto");
	
		$sel_insert = "INSERT INTO factulineap (codfactura,codproveedor,numlinea,codigo,codfamilia,cantidad,precio,importe,dcto) 
		VALUES ('$codfactura','$codproveedor','','$codigo','$codfamilia','$cantidad','$precio','$importe','$dcto')";

		$rs_insert = mysqli_query($descriptor,$sel_insert);
		
		$sel_actualiza="UPDATE articulos SET stock=(stock-'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_actualiza = mysqli_query($descriptor,$sel_actualiza);
		$sel_bajominimo = "SELECT codarticulo,codfamilia,stock,stock_minimo,descripcion FROM articulos WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_bajominimo= mysqli_query($descriptor,$sel_bajominimo);
		$stock=mysqli_result($rs_bajominimo,0,"stock");
		$stock_minimo=mysqli_result($rs_bajominimo,0,"stock_minimo");
		$descripcion=mysqli_result($rs_bajominimo,0,"descripcion");
		
		if (($stock < $stock_minimo) or ($stock <= 0))
		   { 
			  $mensaje_minimo=$mensaje_minimo . " " . $descripcion."<br>";
			  $minimo=1;
		   };
		$contador++;
	}
	$baseimpuestos=$baseimponible*($iva/100);
	$preciototal=$baseimponible+$baseimpuestos;
	//$preciototal=number_format($preciototal,2);	
	$sel_act="UPDATE facturasp SET totalfactura='$preciototal' WHERE codfactura='$codfactura'";
	$rs_act=mysqli_query($descriptor,$sel_act);
	$baseimpuestos=0;
	$preciototal=0;
	$baseimponible=0;
	if ($rs_query) { $mensaje="Los datos de la factura han sido modificados correctamente"; }
	$cabecera1="Inicio >> Compras &gt;&gt; Modificar Factura ";
	$cabecera2="MODIFICAR FACTURA";
}

if ($accion=="baja") {
	$codfactura=$_GET["codfactura"];
	$codproveedor=$_GET["codproveedor"];
	$query="SELECT * FROM factulineap WHERE codfactura='$codfactura' AND codproveedor='$codproveedor' ORDER BY numlinea ASC";
	$rs_tmp=mysqli_query($descriptor,$query);
	$contador=0;
	$baseimponible=0;
	while ($contador < mysqli_num_rows($rs_tmp)) {
		$codfamilia=mysqli_result($rs_tmp,$contador,"codfamilia");
		$codigo=mysqli_result($rs_tmp,$contador,"codigo");
		$cantidad=mysqli_result($rs_tmp,$contador,"cantidad");
		$sel_articulos="UPDATE articulos SET stock=(stock+'$cantidad') WHERE codarticulo='$codigo' AND codfamilia='$codfamilia'";
		$rs_articulos=mysqli_query($descriptor,$sel_articulos);
		$contador++;
	}
	if ($rs_query) { $mensaje="La factura ha sido eliminada correctamente"; }
	$cabecera1="Inicio >> Compras &gt;&gt; Eliminar Factura";
	$cabecera2="ELIMINAR FACTURA";
	$query_mostrar="SELECT * FROM facturasp WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
	$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
	$codproveedor=mysqli_result($rs_mostrar,0,"codproveedor");
	$fecha=mysqli_result($rs_mostrar,0,"fecha");
	$iva=mysqli_result($rs_mostrar,0,"iva");
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
		
		function imprimir(codfactura,codproveedor) {
			window.open("../fpdf/imprimir_factura_proveedor.php?codfactura="+codfactura+"&codproveedor="+codproveedor);
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
						<? 
						 $sel_proveedores="SELECT * FROM proveedores WHERE codproveedor='$codproveedor'"; 
						  $rs_proveedores=mysqli_query($descriptor,$sel_proveedores); ?>
						<tr>
							<td width="15%">Proveedor</td>
							<td width="85%" colspan="2"><?php echo mysqli_result($rs_proveedores,0,"nombre");?></td>
					    </tr>
						<tr>
							<td width="15%">NIF / CIF</td>
						    <td width="85%" colspan="2"><?php echo mysqli_result($rs_proveedores,0,"nif");?></td>
					    </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php echo mysqli_result($rs_proveedores,0,"direccion"); ?></td>
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
							<td width="25%">REFERENCIA</td>
							<td width="30%">DESCRIPCION</td>
							<td width="10%">CANTIDAD</td>
							<td width="10%">PRECIO</td>
							<td width="10%">DCTO %</td>
							<td width="10%">IMPORTE</td>
						</tr>
					</table>
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
					  <? $sel_lineas="SELECT factulineap.*, articulos.referencia,articulos.descripcion, familias.nombre as nombrefamilia FROM factulineap,articulos,familias WHERE factulineap.codfactura='$codfactura' AND factulineap.codproveedor='$codproveedor' AND factulineap.codigo=articulos.codarticulo AND factulineap.codfamilia=articulos.codfamilia AND articulos.codfamilia=familias.codfamilia ORDER BY factulineap.numlinea ASC";
$rs_lineas=mysqli_query($descriptor,$sel_lineas);
						for ($i = 0; $i < mysqli_num_rows($rs_lineas); $i++) {
							$numlinea=mysqli_result($rs_lineas,$i,"numlinea");
							$codfamilia=mysqli_result($rs_lineas,$i,"codfamilia");
							$nombrefamilia=mysqli_result($rs_lineas,$i,"nombrefamilia");
							$codarticulo=mysqli_result($rs_lineas,$i,"codigo");
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
										<td width="25%"><? echo $referencia?></td>
										<td width="30%"><? echo $descripcion?></td>
										<td width="10%" class="aCentro"><? echo $cantidad?></td>
										<td width="10%" class="aCentro"><? echo $precio?></td>
										<td width="10%" class="aCentro"><? echo $descuento?></td>
										<td width="10%" class="aCentro"><? echo $importe?></td>
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
			  <? if ($accion=="baja") { 
					  $query="DELETE FROM facturasp WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
						$rs_query=mysqli_query($descriptor,$query);
						$borrar_lineas="DELETE FROM factulineap WHERE codfactura='$codfactura' AND codproveedor='$codproveedor'";
						$rs_borrar_lineas=mysqli_query($descriptor,$borrar_lineas);
				} ?>
				<div id="botonBusqueda">
					<div align="center">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">					   
					  <? if ($accion<>"baja") { ?>
					  <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir('<? echo $codfactura?>',<? echo $codproveedor ?>)" onMouseOver="style.cursor=cursor">
					   <? } ?>
				        </div>
					</div>
			  </div>
		  </div>
		</div>
	</body>
</html>
