<?php
include ("./conectar.php");
$hoy=date("Y-m-d");

$sel_tmp="SELECT codalbaran FROM albaranestmp WHERE datediff('$hoy',fecha) > 2";
$rs_tmp=mysqli_query($descriptor, $sel_tmp);
$contador=0;
while ($contador < mysqli_num_rows( $rs_tmp)) {
	$codalbaran=mysqli_result($rs_tmp,$contador,"codalbaran");
	$sel_borrar="DELETE FROM albalineatmp WHERE codalbaran='$codalbaran'";
	$rs_borrar=mysqli_query($descriptor, $sel_borrar);
	$contador++;
}

$sel_borrar="DELETE FROM albaranestmp WHERE datediff('$hoy',fecha) > 2";
$rs_borrar=mysqli_query($descriptor, $sel_borrar);

$sel_tmp="SELECT codalbaran FROM albaranesptmp WHERE datediff('$hoy',fecha) > 2";
$rs_tmp=mysqli_query($descriptor, $sel_tmp);
$contador=0;
while ($contador < mysqli_num_rows( $rs_tmp)) {
	$codalbaran=mysqli_result($rs_tmp,$contador,"codalbaran");
	$sel_borrar="DELETE FROM albalineaptmp WHERE codalbaran='$codalbaran'";
	$rs_borrar=mysqli_query($descriptor, $sel_borrar);
	$contador++;
}

$sel_borrar="DELETE FROM albaranesptmp WHERE datediff('$hoy',fecha) > 2";
$rs_borrar=mysqli_query($descriptor, $sel_borrar);

$sel_tmp="SELECT codfactura FROM facturastmp WHERE datediff('$hoy',fecha) > 2";
$rs_tmp=mysqli_query($descriptor, $sel_tmp);
$contador=0;
while ($contador < mysqli_num_rows($rs_tmp)) {
	$codfactura=mysqli_result($rs_tmp,$contador,"codfactura");
	$sel_borrar="DELETE FROM factulineatmp WHERE codfactura='$codfactura'";
	$rs_borrar=mysqli_query($descriptor, $sel_borrar);
	$contador++;
}

$sel_borrar="DELETE FROM facturastmp WHERE datediff('$hoy',fecha) > 2";
$rs_borrar=mysqli_query($descriptor, $sel_borrar);

$sel_tmp="SELECT codfactura FROM facturasptmp WHERE datediff('$hoy',fecha) > 2";
$rs_tmp=mysqli_query($descriptor, $sel_tmp);
$contador=0;
while ($contador < mysqli_num_rows($rs_tmp)) {
	$codfactura=mysqli_result($rs_tmp,$contador,"codfactura");
	$sel_borrar="DELETE FROM factulineaptmp WHERE codfactura='$codfactura'";
	$rs_borrar=mysqli_query($descriptor, $sel_borrar);
	$contador++;
}

$sel_borrar="DELETE FROM facturasptmp WHERE datediff('$hoy',fecha) > 2";
$rs_borrar=mysqli_query($descriptor, $sel_borrar);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">

.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.Estilo6 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif;}
</style>
</head>

<body>
<table width="90%" border="0" align="center">
  <tr height="90px">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr height="200px">
    <td>&nbsp;</td>
    <td><div align="center"><img src="img/central.jpg" width="550" height="200" border="0" /></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center" class="Estilo6">Jose Facturaci&oacute;n Web </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center" class="Estilo6">Versi&oacute;n 1.0 </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center" class="Estilo6">&copy; 2019</div></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><table width="50%" border="0" align="center">
        <tr>
          <td><div align="center"><span class="Estilo5">Resolución óptima 1024 x 768 píxeles  </span></div></td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="27">&nbsp;</td>
      <td><table width="50%" border="0" align="center">
        <tr>
          <td width="38%"><div align="right"><img src="img/firefox.gif" width="80" height="15" /></div></td>
          <td width="62%"><span class="Estilo5">Aplicación optimizada para Firefox </span></td>
        </tr>
      </table></td>
      <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>
