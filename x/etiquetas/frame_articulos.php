<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
</head>
<script language="javascript">

function pon_prefijo(pref,nombre) {
	parent.opener.document.formulario_lineas.codbarras.value=pref;
	parent.opener.document.formulario_lineas.descripcion.value=nombre;
	parent.window.close();
}

</script>
<?php include ("../conectar.php"); 

include ("../conectar.php"); 
$familia=$_POST["cmbfamilia"];
$referencia=$_POST["referencia"];
$descripcion=$_POST["descripcion"];
$where="1=1";

if ($familia<>0) { $where.=" AND articulos.codfamilia='$familia'"; }
if ($referencia<>"") { $where.=" AND referencia like '%$referencia%'"; }
if ($descripcion<>"") { $where.=" AND descripcion like '%$descripcion%'"; } ?>

<body>
<?php
	
	$consulta="SELECT articulos.*,familias.nombre as nombrefamilia FROM articulos,familias WHERE  ".$where." AND articulos.codfamilia=familias.codfamilia AND articulos.borrado=0 ORDER BY articulos.codfamilia ASC, articulos.descripcion ASC";
	$rs_tabla = mysqli_query($descriptor,$consulta);
	$nrs=mysqli_num_rows($rs_tabla);
?>
<div id="tituloForm2" class="header" align="center">
<div align="center">
<form id="form1" name="form1">
<?php if ($nrs>0) { ?>
		<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
		  <tr>
			<td width="15%"><div align="center"><b>Familia</b></div></td>
			<td width="15%"><div align="center"><b>Referencia</b></div></td>
			<td width="40%"><div align="center"><b>Descripci&oacute;n</b></div></td>
			<td width="20%"><div align="center"><b>Precio</b></div></td>
			<td width="10%"><div align="center"></td>
		  </tr>
		<?php
			for ($i = 0; $i < mysqli_num_rows($rs_tabla); $i++) {
				$codfamilia=mysqli_result($rs_tabla,$i,"codfamilia");
				$codigobarras=mysqli_result($rs_tabla,$i,"codigobarras");
				$nombrefamilia=mysqli_result($rs_tabla,$i,"nombrefamilia");
				$referencia=mysqli_result($rs_tabla,$i,"referencia");
				$codarticulo=mysqli_result($rs_tabla,$i,"codarticulo");				
				$descripcion=mysqli_result($rs_tabla,$i,"descripcion");
				$precio=mysqli_result($rs_tabla,$i,"precio_pvp");
				 if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
					<td>
        <div align="center"><?php echo $nombrefamilia;?></div></td>
					<td>
        <div align="left"><?php echo $referencia;?></div></td>
					<td><div align="center"><?php echo $descripcion;?></div></td>
					<td><div align="center"><?php echo $precio;?></div></td>
					<td align="center"><div align="center"><a href="javascript:pon_prefijo('<?php echo $codigobarras?>','<?php echo str_replace('"','',$descripcion)?>')"><img src="../img/convertir.png" border="0" title="Seleccionar"></a></div></td>					
				</tr>
			<?php }
		?>
  </table>
		<?php 
		}  ?>
<iframe id="frame_datos" name="frame_datos" width="0%" height="0" frameborder="0">
	<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
</iframe>
<input type="hidden" id="accion" name="accion">
</form>
</div>
</div>
</body>
</html>
