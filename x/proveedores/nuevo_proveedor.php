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
				<div id="tituloForm" class="header">INSERTAR PROVEEDOR </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_proveedor.php">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
							<td width="15%">Nombre</td>
						    <td width="43%"><input NAME="Anombre" type="text" class="cajaGrande" id="nombre" size="45" maxlength="45"></td>
					        <td width="42%" rowspan="12" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr>
						<tr>
						  <td>NIF / CIF</td>
						  <td><input id="nif" type="text" class="cajaPequena" NAME="anif" maxlength="15"></td>
				      </tr>
						<tr>
						  <td>Direcci&oacute;n</td>
						  <td><input NAME="adireccion" type="text" class="cajaGrande" id="direccion" size="45" maxlength="45"></td>
				      </tr>
						<tr>
						  <td>Localidad</td>
						  <td><input NAME="alocalidad" type="text" class="cajaGrande" id="localidad" size="35" maxlength="35"></td>
				      </tr>
					  <?php
					  	$query_provincias="SELECT * FROM provincias ORDER BY nombreprovincia ASC";
						$res_provincias=mysqli_query($descriptor,$query_provincias);
						$contador=0;
					  ?>
						<tr>
							<td width="15%">Provincia</td>
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
					  	$query_entidades="SELECT * FROM entidades WHERE borrado=0 ORDER BY nombreentidad ASC";
						$res_entidades=mysqli_query($descriptor,$query_entidades);
						$contador=0;
					  ?>
						<tr>
							<td width="15%">Entidad Bancaria</td>
							<td width="43%"><select id="cboBanco" name="cboBanco" class="comboGrande">
							<option value="0">Seleccione una Entidad Bancaria</option>
									<?php
								while ($contador < mysqli_num_rows($res_entidades)) { ?>
								<option value="<?php echo mysqli_result($res_entidades,$contador,"codentidad")?>"><?php echo mysqli_result($res_entidades,$contador,"nombreentidad")?></option>
								<?php $contador++;
								} ?>
											</select>							</td>
				        </tr>
						<tr>
							<td>Cuenta bancaria</td>
							<td><input id="cuentabanco" type="text" class="cajaGrande" NAME="acuentabanco" maxlength="20"></td>
					    </tr>
						<tr>
							<td>C&oacute;digo postal </td>
							<td><input id="codpostal" type="text" class="cajaPequena" NAME="acodpostal" maxlength="5"></td>
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
							<td>Direcci&oacute;n web </td>
							<td><input NAME="aweb" type="text" class="cajaGrande" id="web" size="45" maxlength="45"></td>
					    </tr>
					</table>
			  </div>
				<div id="botonBusqueda">
					<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input id="accion" name="accion" value="alta" type="hidden">
					<input id="id" name="id" value="" type="hidden">
			  </div>
			  </form>
		  </div>
		  </div>
		</div>
	</body>
</html>
