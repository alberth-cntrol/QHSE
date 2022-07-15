<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$codcliente=$_POST["codcliente"];
$nombre=$_POST["nombre"];
$numalbaran=$_POST["numalbaran"];
$estado=$_POST["cboEstados"];
$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }
$fechafin=$_POST["fechafin"];
if ($fechafin<>"") { $fechafin=explota($fechafin); }

$cadena_busqueda=$_POST["cadena_busqueda"];

$where="1=1";
if ($codcliente <> "") { $where.=" AND albaranes.codcliente='$codcliente'"; }
if ($nombre <> "") { $where.=" AND clientes.nombre like '%".$nombre."%'"; }
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
$query_busqueda="SELECT count(*) as filas FROM albaranes,clientes WHERE albaranes.borrado=0 AND albaranes.codcliente=clientes.codcliente AND ".$where;

$rs_busqueda=mysqli_query($descriptor,$query_busqueda);
$filas=mysqli_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Clientes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function ver_albaran(codalbaran) {
			parent.location.href="ver_albaran.php?codalbaran=" + codalbaran + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
		}
		
		
		function imprimir_etiquetas(codalbaran) {
				window.open("../fpdf/codigocontinuo.php?codalbaran="+codalbaran);
		}
		
		function modificar_albaran(codalbaran,marcaestado) {
			if (marcaestado==1) {
				parent.location.href="modificar_albaran.php?codalbaran=" + codalbaran + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			} else {
				alert ("No puede modificar un albaran facturado");
			}
		}
		
		function convertir_albaran(codalbaran,marcaestado) {
			if (marcaestado==1) {
				parent.location.href="convertir_albaran.php?codalbaran=" + codalbaran + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
			} else {
				alert ("No se puede convertir en factura un albaran ya facturado");
			}
		}
		
		function eliminar_albaran(codalbaran) {
			parent.location.href="eliminar_albaran.php?codalbaran=" + codalbaran + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
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
						<?php $sel_resultado="SELECT codalbaran,clientes.nombre as nombre,albaranes.fecha as fecha,totalalbaran,estado FROM albaranes,clientes WHERE albaranes.borrado=0 AND albaranes.codcliente=clientes.codcliente AND ".$where;
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
							<td width="29%"><div align="left"><?php echo mysqli_result($res_resultado,$contador,"nombre")?></div></td>
							<td width="10%"><div align="center"><?php echo number_format(mysqli_result($res_resultado,$contador,"totalalbaran"),2,",",".")?></div></td>							
							<td class="aDerecha" width="10%"><div align="center"><?php echo implota(mysqli_result($res_resultado,$contador,"fecha"))?></div></td>
							<td width="10%"><div align="center"><?php echo $estado?></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/modificar.png" width="16" height="16" border="0" onClick="modificar_albaran(<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>,<?php echo $marcaestado?>)" title="Modificar"></a></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/ver.png" width="16" height="16" border="0" onClick="ver_albaran(<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>)" title="Visualizar"></a></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar_albaran(<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>,<?php echo $marcaestado?>)" title="Eliminar"></a></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/convertir.png" width="16" height="16" border="0" onClick="convertir_albaran(<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>,<?php echo $marcaestado?>)" title="Facturar"></a></div></td>
							<td width="5%"><div align="center"><a href="#"><img src="../img/imprimir.png" width="16" height="16" border="0" onClick="imprimir_etiquetas(<?php echo mysqli_result($res_resultado,$contador,"codalbaran")?>)" title="Imprimir etiquetas"></a></div></td>
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
