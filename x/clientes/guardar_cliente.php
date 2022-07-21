<?php
include ("../conectar.php"); 

$accion=$_POST["accion"];
if (!isset($accion)) { $accion=$_GET["accion"]; }

$nombre=$_POST["Anombre"];
$dni=$_POST["dni"];
$direccion=$_POST["adireccion"];
$localidad=$_POST["alocalidad"];
$codprovincia=$_POST["cboProvincias"];
$rol=$_POST["nombreusuario"];
$telefono=$_POST["atelefono"];
$movil=$_POST["amovil"];
$email=$_POST["aemail"];
$password=$_POST["password"];

if ($accion=="alta") {
	$query_operacion="INSERT INTO clientes (codcliente, nombre, dni, direccion, codprovincia, localidad,  telefono, movil, email, password,  borrado) VALUES ('', '$nombre', '$dni', '$direccion', '$codprovincia', '$localidad', '$telefono', '$movil', '$email', '$password', '0')";					
	$rs_operacion=mysqli_query($descriptor,$query_operacion);
	if ($rs_operacion) { $mensaje="El Usuario ha sido dado de alta correctamente"; }
	$cabecera1="Inicio >> Clientes &gt;&gt; Nuevo Cliente ";
	$cabecera2="INSERTAR CLIENTE ";
	$sel_maximo="SELECT max(codcliente) as maximo FROM clientes";
	$rs_maximo=mysqli_query($descriptor,$sel_maximo);
	$codcliente=mysqli_result($rs_maximo,0,"maximo");
}



if ($accion=="modificar") {
	$codcliente=$_POST["codcliente"];
	$query="UPDATE clientes SET nombre='$nombre', dni='$dni', direccion='$direccion', codprovincia='$codprovincia', localidad='$localidad', rol='$rol',  telefono='$telefono', movil='$movil', email='$email', password= '$password', borrado=0 WHERE codcliente='$codcliente'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="Los datos del Usuario han sido modificados correctamente"; }
	$cabecera1="Inicio >> Clientes &gt;&gt; Modificar Cliente ";
	$cabecera2="MODIFICAR CLIENTE ";
}

if ($accion=="baja") {
	$codcliente=$_GET["codcliente"];
	$query="UPDATE clientes SET borrado=1 WHERE codcliente='$codcliente'";
	$rs_query=mysqli_query($descriptor,$query);
	if ($rs_query) { $mensaje="El Usuario ha sido eliminado correctamente"; }
	$cabecera1="Inicio >> Clientes &gt;&gt; Eliminar Cliente ";
	$cabecera2="ELIMINAR CLIENTE ";
	$query_mostrar="SELECT * FROM clientes WHERE codcliente='$codcliente'";
	$rs_mostrar=mysqli_query($descriptor,$query_mostrar);
	$nombre=mysqli_result($rs_mostrar,0,"nombre");
	$dni=mysqli_result($rs_mostrar,0,"dni");
	$direccion=mysqli_result($rs_mostrar,0,"direccion");
	$localidad=mysqli_result($rs_mostrar,0,"localidad");
	$codprovincia=mysqli_result($rs_mostrar,0,"codprovincia");
	$rol=mysqli_result($rs_mostrar, 0, "rol");
	$telefono=mysqli_result($rs_mostrar,0,"telefono");
	$movil=mysqli_result($rs_mostrar,0,"movil");
	$email=mysqli_result($rs_mostrar,0,"email");
	$password=mysqli_result($rs_mostrar,0,"password");
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
							<td width="15%">C&oacute;digo</td>
							<td width="85%" colspan="2"><?php echo $codcliente?></td>
					    </tr>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="85%" colspan="2"><?php echo $nombre?></td>
					    </tr>
						<tr>
						  <td>DNI</td>
						  <td colspan="2"><?php echo $dni?></td>
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
							<td width="15%">Area</td>
							<td width="85%" colspan="2"><?php echo $nombreprovincia?></td>
					    </tr>


						<?php
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
							<td>contraseña </td>
							<td colspan="2"><?php echo $password?></td>

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
