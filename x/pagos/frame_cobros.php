<?php
include ("../conectar.php");
include ("../funciones/fechas.php");
$hoy=date("d/m/Y");

if ($_POST["accion"]=="") { $accion=$_GET["accion"]; } else { $accion=$_POST["accion"]; }

if ($accion=="ver") {
	$codfactura=$_GET["codfactura"];
	$codproveedor=$_GET["codproveedor"];
}

if ($accion=="insertar") {
	$importe=$_POST["Rimporte"];
	$codcliente=$_POST["codcliente"];
	$codfactura=$_POST["codfactura"];
	$codproveedor=$_POST["codproveedor"];
	$formapago=$_POST["AcboFP"];
	$numdocumento=$_POST["anumdocumento"];
	$observaciones=$_POST["observaciones"];
	//$estado=$_POST["cboEstados"];
	$fechapago2=$_POST["fechapago2"];
	if ($fechapago2<>"") { $fechapago2=explota($fechapago2); }
	$sel_insertar="INSERT INTO pagos 		(id,codfactura,codproveedor,importe,codformapago,numdocumento,fechapago,observaciones) VALUES 
('','$codfactura','$codproveedor','$importe','$formapago','$numdocumento','$fechapago2','$observaciones')";
	$rs_insertar=mysqli_query($descriptor,$sel_insertar);
	
	//1 compra
	//2 venta
	
	$sel_libro="INSERT INTO librodiario (id,fecha,tipodocumento,coddocumento,codcomercial,codformapago,numpago,total) VALUES 
	('','$fechapago2','1','$codfactura','$codproveedor','$formapago','$numdocumento','$importe')";
	$rs_libro=mysqli_query($descriptor,$sel_libro);
	
	?><script>
	parent.document.getElementById("observaciones").value="";
	parent.document.getElementById("Rimporte").value="";
	parent.document.getElementById("anumdocumento").value="";
	parent.document.getElementById("AcboFP").value="";
	parent.document.getElementById("fechapago2").value="<?php echo $hoy?>";
	var total=parent.document.getElementById("pendiente").value - parseFloat(<?php echo $importe?>);
	var original=parseFloat(total);
	var result=Math.round(original*100)/100 ;
	parent.document.getElementById("pendiente").value=result;
	</script><?php
}

$query_busqueda="SELECT count(*) as filas FROM pagos,proveedores WHERE pagos.codproveedor=proveedores.codproveedor AND pagos.codfactura='$codfactura' AND pagos.codproveedor='$codproveedor' order BY id DESC";
$rs_busqueda=mysqli_query($descriptor,$query_busqueda);
$filas=mysqli_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Proveedores</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">

		function abreVentana(observaciones){
			miPopup = window.open("ver_observaciones.php?observaciones="+observaciones,"miwin","width=380,height=240,scrollbars=yes");
			miPopup.focus();
		}
		
		function eliminar(codfactura,idmov,codproveedor,fechapago,importe){			
			miPopup = window.open("eliminar.php?codfactura="+codfactura+"&idmov="+idmov+"&codproveedor="+codproveedor+"&fechapago="+fechapago+"&importe="+importe,"frame_datos","width=380,height=240,scrollbars=yes");
		}
		
		function ver_cobros(codfactura,codproveedor) {
			parent.location.href="ver_cobros.php?codfactura=" + codfactura + "&codproveedor=" + codproveedor + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
		}
		
		</script>
	</head>

	<body>	
			<div id="zonaContenido">
			<div align="center">
			<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
			<form name="form1" id="form1">		
				<?php	if ($filas > 0) { ?>
						<?php $sel_resultado="SELECT * FROM facturasp,pagos,proveedores,formapago WHERE pagos.codfactura='$codfactura' AND pagos.codproveedor='$codproveedor' AND pagos.codfactura=facturasp.codfactura AND pagos.codproveedor=proveedores.codproveedor AND pagos.codformapago=formapago.codformapago ORDER BY pagos.id DESC";
						   $res_resultado=mysqli_query($descriptor,$sel_resultado);
						   $contador=0;				   
						   while ($contador < mysqli_num_rows($res_resultado)) { 
								if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
							<td class="aCentro" width="10%"><?php echo $contador+1;?></td>
							<td width="12%"><div align="center"><?php echo implota(mysqli_result($res_resultado,$contador,"facturasp.fechapago"))?></div></td>
							<td width="12%"><div align="center"><?php echo number_format(mysqli_result($res_resultado,$contador,"importe"),2,",",".")?></div></td>							
							<td width="20%"><div align="center"><?php echo mysqli_result($res_resultado,$contador,"nombrefp")?></div></td>
							<td class="aDerecha" width="20%"><div align="center"><?php echo mysqli_result($res_resultado,$contador,"numdocumento")?></div></td>
							<td class="aDerecha" width="15%"><div align="center"><?php echo implota(mysqli_result($res_resultado,$contador,"pagos.fechapago"))?></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/observaciones.png" width="16" height="16" border="0" onClick="abreVentana('<?php echo mysqli_result($res_resultado,$contador,"observaciones")?>')" title="Ver Observaciones"></a></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar('<?php echo mysqli_result($res_resultado,$contador,"codfactura")?>',<?php echo mysqli_result($res_resultado,$contador,"id")?>,<?php echo mysqli_result($res_resultado,$contador,"codproveedor")?>,<?php echo mysqli_result($res_resultado,$contador,"fechapago")?>,<?php echo mysqli_result($res_resultado,$contador,"importe")?>)" title="Eliminar"></a></div></td>
						</tr>
						<?php $contador++;
							}
						?>			
					</table>
					<?php } else { ?>
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "Todav&iacute;a no se ha producido ning&uacute;n pago en esta factura.";?></td>
					    </tr>
					</table>					
					<?php } ?>	
					</form>				
				</div>
				<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
		  </div>			
	</body>
</html>
