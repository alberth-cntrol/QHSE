<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$codproveedor=$_POST["codproveedor"];
$nombre=$_POST["nombre"];
$numalbaran=$_POST["numalbaran"];
$estado=$_POST["cboEstados"];
$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }
$fechafin=$_POST["fechafin"];
if ($fechafin<>"") { $fechafin=explota($fechafin); }

$cadena_busqueda=$_POST["cadena_busqueda"];

$where="1=1";
if ($codproveedor <> "") { $where.=" AND albaranesp.codproveedor='$codproveedor'"; }
if ($nombre <> "") { $where.=" AND proveedores.nombre like '%".$nombre."%'"; }
if ($numalbaran <> "") { $where.=" AND codalbaran='$numalbaran'"; }
if ($estado > "0") { $where.=" AND estado='$estado'"; }
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

$where.=" ORDER BY codalbaran DESC";
$query_busqueda="SELECT count(*) as filas FROM albaranesp,proveedores WHERE albaranesp.codproveedor=proveedores.codproveedor AND ".$where;
$rs_busqueda=mysqli_query($descriptor,$query_busqueda);
$filas=mysqli_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Clientes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function ver_albaran(codalbaran,codproveedor) {
			parent.location.href="ver_albaran.php?codalbaran=" + codalbaran + "&codproveedor=" + codproveedor + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
		}
		
		function modificar_albaran(codalbaran,codproveedor,marcaestado) {
			if (marcaestado==1) {
				parent.location.href="modificar_albaran.php?codalbaran=" + codalbaran + "&codproveedor=" + codproveedor + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			} else {
				alert ("No se puede modificar un albaran ya facturado.");
			}
		}
		
		function convertir_albaran(codalbaran,codproveedor,marcaestado) {
			if (marcaestado==1) {
				parent.location.href="convertir_albaran.php?codalbaran=" + codalbaran + "&codproveedor=" + codproveedor + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			} else {
				alert ("No se puede convertir un albaran ya facturado.");
			}
		}
		
		function eliminar_albaran(codalbaran,codproveedor) {
			parent.location.href="eliminar_albaran.php?codalbaran=" + codalbaran + "&codproveedor=" + codproveedor + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
		}

		function inicio() {
			var numfilas=document.getElementById("numfilas").value;
			var indi=parent.document.getElementById("iniciopagina").value;
			var contador=1;
			var indice=0;
			if (indi>numfilas) { 
				indi=1; 
			}
			parent.document.form_busqueda.filas.value=numfilas;
			parent.document.form_busqueda.paginas.innerHTML="";		
			while (contador<=numfilas) {
				texto=contador + "-" + parseInt(contador+9);
				if (indi==contador) {
					parent.document.form_busqueda.paginas.options[indice]=new Option (texto,contador);
					parent.document.form_busqueda.paginas.options[indice].selected=true;
				} else {
					parent.document.form_busqueda.paginas.options[indice]=new Option (texto,contador);
				}
				indice++;
				contador=contador+10;
			}
		}
		</script>
	</head>

	<body onload=inicio()>	
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
			<table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
			<input type="hidden" name="numfilas" id="numfilas" value="<?php echo $filas?>">
				<?php 
				if(isset($_POST["iniciopagina"])){
					$iniciopagina = $_POST["iniciopagina"];
				} else {$iniciopagina =0;}
				if(isset($_GET["iniciopagina"])){
					$iniciopagina = $_GET["iniciopagina"];
				} else {$iniciopagina =0;}

				if (empty($iniciopagina)) { 
					@$iniciopagina=$_GET["iniciopagina"]; 
				} 
				else 
				{ 
					$iniciopagina=$iniciopagina-1;
				}
				if (empty($iniciopagina)) { $iniciopagina=0; }
				if ($iniciopagina>$filas) { $iniciopagina=0; }
					if ($filas > 0) { ?>
						<?php $sel_resultado="SELECT codalbaran,proveedores.nombre as nombre,albaranesp.fecha as fecha,proveedores.codproveedor,totalalbaran,estado FROM albaranesp,proveedores WHERE albaranesp.codproveedor=proveedores.codproveedor AND ".$where;
						   $sel_resultado=$sel_resultado."  limit ".$iniciopagina.",10";
						   $res_resultado=mysqli_query($descriptor,$sel_resultado);
						   $contador=0;
						   $marcaestado=0;						   
						   while ($contador < mysqli_num_rows($res_resultado)) { 
						   $marcaestado=mysqli_result($res_resultado,$contador,"estado");
						   if (mysqli_result($res_resultado,$contador,"estado")==1) { $estado="Sin facturar"; } else { $estado="Facturado"; }
								if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
							<td class="aCentro" width="8%"><?php echo $contador+1;?></td>
							<td width="8%"><div align="center"><?php echo mysqli_result($res_resultado,$contador,"codalbaran")?></div></td>
							<td width="30%"><div align="left"><?php echo mysqli_result($res_resultado,$contador,"nombre")?></div></td>							
							<td width="10%"><div align="center"><?php echo number_format(mysqli_result($res_resultado,$contador,"totalalbaran"),2,",",".")?></div></td>
							<td class="aDerecha" width="10%"><div align="center"><?php echo implota(mysqli_result($res_resultado,$contador,"fecha"))?></div></td>
							<td width="10%"><div align="center"><?php echo $estado?></div></td>
							<td width="6%"><div align="center"><a href="#"><img src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_albaran('<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>',<?php echo mysqli_result($res_resultado,$contador,"codproveedor")?>,<?php echo $marcaestado?>)" title="Modificar"></a></div></td>
							<td width="6%"><div align="center"><a href="#"><img src="../img/ver.png" width="16" height="16" border="0" onClick="ver_albaran('<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>',<?php echo mysqli_result($res_resultado,$contador,"codproveedor")?>)" title="Visualizar"></a></div></td>
							<td width="6%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_albaran('<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>',<?php echo mysqli_result($res_resultado,$contador,"codproveedor")?>)" title="Eliminar"></a></div></td>
							<td width="6%"><div align="center"><a href="#"><img src="../img/convertir.png" width="16" height="16" border="0" onClick="convertir_albaran('<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>',<?php echo mysqli_result($res_resultado,$contador,"codproveedor")?>,<?php echo $marcaestado?>)" title="Facturar"></a></div></td>
						</tr>
						<?php $contador++;
							}
						?>			
					</table>
					<?php } else { ?>
					<table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "No hay ning&uacute;n albar&aacute;n que cumpla con los criterios de b&uacute;squeda";?></td>
					    </tr>
					</table>					
					<?php } ?>	
				</div>				
				</div>
		  </div>			
		</div>
	</body>
</html>
