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
$pdf->MultiCell(290,6,"Total Costo Almacen",0,C,0);

$pdf->Ln();    
	
//Restauracin de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);


//Buscamos y listamos las familias

//$sel_articulos="select articulos.*,familias.nombre from articulos,familias where articulos.codfamilia=familias.codfamilia and articulos.borrado=0 order by familias.codfamilia asc, articulos.codarticulo asc";

$sel_articulos="SELECT *
FROM articulos LEFT JOIN familias ON
articulos.codfamilia = familias.codfamilia WHERE articulos.borrado =0
ORDER  BY familias.codfamilia ASC , articulos.codarticulo ASC ";
$rs_articulos=mysqli_query($descriptor,$sel_articulos);

$contador=0;
$item=1;
$valortotal=0;
$numero_articulos=mysqli_num_rows($rs_articulos);
		if ($numero_articulos>0) {		
			$pdf->SetFont('Arial','',8);
			$pdf->MultiCell(220,6,$row["nombre"],0,L,0);
			
			//Ttulos de las columnas
			$header=array('Item','Familia','Referencia','Descripcion','P. Almacen','Stock','Total');
			
			//Colores, ancho de lnea y fuente en negrita
			$pdf->SetFillColor(200,200,200);
			$pdf->SetTextColor(0);
			$pdf->SetDrawColor(0,0,0);
			$pdf->SetLineWidth(.2);
			$pdf->SetFont('Arial','B',8);
				
			//Cabecera
			$w=array(10,40,30,65,15,15,20);
			for($i=0;$i<count($header);$i++)
				$pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
			$pdf->Ln();
			$pdf->SetFont('Arial','',8);
			while ($contador < mysqli_num_rows($rs_articulos)) {
				$pdf->Cell($w[0],5,$item,'LRTB',0,'C');
				$pdf->Cell($w[1],5,mysqli_result($rs_articulos,$contador,"nombre"),'LRTB',0,'C');
				$pdf->Cell($w[2],5,mysqli_result($rs_articulos,$contador,"referencia"),'LRTB',0,'C');
				$pdf->Cell($w[3],5,mysqli_result($rs_articulos,$contador,"descripcion"),'LRTB',0,'L');
				$pdf->Cell($w[4],5,mysqli_result($rs_articulos,$contador,"precio_almacen"),'LRTB',0,'C');
				$pdf->Cell($w[5],5,mysqli_result($rs_articulos,$contador,"stock"),'LRTB',0,'C');
				$total=mysqli_result($rs_articulos,$contador,"precio_almacen") * mysqli_result($rs_articulos,$contador,"stock");
				$pdf->Cell($w[6],5,number_format($total,2,",","."),'LRTB',0,'C');
				$valortotal=$valortotal+$total;
				$pdf->Ln();
				$item++;
				$contador++;
			}
		};

	$pdf->Ln(4);
 	$pdf->Cell(160);
	$pdf->Cell(30,4,"Total Almacen",1,0,'C',1);
	$pdf->Ln(4);
	
    $pdf->SetFillColor(255,255,255);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(0,0,0);
    $pdf->SetLineWidth(.2);
    $pdf->SetFont('Arial','',8);
	
	$pdf->Cell(160);
    $valortotal=number_format($valortotal,2,",",".");	
    $pdf->Cell(30,4,$valortotal." Euros",1,0,'R',1);
	$pdf->Ln(4);
			
$pdf->Output();
?> 
