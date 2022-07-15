<?php 
header('Cache-Control: no-cache');
header('Pragma: no-cache'); 

include ("../conectar.php"); 
include ("../funciones/fechas.php"); 
include ("../barcode/barcode.php");

@$codarticulo=$_GET["codarticulo"];
@$cadena_busqueda=$_GET["cadena_busqueda"];


$query="SELECT * FROM articulos WHERE codarticulo='$codarticulo'";
$rs_query=mysqli_query($descriptor,$query);
$codigobarras=mysqli_result($rs_query,0,"codigobarras");

?>
<html>
	<head>
		<title>Principal</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<script type="text/javascript" src="../funciones/validar.js"></script>
		<script language="javascript">
		
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function cancelar() {
			location.href="index.php?cadena_busqueda=<?php echo $cadena_busqueda?>";
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
				<div id="tituloForm" class="header">MODIFICAR ARTICULO </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="guardar_articulo.php" enctype="multipart/form-data">
				<input id="accion" name="accion" value="modificar" type="hidden">
				<input id="id" name="id" value="<?php echo $codarticulo?>" type="hidden">
				<input id="codarticulo" name="codarticulo" value="<?php echo $codarticulo?>" type="hidden">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>
						<tr>
						<td width="20%">Referencia</td>
						<?php $referencia=mysqli_result($rs_query,0,"referencia");?>
					      <td colspan="2"><input name="Areferencia" id="referencia" value="<?php echo mysqli_result($rs_query,0,"referencia")?>" maxlength="20" class="cajaGrande" type="text"></td>
				          <td width="4%" rowspan="15" align="left" valign="top"><ul id="lista-errores"></ul></td>
						</tr>
						<?php
						$familia=mysqli_result($rs_query,0,"codfamilia");
					  	$query_familias="SELECT * FROM familias WHERE borrado=0 ORDER BY nombre ASC";
						$res_familias=mysqli_query($descriptor,$query_familias);
						$contador=0;
					  ?>
						<tr>
							<td width="11%">Familia</td>
							<td colspan="2"><select id="cboFamilias" name="AcboFamilias" class="comboGrande">
							
								<option value="0">Seleccione una familia</option>
								<?php
								while ($contador < mysqli_num_rows($res_familias)) { 
									if ($familia==mysqli_result($res_familias,$contador,"codfamilia")) {?>
								<option value="<?php echo mysqli_result($res_familias,$contador,"codfamilia")?>" selected="selected"><?php echo mysqli_result($res_familias,$contador,"nombre")?></option>
								<?php } else { ?>
								<option value="<?php echo mysqli_result($res_familias,$contador,"codfamilia")?>"><?php echo mysqli_result($res_familias,$contador,"nombre")?></option>
								<?php } 
									$contador++;
								} ?>				
								</select>							</td>
				        </tr>
						<tr>
							<td width="11%">Descripci&oacute;n</td>
						    <td colspan="2"><textarea name="Adescripcion" cols="41" rows="2" id="descripcion" class="areaTexto"><?php echo mysqli_result($rs_query,0,"descripcion")?></textarea></td>
				        </tr>
						<?php
						$impuesto=mysqli_result($rs_query,0,"impuesto");
					  	$query_impuesto="SELECT codimpuesto,valor FROM impuestos WHERE borrado=0 ORDER BY nombre ASC";
						$res_impuesto=mysqli_query($descriptor,$query_impuesto);
						$contador=0;
					  ?>
						<tr>
							<td width="11%">Impuesto</td>
							<td colspan="2"><select id="cboImpuestos" name="AcboImpuestos" class="comboMedio">
							
								<option value="0">Seleccione un impuesto</option>
								<?php
								while ($contador < mysqli_num_rows($res_impuesto)) { 
									if ($impuesto==mysqli_result($res_impuesto,$contador,"valor")) { ?>
								<option value="<?php echo mysqli_result($res_impuesto,$contador,"valor")?>" selected="selected"><?php echo mysqli_result($res_impuesto,$contador,"valor")?></option>
								<?php } else { ?>
								<option value="<?php echo mysqli_result($res_impuesto,$contador,"valor")?>"><?php echo mysqli_result($res_impuesto,$contador,"valor")?></option>
								<?php } 
								$contador++;
								} ?>				
								</select> %							</td>
				        </tr>
						<?php
						$proveedor1=mysqli_result($rs_query,0,"codproveedor1");
					  	$query_proveedores="SELECT codproveedor as codproveedor1,nombre,nif FROM proveedores WHERE borrado=0 ORDER BY nombre ASC";
						$res_proveedores=mysqli_query($descriptor,$query_proveedores);
						$contador=0;
					  ?>
						<tr>
							<td>Proveedor 1</td>
							<td colspan="2"><select id="cboProveedores1" name="acboProveedores1" class="comboGrande">
							<?php if ($proveedor1==0) { ?>
							<option value="0" selected="selected">Todos los proveedores</option>
							<?php } else { ?>
							<option value="0">Todos los proveedores</option>
							<?php } ?>
								<?php
								while ($contador < mysqli_num_rows($res_proveedores)) { 
									if ( mysqli_result($res_proveedores,$contador,"codproveedor1") == $proveedor1) { ?>
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor1")?>" selected><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php } else { ?> 
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor1")?>"><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php }
								$contador++;
								} ?>				
								</select>							</td>
					    </tr>
					<?php
						$proveedor2=mysqli_result($rs_query,0,"codproveedor2");
					  	$query_proveedores="SELECT codproveedor as codproveedor2,nombre,nif FROM proveedores WHERE borrado=0 ORDER BY nombre ASC";
						$res_proveedores=mysqli_query($descriptor,$query_proveedores);
						$contador=0;
					  ?>
						<tr>
							<td>Proveedor 2</td>
							<td colspan="2"><select id="cboProveedores2" name="acboProveedores2" class="comboGrande">
							<option value="0">Todos los proveedores</option>
								<?php
								while ($contador < mysqli_num_rows($res_proveedores)) { 
									if ( mysqli_result($res_proveedores,$contador,"codproveedor2") == $proveedor2) { ?>
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor2")?>" selected><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php } else { ?> 
								<option value="<?php echo mysqli_result($res_proveedores,$contador,"codproveedor2")?>"><?php echo mysqli_result($res_proveedores,$contador,"nif")?> -- <?php echo mysqli_result($res_proveedores,$contador,"nombre")?></option>
								<?php }
								$contador++;
								} ?>				
								</select>							</td>
					    </tr>
						<tr>
						  <td>Descripci&oacute;n corta</td>
						  <td colspan="2"><input NAME="Adescripcion_corta" id="descripcion_corta" type="text" class="cajaGrande"  maxlength="30" value="<?php echo mysqli_result($rs_query,0,"descripcion_corta")?>"></td>
				      </tr>
					  <?php
					  	$codubicacion=mysqli_result($rs_query,0,"codubicacion");
					  	$query_ubicacion="SELECT codubicacion,nombre FROM ubicaciones WHERE borrado=0 ORDER BY nombre ASC";
						$res_ubicacion=mysqli_query($descriptor,$query_ubicacion);
						$contador=0;
					  ?>
						<tr>
							<td>Ubicaci&oacute;n</td>
							<td colspan="2"><select id="cboUbicacion" name="AcboUbicacion" class="comboGrande">
							<option value="0">Todas las ubicaciones</option>
								<?php
								while ($contador < mysqli_num_rows($res_ubicacion)) { 
									if ( mysqli_result($res_ubicacion,$contador,"codubicacion") == $codubicacion) { ?>
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
						  <td colspan="2"><input NAME="nstock" type="text" class="cajaPequena" id="stock" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"stock")?>"> unidades</td>
				      </tr>
					  	<tr>
						 <td>Stock m&iacute;nimo</td>
						  <td colspan="2"><input NAME="nstock_minimo" type="text" class="cajaPequena" id="stock_minimo" size="8" maxlength="8" value="<?php echo mysqli_result($rs_query,0,"stock_minimo")?>"> unidades</td>
				      </tr>
					  	<tr>
						 <td>Aviso m&iacute;nimo</td>
						  <td colspan="2"><select name="aaviso_minimo" id="aviso_minimo" class="comboPequeno">
						  <?php if (mysqli_result($rs_query,0,"aviso_minimo")==0) { ?>
						  <option value="0" selected="selected">No</option>
						  <option value="1">Si</option>
						  <?php } else { ?>
						  <option value="0">No</option>
						  <option value="1" selected="selected">Si</option>
						  <?php } ?>
						  </select></td>
				      </tr>
					  <tr>
							<td width="11%">Datos del producto</td>
						    <td colspan="2"><textarea name="adatos" cols="41" rows="2" id="datos" class="areaTexto"><?php echo mysqli_result($rs_query,0,"datos_producto")?></textarea></td>
				        </tr>
						<tr>
							<td>Fecha de alta</td>
							<td colspan="2"><input NAME="fecha" type="text" class="cajaPequena" id="fecha" size="10" maxlength="10" readonly value="<?php echo implota(mysqli_result($rs_query,0,"fecha_alta"))?>"> <img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
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
						 $embalaje=mysqli_result($rs_query,0,"codembalaje");
					  	$query_embalaje="SELECT codembalaje,nombre FROM embalajes WHERE borrado=0 ORDER BY nombre ASC";
						$res_embalaje=mysqli_query($descriptor,$query_embalaje);
						$contador=0;
					  ?>
						<tr>
							<td>Embalaje</td>
							<td colspan="2"><select id="cboEmbalaje" name="AcboEmbalaje" class="comboGrande">
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
						  <td colspan="2"><input NAME="nunidades_caja" type="text" class="cajaPequena" id="unidades_caja" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"unidades_caja")?>"> unidades</td>
				      </tr>
					  <tr>
						 <td>Preguntar precio ticket</td>
						  <td colspan="2"><select name="aprecio_ticket" id="precio_ticket" class="comboPequeno">
						  <?php if (mysqli_result($rs_query,0,"precio_ticket")==0) { ?> 
						  <option value="0" selected="selected">No</option>
						  <option value="1">Si</option>
						  <?php } else { ?>
						   <option value="0">No</option>
						  <option value="1" selected="selected">Si</option>
						  <?php } ?>
						  </select></td>
				      </tr>
					  <tr>
						 <td>Modificar descrip. en ticket</td>
						  <td colspan="2"><select name="amodif_descrip" id="modif_descrip" class="comboPequeno">
						   <?php if (mysqli_result($rs_query,0,"modificar_ticket")==0) { ?>
						  <option value="0" selected="selected">No</option>
						  <option value="1">Si</option>
						  <?php } else { ?>
						  <option value="0">No</option>
						  <option value="1" selected="selected">Si</option>
						  <?php } ?>
						  </select></td>
				      </tr>
					  	 <tr>
							<td width="11%">Observaciones</td>
						    <td colspan="2"><textarea name="aobservaciones" cols="41" rows="2" id="observaciones" class="areaTexto"><?php echo mysqli_result($rs_query,0,"observaciones")?></textarea></td>
				        </tr>
						<tr>
						  <td>Precio de compra</td>
						  <td colspan="2"><input NAME="qprecio_compra" type="text" class="cajaPequena" id="precio_compra" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"precio_compra")?>">
						  &#8364;</td>
				      </tr>
					  	<tr>
						  <td>Precio de almac&eacute;n</td>
						  <td colspan="2"><input NAME="qprecio_almacen" type="text" class="cajaPequena" id="precio_almacen" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"precio_almacen")?>">
						  &#8364;</td>
				      </tr>
						<tr>
						  <td>Precio de tienda</td>
						  <td colspan="2"><input NAME="qprecio_tienda" type="text" class="cajaPequena" id="precio_tienda" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"precio_tienda")?>">
						  &#8364;</td>
				      </tr>
					  	<!--<tr>
						  <td>Pvp</td>
						  <td colspan="2"><input NAME="qpvp" type="text" class="cajaPequena" id="pvp" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"precio_pvp")?>">
						  &#8364;</td>
				      </tr>-->
					  <tr>
						  <td>Precio con iva</td>
						  <td colspan="2"><input NAME="qprecio_iva" type="text" class="cajaPequena" id="precio_iva" size="10" maxlength="10" value="<?php echo mysqli_result($rs_query,0,"precio_iva")?>">
						  &#8364;</td>
				      </tr>
					  <tr>
						  <td>Imagen [Formato jpg] [200x200]</td>
					    <td width="55%"><input type="file" name="foto" id="foto" class="cajaMedia" accept="image/jpg" /></td>
				        <td width="30%" align="center" valign="top"><img src="../fotos/<? echo mysqli_result($rs_query,0,"imagen")?>" width="160px" height="140px" border="1"></td>
					  </tr>
					  							<tr>
							<td>Codigo de barras</td>
							<td colspan="2"><?php echo "<img src='../barcode/barcode.php?encode=EAN-13&bdata=".$codigobarras."&height=50&scale=2&bgcolor=%23FFFFEC&color=%23333366&type=jpg'>"; ?></td>
						</tr>
					</table>
			  </div>
				<div id="botonBusqueda">
				<img src="../img/botonaceptar.jpg" width="85" height="22" onClick="validar(formulario,true)" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botonlimpiar.jpg" width="69" height="22" onClick="limpiar()" border="1" onMouseOver="style.cursor=cursor">
					<img src="../img/botoncancelar.jpg" width="85" height="22" onClick="cancelar()" border="1" onMouseOver="style.cursor=cursor">					
			  </div>
			  </form>
			 </div>				
		  </div>
		</div>
	</body>
</html>			
