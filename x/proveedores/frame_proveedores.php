<?php
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 
?>
<html>
<head>
<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
</head>
<script language="javascript">

function pon_prefijo(pref,nombre,nif) {
	parent.opener.document.form_busqueda.codproveedor.value=pref;
	parent.opener.document.form_busqueda.nombre.value=nombre;
	parent.opener.document.form_busqueda.nif.value=nif;
	parent.window.close();
}

</script>
<? include ("../conectar.php"); ?>
<body>
<?php
	
	$consulta="SELECT * FROM proveedores WHERE borrado=0 ORDER BY codproveedor ASC";
	$rs_tabla = mysqli_query($descriptor,$consulta);
	$nrs=mysqli_num_rows($rs_tabla);
?>
<div id="tituloForm2" class="header">
<form id="form1" name="form1">
<?php if ($nrs>0) { ?>
		<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
		  <tr>
			<td width="10%"><div align="center"><b>Codigo</b></div></td>
			<td width="60%"><div align="center"><b>Proveedor</b></div></td>
			<td width="20%"><div align="center"><b>NIF/CIF</b></div></td>
			<td width="10%"><div align="center"></td>
		  </tr>
		<?php
			for ($i = 0; $i < mysqli_num_rows($rs_tabla); $i++) {
				$codproveedor=mysqli_result($rs_tabla,$i,"codproveedor");
				$nombre=mysqli_result($rs_tabla,$i,"nombre");
				$nif=mysqli_result($rs_tabla,$i,"nif");
				 if ($i % 2) { $fondolinea="itemParTabla"; } else { $fondolinea="itemImparTabla"; }?>
						<tr class="<?php echo $fondolinea?>">
					<td>
        <div align="center"><?php echo $codproveedor;?></div></td>
					<td>
        <div align="left"><?php echo utf8_encode($nombre);?></div></td>
					<td><div align="center"><?php echo $nif;?></div></td>
					<td align="center"><div align="center"><a href="javascript:pon_prefijo(<?php echo $codproveedor?>,'<?php echo $nombre?>','<?php echo $nif?>')"><img src="../img/convertir.png" border="0" title="Seleccionar"></a></div></td>					
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
</body>
</html>
