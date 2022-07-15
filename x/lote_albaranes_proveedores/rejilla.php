<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$codproveedor=$_POST["codproveedor"];
$numalbaranini=$_POST["numalbaranini"];
$numalbaranfin=$_POST["numalbaranfin"];
$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }
$fechafin=$_POST["fechafin"];
if ($fechafin<>"") { $fechafin=explota($fechafin); }

$cadena_busqueda=$_POST["cadena_busqueda"];

$where="1=1";
if ($codproveedor <> "") { $where.=" AND albaranesp.codproveedor='$codproveedor'"; }
if ($numalbaranini == "") { $numalbaranini=0; } else { $where.=" AND codalbaran>='$numalbaranini'"; }
if ($numalbaranfin == "") { $numalbaranfin=9999999999; } else { $where.=" AND codalbaran<='$numalbaranfin'"; }
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
$query_busqueda="SELECT count(*) as filas FROM albaranesp,proveedores WHERE albaranesp.estado=1 AND albaranesp.codproveedor=proveedores.codproveedor AND ".$where;
$rs_busqueda=mysqli_query($descriptor,$query_busqueda);
$filas=mysqli_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Clientes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">

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
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
			<table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
			<form name="form1" id="form1">
			<input type="hidden" name="numfilas" id="numfilas" value="<? echo $filas?>">
				<? 
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
						<? $sel_resultado="SELECT codalbaran,proveedores.nombre as nombre,albaranesp.fecha as fecha,totalalbaran FROM albaranesp,proveedores WHERE albaranesp.estado=1 AND albaranesp.codproveedor=proveedores.codproveedor AND ".$where;
						   $sel_resultado=$sel_resultado."  limit ".$iniciopagina.",10";
						   $res_resultado=mysqli_query($descriptor,$sel_resultado);
						   $contador=0;
						   $marcaestado=0;						   
						   while ($contador < mysqli_num_rows($res_resultado)) { 
								if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
							<td class="aCentro" width="10%"><input type="checkbox" name="checkbox_socio" id="checkbox_socio" value="<? echo mysqli_result($res_resultado,$contador,"codalbaran")?>" style="border:0"></td>
							<td class="aCentro" width="15%"><? echo $contador+1;?></td>
							<td width="25%"><div align="center"><? echo mysqli_result($res_resultado,$contador,"codalbaran")?></div></td>
							<td width="25%"><div align="center"><? echo number_format(mysqli_result($res_resultado,$contador,"totalalbaran"),2,",",".")?></div></td>							
							<td class="aDerecha" width="25%"><div align="center"><? echo implota(mysqli_result($res_resultado,$contador,"fecha"))?></div></td>
						</tr>
						<? $contador++;
							}
						?>			
					</table>
					<? } else { ?>
					<table class="fuente8" width="87%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "No hay ning&uacute;n albar&aacute;n que cumpla con los criterios de b&uacute;squeda";?></td>
					    </tr>
					</table>					
					<? } ?>	
					</form>				
				</div>
			</div>
		  </div>			
		</div>
	</body>
</html>
