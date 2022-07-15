<?php
include ("../conectar.php");
include ("../funciones/fechas.php");

$fechainicio=$_POST["fechainicio"];
if ($fechainicio<>"") { $fechainicio=explota($fechainicio); }

$cadena_busqueda=$_POST["cadena_busqueda"];

//$sel_facturas="SELECT max(codfactura) as maximo, min(codfactura) as minimo, sum(totalfactura) as totalfac FROM facturas WHERE fecha='$fechainicio'";
$sel_facturas="SELECT max(cobros.codfactura) as maximo, min(cobros.codfactura) as minimo, sum(totalfactura) as totalfac FROM cobros INNER JOIN facturas ON cobros.codfactura=facturas.codfactura WHERE fechacobro='$fechainicio'";
$rs_facturas=mysqli_query($descriptor,$sel_facturas);

if (mysqli_num_rows($rs_facturas) > 0 ) {
	$minimo=mysqli_result($rs_facturas,0,"minimo");
	$maximo=mysqli_result($rs_facturas,0,"maximo");
	$total=mysqli_result($rs_facturas,0,"totalfac");
} else {
	$minimo=0;
	$maximo=0;
	$total=0;
}
$neto=$total/1.16;
$iva=$total-$neto;

$sel_cobros="SELECT sum(importe) as suma,codformapago FROM cobros WHERE fechacobro='$fechainicio' GROUP BY codformapago ORDER BY codformapago ASC";

$rs_cobros=mysqli_query($descriptor,$sel_cobros);

if (mysqli_num_rows($rs_cobros) > 0) { $contado=mysqli_result($rs_cobros,0,"suma"); } else { $contado=0; }
if (mysqli_num_rows($rs_cobros) > 1) { $tarjeta=mysqli_result($rs_cobros,1,"suma"); } else { $tarjeta=0; }

?>
<html>
	<head>
		<title>Cierre Caja</title>
		<link href="../estilos/estilos.css" type="text/css" rel="stylesheet">	
		<script>
		
		var cursor;
		if (document.all) {
		// Est� utilizando EXPLORER
		cursor='hand';
		} else {
		// Est� utilizando MOZILLA/NETSCAPE
		cursor='pointer';
		}
		
		 function imprimir(fechainicio,minimo,maximo,neto,iva,total,contado,tarjeta) {
			location.href="../fpdf/cerrarcaja_html.php?fechainicio="+fechainicio+"&minimo="+minimo+"&maximo="+maximo+"&neto="+neto+"&iva="+iva+"&total="+total+"&contado="+contado+"&tarjeta="+tarjeta;	
		 }
		</script>
	</head>

	<body>	
		<div id="pagina">
			<div id="zonaContenido">
			<div align="center">
				<form id="formulario" name="formulario" method="post" action="rejilla.php" target="frame_rejilla">
					<table class="fuente8" width="100%" cellspacing=0 cellpadding=3 border=0>					
					  <tr>
						  <td width="18%">Caja Fecha</td>
						  <td width="14%"><? echo implota($fechainicio)?>	</td>
						  <td width="12%">&nbsp;</td>
						  <td width="50%">&nbsp;</td>
						  <td width="6%">&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Del ticket n&deg;</td>
						  <td><? echo $minimo?>	</td>
						  <td>al ticket n&deg;</td>
						  <td><? echo $maximo?></td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Neto</td>
						  <td><? echo number_format($neto,2,",",".")?> &#8364;</td>
						  <td></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>16 % IVA</td>
						  <td><? echo number_format($iva,2,",",".")?> &#8364;</td>
						  <td></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Total</td>
						  <td><? echo number_format($total,2,",",".")?> &#8364;</td>
						  <td></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Total contado</td>
						  <td><? echo number_format($contado,2,",",".")?> &#8364;</td>
						  <td></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Total tarjetas</td>
						  <td><? echo number_format($tarjeta,2,",",".")?> &#8364;</td>
						  <td></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					  <tr>
						  <td>Total</td>
						  <td><? echo number_format($total,2,",",".")?> &#8364;</td>
						  <td></td>
						  <td>&nbsp;</td>
						  <td>&nbsp;</td>
					  </tr>
					</table>
			  </div>
			  <div id="botonBusqueda">
			  <img src="../img/botonimprimir.jpg" width="79" height="22" border="1" onClick="imprimir('<? echo $fechainicio?>','<? echo $minimo?>','<? echo $maximo?>','<? echo $neto?>','<? echo $iva?>','<? echo $total?>','<? echo $contado?>','<? echo $tarjeta?>')" onMouseOver="style.cursor=cursor">		
				</div>
			</div>	
		</div>
	</body>
</html>
