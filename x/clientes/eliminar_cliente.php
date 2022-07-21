<?php
include ("../conectar.php"); 

@$codcliente=$_GET["codcliente"];
@$cadena_busqueda=$_GET["cadena_busqueda"];

$query="SELECT * FROM clientes WHERE codcliente='$codcliente'";
$rs_query=mysqli_query($descriptor,$query);

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar(codcliente) {
			location.href="guardar_cliente.php?codcliente=" + codcliente + "&accion=baja" + "&cadena_busqueda=<?php echo $cadena_busqueda?>";
		}
		
		function cancelar() {
			location.href="index.php?cadena_busqueda=<?php echo $cadena_busqueda?>";
		}
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">ELIMINAR USUARIO </div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codcliente?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo mysqli_result($rs_query,0,"nombre")?></td>
					    </tr>
						<tr>
						  <td>NIF / CIF</td>
						  <td colspan="2"><?php echo mysqli_result($rs_query,0,"nif")?></td>
					  </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php echo mysqli_result($rs_query,0,"direccion")?></td>
					  </tr>
						<tr>
						  <td>Localidad</td>
						  <td colspan="2"><?php echo mysqli_result($rs_query,0,"localidad")?></td>
					  </tr>
					  <?php
					  	$codprovincia=mysqli_result($rs_query,0,"codprovincia");
						if ($codprovincia<>0) {
							$query_provincias="SELECT * FROM provincias WHERE codprovincia='$codprovincia'";
							$res_provincias=mysqli_query($descriptor,$query_provincias);
							$nombreprovincia=mysqli_result($res_provincias,0,"nombreprovincia");
						} else {
							$nombreprovincia="Sin determinar";
						}
					  ?>
						<tr>
							<td width="15%">Area</td>
							<td width="85%" colspan="2"><?php echo $nombreprovincia?></td>
					    </tr>
						



						<?php
						$rol=mysqli_result($rs_query,0,"rol");
					  	if ($rol<>0) {
							$query_tipou="SELECT * FROM tipoU ORDER BY nombreusuario ASC";
						    $res_tipou=mysqli_query($descriptor,$query_tipou);
							$nombreusuario=mysqli_result($res_tipou,0,"nombreusuario");
						} else {
							$nombreusuario="Sin determinar";						
						}
					  ?>
						<tr>
							<td width="15%">Rol</td>
							<td width="85%" colspan="2"><?php echo $nombreusuario?></td>
					    </tr>




						<tr>
							<td>Tel&eacute;fono</td>
							<td><?php echo mysqli_result($rs_query,0,"telefono")?></td>
						</tr>
						<tr>
							<td>M&oacute;vil</td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"movil")?></td>
						</tr>
						<tr>
							<td>Correo electr&oacute;nico  </td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"email")?></td>
						

						<tr>
							<td>contraseña </td>
							<td colspan="2"><?php echo mysqli_result($rs_query,0,"password")?></td>

						</tr>

					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar(<?php echo $codcliente?>)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
