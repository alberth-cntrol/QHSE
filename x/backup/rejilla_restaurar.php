<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }
$fechafin=$_POST["fechafin"];
if ($fechafin<>"") { $fechafin=explota($fechafin); }
$denominacion=$_POST["denominacion"];
$cadena_busqueda=$_POST["cadena_busqueda"];

$where="1=1";
if ($fechainicio <> "") { $where.=" AND fecha BETWEEN '$fechainicio' AND '$fechafin'"; }
if ($denominacion <> "") { $where.=" AND denominacion like '%".$denominacion."%'"; }

$where.=" ORDER BY fecha ASC";
$query_busqueda="SELECT count(*) as filas FROM tabbackup WHERE ".$where;

$rs_busqueda=mysqli_query($descriptor,$query_busqueda);
$filas=mysqli_result($rs_busqueda,0,"filas");

?>
<html>
	<head>
		<title>Restaurar copias de seguridad</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function restaurar(id) {
			parent.location.href="restaurar_copia.php?id=" + id + "&cadena_busqueda=<? echo $cadena_busqueda?>";
		}
		
		function eliminar(id) {
			parent.location.href="eliminar_copia.php?id=" + id + "&cadena_busqueda=<? echo $cadena_busqueda?>";
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
			<table class="fuente8" width="90%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
			<input type="hidden" name="numfilas" id="numfilas" value="<? echo $filas?>">
				<? $iniciopagina=$_POST["iniciopagina"];
				if (empty($iniciopagina)) { $iniciopagina=$_GET["iniciopagina"]; } else { $iniciopagina=$iniciopagina-1;}
				if (empty($iniciopagina)) { $iniciopagina=0; }
				if ($iniciopagina>$filas) { $iniciopagina=0; }
					if ($filas > 0) { ?>
						<? $sel_resultado="SELECT * FROM tabbackup WHERE ".$where;
						   $sel_resultado=$sel_resultado."  limit ".$iniciopagina.",10";						   
						   $res_resultado=mysqli_query($descriptor,$sel_resultado);
						   $contador=0;
						   while ($contador < mysqli_num_rows($res_resultado)) { 
								 if ($contador % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
							<td class="aCentro" width="6%"><? echo $contador+1;?></td>
							<td width="50%"><div align="center"><? echo mysqli_result($res_resultado,$contador,"denominacion")?></div></td>
							<td width="16%"><div align="center"><? echo implota(mysqli_result($res_resultado,$contador,"fecha"))?></div></td>
							<td width="16%"><div align="center"><? echo mysqli_result($res_resultado,$contador,"hora")?></div></td>
							<td width="6%"><div align="center"><a href="#"><img src="../img/restaurar.png" width="16" height="16" border="0" onClick="restaurar(<?php echo mysqli_result($res_resultado,$contador,"id")?>)" title="Restaurar"></a></div></td>
							<td width="6%"><div align="center"><a href="#"><img src="../img/eliminar.png" width="16" height="16" border="0" onClick="eliminar(<?php echo mysqli_result($res_resultado,$contador,"id")?>)" title="Eliminar"></a></div></td>
						</tr>
						<? $contador++;
							}
						?>			
					</table>
					<? } else { ?>
					<table class="fuente8" width="85%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="100%" class="mensaje"><?php echo "No hay ninguna copia de seguridad que cumpla con los criterios de b&uacute;squeda";?></td>
					    </tr>
					</table>					
					<? } ?>					
				</div>
			</div>
		  </div>			
		</div>
	</body>
</html>
