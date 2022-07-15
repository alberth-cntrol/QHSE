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
$pdf->SetY(20);
$pdf->SetX(0);
$pdf->MultiCell(290,6,"Lista de Articulos Tienda",0,C,0);

$pdf->Ln();    
	
//Restauracin de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);


//Buscamos y listamos las familias

$sel_articulos="select articulos.*,familias.nombre from articulos,familias where articulos.codfamilia=familias.codfamilia and articulos.borrado=0 order by familias.codfamilia asc, articulos.codarticulo asc";
$rs_articulos=mysqli_query($descriptor,$sel_articulos);
$contador=0;
$item=1;
$valortotal=0;
$numero_articulos=mysqli_num_rows($rs_articulos);
		if ($numero_articulos>0) {		
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(220,6,$row["nombre"],0,L,0);
			
			//Ttulos de las columnas
			$header=array('Item','Familia','Referencia','Descripcion','P. Tienda');
			
			//Colores, ancho de lnea y fuente en negrita
			$pdf->SetFillColor(200,200,200);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetLineWidth(.2);
			$pdf->SetFont('Arial','B',8);
				
			//Cabecera
			$w=array(10,40,30,85,20);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			while ($contador < mysqli_num_rows($rs_articulos)) {
				$pdf->Cell($w[0],5,$item,'LRTB',0,'C');
				$pdf->Cell($w[1],5,mysqli_result($rs_articulos,$contador,"nombre"),'LRTB',0,'C');
				$pdf->Cell($w[2],5,mysqli_result($rs_articulos,$contador,"referencia"),'LRTB',0,'C');
				$pdf->Cell($w[3],5,mysqli_result($rs_articulos,$contador,"descripcion"),'LRTB',0,'L');
				$pdf->Cell($w[4],5,number_format(mysqli_result($rs_articulos,$contador,"precio_tienda"),2,",","."),'LRTB',0,'C');
				$pdf->Ln();
				$item++;
				$contador++;
			}
		};
			
$pdf->Output();
?> 
