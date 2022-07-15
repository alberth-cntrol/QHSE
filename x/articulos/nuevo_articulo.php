<?php 
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conectar.php"); ?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
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
			document.getElementById("referencia").value="";
			document.getElementById("descripcion").value="";
			document.getElementById("descripcion_corta").value="";
			document.getElementById("stock_minimo").value="";
			document.getElementById("stock").value="";
			document.getElementById("datos").value="";
			document.getElementById("fecha").value="";
			document.getElementById("unidades_caja").value="";
			document.getElementById("observaciones").value="";
			document.getElementById("precio_compra").value="";
			document.getElementById("precio_almacen").value="";
			document.getElementById("precio_tienda").value="";
			//document.getElementById("pvp").value="";
			document.getElementById("precio_iva").value="";
			document.getElementById("foto").value="";
			document.formulario.cboFamilias.options[0].selected = true;
			document.formulario.cboImpuestos.options[0].selected = true;
			document.formulario.cboProveedores1.options[0].selected = true;
			document.formulario.cboProveedores2.options[0].selected = true;
			document.formulario.cboUbicacion.options[0].selected = true;
			document.formulario.cboEmbalaje.options[0].selected = true;
			document.formulario.Aaviso_minimo.options[0].selected = true;
			document.formulario.Aprecio_ticket.options[0].selected = true;
			document.formulario.Amodif_descrip.options[0].selected = true;
		}
		</script>
	</head>
	<body>
		<div id="pagina">
			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header">INSERTAR ARTICULO </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_articulo.php" enctype="multipart/form-data">
				<input id="accion" name="accion" value="alta" type="hidden">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
						<td width="15%">Referencia</td>
					      <td width="30%"><input name="Areferencia" id="referencia" value="" maxlength="20" class="cajaGrande" type="text"></td>
				          <td width="55%" rowspan="15" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr>
						<?php
					  	$query_familias="SELECT * FROM familias WHERE borrado=0 ORDER BY nombre ASC";
						$res_familias=mysqli_query($descriptor,$query_familias);
						$contador=0;
					  ?>
						<tr>
							<td width="17%">Familia</td>
							<td><select id="cboFamilias" name="AcboFamilias" class="comboGrande">
							
								<option value="0">Seleccione una familia</option>
								<?php
								while ($contador < mysqli_num_rows($res_familias)) { ?>
								<option value="<?php echo mysqli_result($res_familias,$contador,"codfamilia")?>"><?php echo mysqli_result($res_familias,$contador,"nombre")?></option>
								<?php $contador++;
								} ?>				
								</select>							</td>
				        </tr>
						<tr>
							<td width="17%">Descripci&oacute;n</td>
						    <td><textarea name="Adescripcion" cols="41" rows="2" id="descripcion" class="areaTexto"></textarea></td>
				        </tr>
						<?php
					  	$query_impuesto="SELECT codimpuesto,valor FROM impuestos WHERE borrado=0 ORDER BY nombre ASC";
						$res_impuesto=mysqli_query($descriptor,$query_impuesto);
						$contador=0;
					  ?>
						<tr>
							<td width="17%">Impuesto</td>
							<td><select id="cboImpuestos" name="AcboImpuestos" class="comboMedio">
							
								<option value="0">Seleccione un impuesto</option>
								<?php
								while ($contador < mysqli_num_rows($res_impuesto)) { ?>
								<option value="<?php echo mysqli_result($res_impuesto,$contador,"valor")?>"><?php echo mysqli_result($res_impuesto,$contador,"valor")?></option>
								<?php $contador++;
								} ?>				
								</select> %							</td>
				        </tr>
						<?php
					  	$query_proveedores="SELECT codproveedor,nombre,nif FROM proveedores WHERE borrado=0 ORDER BY nombre ASC";
						$res_proveedores=mysqli_query($descriptor,$query_proveedores);
						$contador=0;
					  ?>
						<tr>
							<td>Proveedor 1</td>
							<td><select id="cboProveedores1" name="acboProveedores1" class="comboGrande">
							<option value="0">Todos los proveedores</option>
								<?php
								while ($contador < mysqli_num_rows($res_proveedores)) { 
									if ( mysqli_result($res_proveedores,$contador,"codproveedor") == $proveedor) { ?>
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor")?>" selected><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php } else { ?> 
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor")?>"><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php }
								$contador++;
								} ?>				
								</select>							</td>
					    </tr>
					<?php
					  	$query_proveedores="SELECT codproveedor,nombre,nif FROM proveedores WHERE borrado=0 ORDER BY nombre ASC";
						$res_proveedores=mysqli_query($descriptor,$query_proveedores);
						$contador=0;
					  ?>
						<tr>
							<td>Proveedor 2</td>
							<td><select id="cboProveedores2" name="acboProveedores2" class="comboGrande">
							<option value="0">Todos los proveedores</option>
								<?php
								while ($contador < mysqli_num_rows($res_proveedores)) { 
									if ( mysqli_result($res_proveedores,$contador,"codproveedor") == $proveedor) { ?>
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor")?>" selected><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php } else { ?> 
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor")?>"><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php }
								$contador++;
								} ?>				
								</select>							</td>
					    </tr>
						<tr>
						  <td>Descripci&oacute;n corta</td>
						  <td><input NAME="Adescripcion_corta" id="descripcion_corta" type="text" class="cajaGrande"  maxlength="30"></td>
				      </tr>
					  <?php
					  	$query_ubicacion="SELECT codubicacion,nombre FROM ubicaciones WHERE borrado=0 ORDER BY nombre ASC";
						$res_ubicacion=mysqli_query($descriptor,$query_ubicacion);
						$contador=0;
					  ?>
						<tr>
							<td>Ubicaci&oacute;n</td>
							<td><select id="cboUbicacion" name="AcboUbicacion" class="comboGrande">
							<option value="0">Todas las ubicaciones</option>
								<?php
								while ($contador < mysqli_num_rows($res_ubicacion)) { 
									if ( mysqli_result($res_ubicacion,$contador,"codubicacion") == $ubicacion) { ?>
								<option value="<?php echo mysqli_result($res_ubicacion,$contador,"codubicacion")?>" selected><?php echo mysqli_result($res_ubicacion,$contador,"nombre")?></option>
								<?php } else { ?> 
								<option value="<?php echo mysqli_result($res_ubicacion,$contador,"codubicacion")?>"><?php echo mysqli_result($res_ubicacion,$contador,"nombre")?></option>
								<?php }
								$contador++;
								} ?>				
								</select>							</td>
					    </tr>
						<tr>
						 <td>Stock</td>
						  <td><input NAME="nstock" type="text" class="cajaPequena" id="stock" size="10" maxlength="10"> unidades</td>
				      </tr>
					  	<tr>
						 <td>Stock m&iacute;nimo</td>
						  <td><input NAME="nstock_minimo" type="text" class="cajaPequena" id="stock_minimo" size="8" maxlength="8"> unidades</td>
				      </tr>
					  	<tr>
						 <td>Aviso m&iacute;nimo</td>
						  <td><select name="aaviso_minimo" id="aviso_minimo" class="comboPequeno">
						  <option value="0" selected="selected">No</option>
						  <option value="1">Si</option>
						  </select></td>
				      </tr>
					  <tr>
							<td width="17%">Datos del producto</td>
						    <td><textarea name="adatos" cols="41" rows="2" id="datos" class="areaTexto"></textarea></td>
				        </tr>
						<tr>
							<td>Fecha de alta</td>
							<td><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" readonly> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
        <script type="text/javascript">
					Calendar.setup(
					  {
					inputField : "fecha",
					ifFormat   : "%d/%m/%Y",
					button     : "Image1"
					  }
					);
		</script></td>
					    </tr>
						 <?php
					  	$query_embalaje="SELECT codembalaje,nombre FROM embalajes WHERE borrado=0 ORDER BY nombre ASC";
						$res_embalaje=mysqli_query($descriptor,$query_embalaje);
						$contador=0;
					  ?>
						<tr>
							<td>Embalaje</td>
							<td><select id="cboEmbalaje" name="AcboEmbalaje" class="comboGrande">
							<option value="0">Todos los embalajes</option>
								<?php
								while ($contador < mysqli_num_rows($res_embalaje)) { 
									if ( mysqli_result($res_embalaje,$contador,"codembalaje") == $embalaje) { ?>
								<option value="<?php echo mysqli_result($res_embalaje,$contador,"codembalaje")?>" selected><?php echo mysqli_result($res_embalaje,$contador,"nombre")?></option>
								<?php } else { ?> 
								<option value="<?php echo mysqli_result($res_embalaje,$contador,"codembalaje")?>"><?php echo mysqli_result($res_embalaje,$contador,"nombre")?></option>
								<?php }
								$contador++;
								} ?>				
								</select>							</td>
					    </tr>
						<tr>
						 <td>Unidades por caja</td>
						  <td><input NAME="nunidades_caja" type="text" class="cajaPequena" id="unidades_caja" size="10" maxlength="10"> unidades</td>
				      </tr>
					  <tr>
						 <td>Preguntar precio ticket</td>
						  <td><select name="aprecio_ticket" id="precio_ticket" class="comboPequeno">
						  <option value="0" selected="selected">No</option>
						  <option value="1">Si</option>
						  </select></td>
				      </tr>
					  <tr>
						 <td>Modificar descrip. en ticket</td>
						  <td><select name="amodif_descrip" id="modif_descrip" class="comboPequeno">
						  <option value="0" selected="selected">No</option>
						  <option value="1">Si</option>
						  </select></td>
				      </tr>
					  	 <tr>
							<td width="17%">Observaciones</td>
						    <td><textarea name="aobservaciones" cols="41" rows="2" id="observaciones" class="areaTexto"></textarea></td>
				        </tr>
						<tr>
						  <td>Precio de compra</td>
						  <td><input NAME="qprecio_compra" type="text" class="cajaPequena" id="precio_compra" size="10" maxlength="10"> &#8364;</td>
				      </tr>
					  	<tr>
						  <td>Precio de almac&eacute;n</td>
						  <td><input NAME="qprecio_almacen" type="text" class="cajaPequena" id="precio_almacen" size="10" maxlength="10"> &#8364;</td>
				      </tr>
						<tr>
						  <td>Precio de tienda</td>
						  <td><input NAME="qprecio_tienda" type="text" class="cajaPequena" id="precio_tienda" size="10" maxlength="10"> &#8364;</td>
				      </tr>
					  	<!--<tr>
						  <td>Pvp</td>
						  <td><input NAME="qpvp" type="text" class="cajaPequena" id="pvp" size="10" maxlength="10"> &#8364;</td>
				      </tr>-->
					  <tr>
						  <td>Precio con iva</td>
						  <td><input NAME="qprecio_iva" type="text" class="cajaPequena" id="precio_iva" size="10" maxlength="10"> &#8364;</td>
				      </tr>
					  <tr>
						  <td>Imagen [Formato jpg] [200x200]</td>
						  <td><input type="file" name="foto" id="foto" class="cajaMedia" accept="image/jpg" /></td>
				      </tr>
					</table>
			  </div>
				<div id="botonBusqueda">
				<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">
					<input type="hidden" name="id" id="id" value="">					
			  </div>
			  </form>	
			 </div>			
		  </div>
		</div>
	</body>
</html>
