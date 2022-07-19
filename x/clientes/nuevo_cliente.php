<?php include ("../conectar.php"); ?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../funciones/validar.js"></script>
		<script language="javascript">
		
		function cancelar() {
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
		
		function limpiar() {
			document.getElementById("formulario").reset();
		}
		
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">INSERTAR USUARIO </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_cliente.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="43%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45"></td>
					        <td width="42%" rowspan="14" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr>
						<tr>
						  <td>DNI</td>
						  <td><input id="nif" type="text" class="cajaPequena" NAME="anif" maxlength="15"></td>
				      </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td><input NAME="adireccion" type="text" class="cajaGrande" id="direccion" size="45" maxlength="45"></td>
				      </tr>
						<tr>
						  <td>Ciudad</td>
						  <td><input NAME="alocalidad" type="text" class="cajaGrande" id="localidad" size="35" maxlength="35"></td>
				      </tr>
					  <?php
					  	$query_provincias="SELECT * FROM provincias ORDER BY nombreprovincia ASC";
						$res_provincias=mysqli_query($descriptor,$query_provincias);
						$contador=0;
					  ?>
						<tr>
							<td width="15%">Area</td>
							<td width="43%"><select id="cboProvincias" name="cboProvincias" class="comboGrande">
							<option value="0">Seleccione una provincia</option>
								<?php
								while ($contador < mysqli_num_rows($res_provincias)) { ?>
								<option value="<?php echo mysqli_result($res_provincias,$contador,"codprovincia")?>"><?php echo mysqli_result($res_provincias,$contador,"nombreprovincia")?></option>
								<?php $contador++;
								} ?>				
								</select>							</td>
				        </tr>


					  <?php
					  	$query_tipou="SELECT * FROM tipoU ORDER BY nombreusuario ASC";
						$res_tipou=mysqli_query($descriptor,$query_tipou);
						$contador=0;
					  ?>


						<tr>
							<td width="15%">Rol</td>
							<td width="43%"><select id="nombreusuario" name="nombreusuario" class="comboGrande">
							<option value="0">Seleccione tipo de usuario</option>
								<?php
								while ($contador < mysqli_num_rows($res_tipou)) { ?>
								<option value="<?php echo mysqli_result($res_tipou,$contador,"nombreusuario")?>"><?php echo mysqli_result($res_tipou,$contador,"nombreusuario")?></option>
								<?php $contador++;
								} ?>				
								</select>							</td>
				        </tr>

						
						
						<tr>
							<td>Tel&eacute;fono </td>
							<td><input id="telefono" name="atelefono" type="text" class="cajaPequena" maxlength="14"></td>
					    </tr>
						<tr>
							<td>M&oacute;vil</td>
							<td><input id="movil" name="amovil" type="text" class="cajaPequena" maxlength="14"></td>
					    </tr>
						<tr>
							<td>Correo electr&oacute;nico  </td>
							<td><input NAME="aemail" type="text" class="cajaGrande" id="email" size="35" maxlength="35"></td>
						</tr>
						<tr>
							<td>contraseña </td>
							<td><input NAME="aemail" type="text" class="cajaGrande" id="password" size="35" maxlength="35"></td>
						</tr>
					
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="alta" type="hidden">
					<input id="id" name="Zid" value="" type="hidden">
			  </div>
			  </form>
			  </div>
		  </div>
		</div>
	</body>
</html>
