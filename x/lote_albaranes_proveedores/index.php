<?php
include ("../conectar.php");

@$cadena_busqueda=$_GET["cadena_busqueda"];

if (!isset($cadena_busqueda)) { $cadena_busqueda=""; } else { $cadena_busqueda=str_replace("",",",$cadena_busqueda); }

if ($cadena_busqueda<>"") {
	$array_cadena_busqueda=explode("~",$cadena_busqueda);
	$codproveedor=$array_cadena_busqueda[1];
	$nombre=$array_cadena_busqueda[2];
	$numalbaranini=$array_cadena_busqueda[3];
	$numalbaranfin=$array_cadena_busqueda[4];
	$fechainicio=$array_cadena_busqueda[5];
	$fechafin=$array_cadena_busqueda[6];
} else {
	$codproveedor="";
	$nombre="";
	$numalbaranini="";
	$numalbaranfin="";
	$fechainicio="";
	$fechafin="";
}

?>
<html>
	<head>
		<title>Albaranes</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">
		<link href="../calendario/calendar-blue.css" rel="stylesheet" type="text/css">
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/lang/calendar-sp.js"></script>
		<script type="text/JavaScript" language="javascript" src="../calendario/calendar-setup.js"></script>
		<script language="javascript">
		var cursor;
		if (document.all) {
		// Está utilizando EXPLORER
		cursor='hand';
		} else {
		// Está utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		function activartodos() {
			if (document.formulario.todos.checked==true) {
				for (i=0;i<frames['frame_rejilla'].document.form1.elements.length;i++)
				  if(frames['frame_rejilla'].document.form1.elements[i].type == "checkbox")
					 frames['frame_rejilla'].document.form1.elements[i].checked=1
			} else {
				for (i=0;i<frames['frame_rejilla'].document.form1.elements.length;i++)
				  if(frames['frame_rejilla'].document.form1.elements[i].type == "checkbox")
					 frames['frame_rejilla'].document.form1.elements[i].checked=0
			}
		}
		
		function devolver_cadena_checks(frame,check) {
			cadena="";
			existe=false;
			contador_check=0;
			opciones=0;
		
			for (i=0;i<eval("frames['"+frame+"'].document.form1.elements.length");i++) {
				if (eval("frames['"+frame+"'].document.form1.elements[i].name=='"+check+"'")) {
					contador_check=contador_check+1;
					existe=true;				
				}				
			}
		
			if (existe) {
				if (contador_check==1) {
				//sólo hay un check, o sea, que no se forma un array con los checks y hay que 
				//evaluarlo independientemente
					if (eval("frames['"+frame+"'].document.getElementById('"+check+"').checked")) {
						cadena=eval("frames['"+frame+"'].document.getElementById('"+check+"').value+'~'");
						opciones=1;
					}
				} else {		
		
					for (i=0;i<eval("frames['"+frame+"'].document.form1.elements.length");i++) { 
						if (eval("(frames['"+frame+"'].document.form1.elements[i].checked)") && eval("(frames['"+frame+"'].document.form1.elements[i].name=='"+check+"')")) {
							cadena=cadena+eval("frames['"+frame+"'].document.form1.elements[i].value+'~'");
							opciones=opciones+1;
						}
					} 
				}
			}
							
			if (cadena=="") {
				return "";
			} else {
				cadena="~"+cadena;
				return cadena;
			}		
		}
		
		function abreVentana(){
			miPopup = window.open("ver_proveedores.php","miwin","width=700,height=380,scrollbars=yes");
			miPopup.focus();
		}
		
		function validarproveedor(){
			var codigo=document.getElementById("codproveedor").value;
			miPopup = window.open("comprobarproveedor.php?codproveedor="+codigo,"frame_datos","width=700,height=80,scrollbars=yes");
		}
		
		function facturar_albaran() {
			var cadena_elegidos="";
			var codproveedor=document.getElementById("codproveedor").value;
			cadena_elegidos=devolver_cadena_checks("frame_rejilla","checkbox_socio");
			if (opciones==0)  {
				alert("No hay albaranes seleccionados.");
			} else {
				if (confirm("Va a facturar "+opciones+" albaranes. Desea continuar?")) {
					window.location.href="configurar_lote.php?cadena_busqueda="+cadena_busqueda+"&cadena_elegidos="+cadena_elegidos+"&codproveedor="+codproveedor;
					}
			}
		}
		
		function buscar() {
			var cadena;
			var nombre=document.getElementById("nombre").value;
			if (nombre=="") {
				alert ("Debe seleccionar un proveedor.");
			} else {
				cadena=hacer_cadena_busqueda();
				document.getElementById("cadena_busqueda").value=cadena;
				if (document.getElementById("iniciopagina").value=="") {
					document.getElementById("iniciopagina").value=1;
				} else {
					document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
				}
				document.getElementById("formulario").submit();
			}
		}
		
		function paginar() {
			document.getElementById("iniciopagina").value=document.getElementById("paginas").value;
			document.getElementById("formulario").submit();
		}
		
		function hacer_cadena_busqueda() {
			var codproveedor=document.getElementById("codproveedor").value;
			var nombre=document.getElementById("nombre").value;
			var numalbaranini=document.getElementById("numalbaranini").value;			
			var numalbaranfin=document.getElementById("numalbaranfin").value;
			var fechainicio=document.getElementById("fechainicio").value;
			var fechafin=document.getElementById("fechafin").value;
			var cadena="";
			cadena="~"+codproveedor+"~"+nombre+"~"+numalbaranini+"~"+numalbaranfin+"~"+fechainicio+"~"+fechafin+"~";
			return cadena;
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
				<div id="tituloForm" class="header">Facturar ALBARANES </div>
				<div id="frmBusqueda">
				<form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
					<table class="fuente8" width="98%" cellspacing=0 cellpadding=3 border=0>					
						<tr>
							<td width="16%">Codigo de proveedor </td>
							<td width="68%"><input id="codproveedor" type="text" class="cajaPequena" NAME="codproveedor" maxlength="10"><img src="../img/ver.png" width="16" height="16" onClick="abreVentana()" title="Buscar proveedor"> <img src="../img/cliente.png" width="16" height="16" onClick="validarproveedor()" title="Validar proveedor"></td>
							<td width="5%">&nbsp;</td>
							<td width="5%">&nbsp;</td>
							<td width="6%" align="right"></td>
						</tr>
						<tr>
							<td>Nombre</td>
							<td><input id="nombre" name="nombre" type="text" class="cajaGrande" maxlength="45" readonly="yes"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td>NIF</td>
							<td><input id="nif" name="nif" type="text" class="cajaMedia" maxlength="20" readonly="yes"></td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
						  <td>Num. Albaran Inicial</td>
						  <td><input id="numalbaranini" type="text" class="cajaPequena" NAME="numalbaranini" maxlength="15" value="<?php echo $numalbaranini?>"></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Num. Albaran Final</td>
						  <td><input id="numalbaranfin" type="text" class="cajaPequena" NAME="numalbaranfin" maxlength="15" value="<?php echo $numalbaranfin?>"></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Fecha de inicio</td>
						  <td><input id="fechainicio" type="text" class="cajaPequena" NAME="fechainicio" maxlength="10" value="<?php echo $fechainicio?>" readonly><img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'" title="Calendario">
        <script type="text/javascript">
					Calendar.setup(
					  {
					inputField : "fechainicio",
					ifFormat   : "%d/%m/%Y",
					button     : "Image1"
					  }
					);
		</script>	</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
						<tr>
						  <td>Fecha de fin</td>
						  <td><input id="fechafin" type="text" class="cajaPequena" NAME="fechafin" maxlength="10" value="<?php echo $fechafin?>" readonly><img src="../img/calendario.png" name="Image1" id="Image1" width="16" height="16" border="0" id="Image1" onMouseOver="this.style.cursor='pointer'">
        <script type="text/javascript">
					Calendar.setup(
					  {
					inputField : "fechafin",
					ifFormat   : "%d/%m/%Y",
					button     : "Image1"
					  }
					);
		</script></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					</table>
			  </div>
			 	<div id="botonBusqueda">
				<img src="../img/botonbuscar.jpg" width="69" height="22" border="1" onClick="buscar()" onMouseOver="style.cursor=cursor">
			 	  <img src="../img/botonlimpiar.jpg" width="69" height="22" border="1" onClick="limpiar()" onMouseOver="style.cursor=cursor">
					 <img src="../img/botonfacturaralbaranes.jpg" width="131" height="22" border="1" onClick="facturar_albaran()" onMouseOver="style.cursor=cursor">				
				</div>
			  <div id="lineaResultado">
			  <table class="fuente8" width="80%" cellspacing=0 cellpadding=3 border=0>
			  	<tr>
				<td width="50%" align="left">N de albaranes encontrados <input id="filas" type="text" class="cajaPequena" NAME="filas" maxlength="5" readonly></td>
				<td width="50%" align="right">Mostrados <select name="paginas" id="paginas" onChange="paginar()">
		          </select></td>
			  </table>
				</div>
				<div id="cabeceraResultado" class="header">
					relacion de ALBARANES </div>
				<div id="frmResultado">
				<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0 ID="Table1">
						<tr class="cabeceraTabla">
							<td width="10%"><input name="todos" type="checkbox" value="todos" onClick="activartodos()"></td>
							<td width="15%">ITEM</td>
							<td width="25%">N. ALBARAN</td>
							<td width="25%">IMPORTE </td>							
							<td width="25%">FECHA</td>							
						</tr>
				</table>
				</div>
				<input type="hidden" id="iniciopagina" name="iniciopagina">
				<input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
			</form>
				<div id="lineaResultado">
					<iframe width="100%" height="250" id="frame_rejilla" name="frame_rejilla" frameborder="0">
						<ilayer width="100%" height="250" id="frame_rejilla" name="frame_rejilla"></ilayer>
					</iframe>
				</div>
				<iframe id="frame_datos" name="frame_datos" width="0" height="0" frameborder="0">
					<ilayer width="0" height="0" id="frame_datos" name="frame_datos"></ilayer>
					</iframe>
				</div>
		  </div>			
		</div>
	</body>
</html>
