<?
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombre=$_POST["Anombre"];
$nif=$_POST["anif"];
$direccion=$_POST["adireccion"];
$localidad=$_POST["alocalidad"];
$codprovincia=$_POST["cboProvincias"];
$codentidad=$_POST["cboBanco"];
$cuentabanco=$_POST["acuentabanco"];
$codpostal=$_POST["acodpostal"];
$telefono=$_POST["atelefono"];
$movil=$_POST["amovil"];
$email=$_POST["aemail"];
$web=$_POST["aweb"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO proveedores (codproveedor, nombre, nif, direccion, codprovincia, localidad, codentidad, 			cuentabancaria, codpostal, telefono, movil, email, web, borrado) 
					VALUES ('', '$nombre', '$nif', '$direccion', '$codprovincia', '$localidad', '$codentidad', '$cuentabanco', '$codpostal', '$telefono', '$movil', '$email', '$web', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="El proveedor ha sido dado de alta correctamente"; }
	$cabecera1="Inicio >> Proveedores &gt;&gt; Nuevo Proveedor ";
	$cabecera2="INSERTAR PROVEEDOR ";
	$sel_maximo="SELECT max(codproveedor) as maximo FROM proveedores";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codproveedor=mysqli_result($rs_maximo,0,"maximo");
}

if ($accion=="modificar") {
	$codproveedor=$_POST["id"];
	$query="UPDATE proveedores SET nombre='$nombre', nif='$nif', direccion='$direccion', codprovincia='$codprovincia', localidad='$localidad', codentidad='$codentidad', cuentabancaria='$cuentabanco', codpostal='$codpostal', telefono='$telefono', movil='$movil', email='$email', web='$web', borrado=0 WHERE codproveedor='$codproveedor'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos del proveedor han sido modificados correctamente"; }
	$cabecera1="Inicio >> Proveedores &gt;&gt; Modificar Proveedor ";
	$cabecera2="MODIFICAR PROVEEDOR ";
}

if ($accion=="baja") {
	$codproveedor=$_GET["codproveedor"];
	$query="UPDATE proveedores SET borrado=1 WHERE codproveedor='$codproveedor'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="El proveedor ha sido eliminado correctamente"; }
	$cabecera1="Inicio >> Proveedores &gt;&gt; Eliminar Proveedor ";
	$cabecera2="ELIMINAR PROVEEDOR ";
	$query_mostrar="SELECT * FROM proveedores WHERE codproveedor='$codproveedor'";
	$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
	$nombre=mysqli_result($rs_mostrar,0,"nombre");
	$nif=mysqli_result($rs_mostrar,0,"nif");
	$direccion=mysqli_result($rs_mostrar,0,"direccion");
	$localidad=mysqli_result($rs_mostrar,0,"localidad");
	$codprovincia=mysqli_result($rs_mostrar,0,"codprovincia");
	$codentidad=mysqli_result($rs_mostrar,0,"codentidad");
	$cuentabanco=mysqli_result($rs_mostrar,0,"cuentabancaria");
	$codpostal=mysqli_result($rs_mostrar,0,"codpostal");
	$telefono=mysqli_result($rs_mostrar,0,"telefono");
	$movil=mysqli_result($rs_mostrar,0,"movil");
	$email=mysqli_result($rs_mostrar,0,"email");
	$web=mysqli_result($rs_mostrar,0,"web");
}

?>

<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script language="javascript">
		
		function aceptar() {
			location.href="index.php";
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
				<div id="tituloForm" class="header"><?php echo $cabecera2?></div>
				<div id="frmBusqueda">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%"></td>
							<td width="85%" colspan="2" class="mensaje"><?php echo $mensaje;?></td>
					    </tr>
						<tr>
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codproveedor?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre?></td>
					    </tr>
						<tr>
						  <td>NIF / CIF</td>
						  <td colspan="2"><?php echo $nif?></td>
					  </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td colspan="2"><?php echo $direccion?></td>
					  </tr>
						<tr>
						  <td>Localidad</td>
						  <td colspan="2"><?php echo $localidad?></td>
					  </tr>
					  <?php
					  	if ($codprovincia<>0) {
							$query_provincias="SELECT * FROM provincias WHERE codprovincia='$codprovincia'";
							$res_provincias=mysqli_query($descriptor,$query_provincias);
							$nombreprovincia=mysqli_result($res_provincias,0,"nombreprovincia");
						} else {
							$nombreprovincia="Sin determinar";
						}
					  ?>
						<tr>
							<td width="15%">Provincia</td>
							<td width="85%" colspan="2"><?php echo $nombreprovincia?></td>
					    </tr>
						<?php
						if ($codentidad<>0) {
							$query_entidades="SELECT * FROM entidades WHERE codentidad='$codentidad'";
							$res_entidades=mysqli_query($descriptor,$query_entidades);
							$nombreentidad=mysqli_result($res_entidades,0,"nombreentidad");
						} else {
							$nombreentidad="Sin determinar";
						}
					  ?>
						<tr>
							<td width="15%">Entidad Bancaria</td>
							<td width="85%" colspan="2"><?php echo $nombreentidad?></td>
					    </tr>
						<tr>
							<td>Cuenta bancaria</td>
							<td colspan="2"><?php echo $cuentabanco?></td>
						</tr>
						<tr>
							<td>C&oacute;digo postal</td>
							<td colspan="2"><?php echo $codpostal?></td>
						</tr>
						<tr>
							<td>Tel&eacute;fono</td>
							<td><?php echo $telefono?></td>
						</tr>
						<tr>
							<td>M&oacute;vil</td>
							<td colspan="2"><?php echo $movil?></td>
						</tr>
						<tr>
							<td>Correo electr&oacute;nico  </td>
							<td colspan="2"><?php echo $email?></td>
						</tr>
												<tr>
							<td>Direcci&oacute;n web </td>
							<td colspan="2"><?php echo $web?></td>
						</tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="aceptar()" border="1" onMouseOver="style.cursor=cursor">
			  </div>
			  </div>
		  </div>
		</div>
	</body>
</html>
