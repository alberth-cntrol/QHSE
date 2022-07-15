<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }
$fechafin=$_POST["fechafin"];
if ($fechafin<>"") { $fechafin=explota($fechafin); }

$cadena_busqueda=$_POST["cadena_busqueda"];

$where="1=1";
if (($fechainicio<>"") and ($fechafin<>"")) {
	$where.=" AND fecha between '".$fechainicio."' AND '".$fechafin."'";
} else {
	if ($fechainicio<>"") {
		$where.=" and fecha>='".$fechainicio."'";
	} else {
		if ($fechafin<>"") {
			$where.=" and fecha<='".$fechafin."'";
		}
	}
}

$where.=" ORDER BY fecha DESC";
$query_busqueda="SELECT count(*) as filas FROM librodiario WHERE ".$where;

$rs_busqueda=mysqli_query($descriptor,$query_busqueda);
$filas=mysqli_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Clientes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">

		function ver_cobros(codfactura) {
			parent.location.href="ver_cobros.php?codfactura=" + codfactura + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
		}
		
		function inicio() {
			var numfilas=document.getElementById("numfilas").value;
			var indi=parent.document.getElementById("iniciopagina").value;
			var contador=1;
			var indice=0;
			if (indi>numfilas) { 
				indi=1; 
			}
			parent.document.formulario.filas.value=numfilas;
			parent.document.formulario.paginas.innerHTML="";		
			while (contador<=numfilas) {
				texto=contador + "-" + parseInt(contador+9);
				if (indi==contador) {
					parent.document.formulario.paginas.options[indice]=new Option (texto,contador);
					parent.document.formulario.paginas.options[indice].selected=true;
				} else {
					parent.document.formulario.paginas.options[indice]=new Option (texto,contador);
				}
				indice++;
				contador=contador+10;
			}
		}
		</script>
	</head>

	<body onload=inicio()>	
			<div id="zonaContenido">
			<div align="center">
			<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
			<form name="form1" id="form1">
			<input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas?>">
				<?php	if ($filas > 0) { ?>
						<?php $sel_resultado="SELECT librodiario.*,formapago.nombrefp FROM librodiario LEFT JOIN formapago ON librodiario.codformapago=formapago.codformapago WHERE ".$where;
						   $res_resultado=mysqli_query($descriptor,$sel_resultado);
						   $contador=0;					   
						   while ($contador < mysqli_num_rows($res_resultado)) { 
								if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
						  <?php if (mysqli_result($res_resultado,$contador,"tipodocumento")==1) { 
						  		$codproveedor=mysqli_result($res_resultado,$contador,"codcomercial");
								$sel_proveedor="SELECT nombre FROM proveedores WHERE codproveedor='$codproveedor'";
								$rs_proveedor=mysqli_query($descriptor,$sel_proveedor);
								$nombrecomercial=mysqli_result($rs_proveedor,0,"nombre");
								$movimiento="Compra"; 
							} else { 
								$codcliente=mysqli_result($res_resultado,$contador,"codcomercial");
								$sel_proveedor="SELECT nombre FROM clientes WHERE codcliente='$codcliente'";
								$rs_proveedor=mysqli_query($descriptor,$sel_proveedor);
								$nombrecomercial=mysqli_result($rs_proveedor,0,"nombre"); 
								$movimiento="Venta";
							}  ?>
							<td class="aCentro" width="5%"><?php echo $contador+1;?></td>
							<td width="10%"><div align="center"><?php echo implota(mysqli_result($res_resultado,$contador,"fecha"))?></div></td>
							<td width="10%"><div align="center"><?php echo $movimiento?></div></td>							
							<td width="10%"><div align="center"><?php echo mysqli_result($res_resultado,$contador,"coddocumento")?></div></td>
							<td class="aDerecha" width="20%"><div align="center"><?php echo $nombrecomercial?></div></td>
							<td class="aDerecha" width="20%"><div align="center"><?php echo mysqli_result($res_resultado,$contador,"nombrefp")?></div></td>
							<td class="aDerecha" width="15%"><div align="center"><?php echo mysqli_result($res_resultado,$contador,"numpago")?></div></td>							
							<td width="10%"><div align="center"><?php echo number_format(mysqli_result($res_resultado,$contador,"total"),2,",",".");?></div></td>
						</tr>
						<?php $contador++;
							}
						?>			
					</table>
					<?php } else { ?>
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "No hay ning&uacute;n movimiento que cumpla con los criterios de b&uacute;squeda";?></td>
					    </tr>
					</table>					
					<?php } ?>	
					</form>				
			</div>
		  </div>			
		</div>
	</body>
</html>
