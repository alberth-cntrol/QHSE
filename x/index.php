<?php 
include("conectar.php");
?>
<html>

<head>
  <title>Oracle Consultig QHSE</title>
  <script language="JavaScript" src="menu/JSCookMenu.js"></script>
  <link rel="stylesheet" href="menu/theme.css" type="text/css">
  <script language="JavaScript" src="menu/theme.js"></script>
  <script language="JavaScript">
<!--
var MenuPrincipal = [
	[null,'Inicio','central2.php','principal','Inicio'],
	[null,'Personal',null,null,'Ventas clientes',
		//[null,'Proveedores','./proveedores/index.php','principal','Proveedores'],
		[null,'Listado de Personal','./clientes/index.php','principal','Clientes']
	],
	[null,'Historial',null,null,'Productos',
		[null,'Historial Formulario','./articulos/index.php','principal','Articulos'],
		//[null,'Familias','./familias/index.php','principal','Familias']
	],
	[null,'Formularios Personal',null,null,'Ventas clientes',
		[null,'Area 0001','./ventas_mostrador/index.php','principal','Ventas Mostrador'],
		[null,'Area 0002','./facturas_clientes/index.php','principal','Facturas'],
		[null,'Area 0003','./albaranes_clientes/index.php','principal','Albaranes'],
		[null,'Area 0004','./lote_albaranes_clientes/index.php','principal','Facturar albaranes']
	],
	[null,'Supervisores',null,null,'Compras proveedores',
		[null,'Lista de supervisores','./facturas_proveedores/index.php','principal','Proveedores'],
		//[null,'Albaranes','./albaranes_proveedores/index.php','principal','Albaranes'],
		//[null,'Facturar albaranes','./lote_albaranes_proveedores/index.php','principal','Facturar albaranes'],
	],
	/*[null,'Tesoreria',null,null,'Tesoreria',
		[null,'Cobros','./cobros/index.php','principal','Cobros'],
		[null,'Pagos','./pagos/index.php','principal','Pagos'],
		[null,'Caja Diaria','./cerrarcaja/index.php','principal','Caja Diaria'],
		[null,'Libro Diario','./librodiario/index.php','principal','Libro Diario'],
	],*/
	/*[null,'Mantenimientos',null,null,'Mantenimientos',
		[null,'Etiquetas','./etiquetas/index.php','principal','Etiquetas'],
		[null,'Impuestos','./impuestos/index.php','principal','Impuestos'],
		[null,'Entidades bancarias','./entidades/index.php','principal','Entidades bancarias'],
		[null,'Ubicaciones','./ubicaciones/index.php','principal','Ubicaciones'],
		[null,'Embalajes','./embalajes/index.php','principal','Embalajes'],
		[null,'Formas de pago','./formaspago/index.php','principal','Formas de pago'],
	],*/
	/*[null,'Copias Seguridad',null,null,'Copias de Seguridad',
		[null,'Hacer copia','./backup/hacerbak.php','principal','Hacer copia'],
		[null,'Restaurar copia','./backup/restaurarbak.php','principal','Restaurar copia'],
	],*/
	[null,'Creditos','creditos.php','principal','Creditos']
];

--></script>
  <style type="text/css">
  body { background-color: rgb(255, 255,255);
    background-image: url(images/superior.png);
    background-repeat: no-repeat;
	margin: 0px;
    }

  #MenuAplicacion { margin-left: 10px;
    margin-top: 0px;
    }


  </style>
</head>
<body>
<div id="MenuAplicacion" align="center"></div>
<script language="JavaScript">
<!--
	cmDraw ('MenuAplicacion', MenuPrincipal, 'hbr', cmThemeGray, 'ThemeGray');
-->
</script>
<iframe src="central2.php" name="principal" title="principal" width="100%" height="1050px" frameborder=0 scrolling="no" style="margin-left: 0px; margin-right: 0px; margin-top: 2px; margin-bottom: 0px;"></iframe>
</body>
</html>
