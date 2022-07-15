<html>
<head>
<title>Galopin v1.0</title>
<link href="../estilo.css" rel="stylesheet" type="text/css">
<script>
var miPopup
function abreVentana(){
	miPopup = window.open("../listado_articulos.php","miwin","width=600,height=400,scrollbars=yes")
	miPopup.focus()
	}
</script>
<style type="text/css">

.Estilo2 {color: #FF0000}

</style>
</head>

<body>
<img src="../images/nuevas/impresionarticulos.jpg" alt="Impresi&oacute;n de Art&iacute;culos"><br>
<br>


  <?
   include ("../conectar.php");
  ?>
<blockquote><font size="2">Buscador de Artculos:</font></blockquote>

<table width="80%" border="0" align="center" bordercolor="#0066FF" cellspacing="0" cellpadding="0">
   <tr>
    <td width="51%" bgcolor="#0066FF" align="left">
    <form action="imprimir_lista_articulos.php" name="formul" target="_blank">
	  <input type="hidden" name="ini" value="true">
	 <br> 
	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0066FF">
     <tr>
	   <td colspan="4" class="primeralinea">
	     Bsquedas por cdigo, articulo y proveedor</td>
	  </tr>
	  <tr>
	   <td class="primeralineaizquierda">
	     Cdigo <font color="ff0000" size="1">(6dig)</font>:
	   </td>
	   <td colspan="3">
	     <input type="text" name="codigo" size="6" maxlength="6">
		 <a href="#"><img src="../images/lupa.jpg" alt="Buscar Artculo" width="17" height="17" border="0" onClick="abreVentana()"></a></td>
	   </td>
	  </tr>
	  	  <tr>
	   <td class="primeralineaizquierda">
	     Cdigo Inicio <font color="ff0000" size="1">(6dig)</font>:
	   </td>
	   <td width="8%">
	     <input type="text" name="codini" size="6" maxlength="6">
	   </td>
	   
	   <td width="18%" class="primeralineaizquierda">Cdigo Fin <font color="ff0000" size="1">(6dig)</font>:</td>
	   <td width="54%"><input type="text" name="codfin" size="6" maxlength="6"></td>
	  	  </tr>
	  <tr> 
	    <td width="20%" class="primeralineaizquierda">
		  Artculo:
		</td>
		<td colspan="3">
		 <input name="articulo" type="text" size="35">
		</td>
	  </tr>
	  <tr>
	    <td width="20%" class="primeralineaizquierda">
		   <?
	        //buscamos los proveedores
	        $consulta="select * from proveedores order by nombre";
	        $query = mysqli_query($descriptor,$consulta);
	       ?>
		   Proveedor:
		</td>
		<td colspan="3">
		<select name="proveedor" >
	     <option value=""></option>
	     <?
		   while ($row=mysqli_fetch_row($query))
		      {
		 ?>
		        <option value="<?=$row[0]?>"><?=$row[1]?></option>
		 <?
			  }
	     ?>
	   </select>
		</td>
	  </tr>
	</table> 
       <br>
	   <center>
	   <input type="submit" value="Buscar Artculos">
	   </center>
	</form>	 
</table>

</body>
</html>

