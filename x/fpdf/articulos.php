<?php


define('FPDF_FONTPATH','font/');
require('mysql_table.php');

include("comunes.php");

include ("../conectar.php");  

$pdf=new PDF();
$pdf->Open();
$pdf->AddPage();

//Nombre del Listado
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',16);
$pdf->SetY(40);
$pdf->SetX(0);
    
$pdf->MultiCell(290,6,"Listado de Articulos",0,C,0);

$pdf->Ln();    
	
//Restauracin de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);


$codarticulo=$_GET["codarticulo"];
$descripcion=$_GET["descripcion"];
$codfamilia=$_GET["cboFamilias"];
$referencia=$_GET["referencia"];
$codproveedor=$_GET["cboProveedores"];
$codubicacion=$_GET["cboUbicacion"];

$where="1=1";
if ($codarticulo <> "") { $where.=" AND codarticulo='$codarticulo'"; }
if ($descripcion <> "") { $where.=" AND descripcion like '%".$descripcion."%'"; }
if ($codfamilia > "0") { $where.=" AND codfamilia='$codfamilia'"; }
if ($codproveedor > "0") { $where.=" AND (codproveedor1='$codproveedor' OR codproveedor2='$codproveedor')"; }
if ($codubicacion > "0") { $where.=" AND codubicacion='$codubicacion'"; }
if ($referencia <> "") { $where.=" AND referencia like '%".$referencia."%'"; }


$header=array('Familia','Referencia','Descripcion','P. Tienda','Stock');

//Colores, ancho de lnea y fuente en negrita
$pdf->SetFillColor(200,200,200);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(.2);
$pdf->SetFont('Arial','B',8);
	
//Cabecera
$w=array(40,30,80,20,20);
for($i=0;$i<count($header);$i++)
	$pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
$pdf->Ln();
$pdf->SetFont('Arial','',8);
$sel_resultado="SELECT * FROM articulos LEFT JOIN familias ON articulos.codfamilia=familias.codfamilia WHERE articulos.borrado=0 AND ".$where;
$res_resultado=mysqli_query($descriptor,$sel_resultado);
$contador=0;
while ($contador < mysqli_num_rows($res_resultado)) {
	$pdf->Cell($w[0],5,mysqli_result($res_resultado,$contador,"familias.nombre"),'LRTB',0,'L');
	$pdf->Cell($w[1],5,mysqli_result($res_resultado,$contador,"referencia"),'LRTB',0,'C');
	$pdf->Cell($w[2],5,mysqli_result($res_resultado,$contador,"descripcion_corta"),'LRTB',0,'L');
	$pdf->Cell($w[3],5,mysqli_result($res_resultado,$contador,"precio_tienda"),'LRTB',0,'R');
	$pdf->Cell($w[4],5,mysqli_result($res_resultado,$contador,"stock"),'LRTB',0,'R');
	$pdf->Ln();
	$contador++;
};
			
$pdf->Output();
?> 
