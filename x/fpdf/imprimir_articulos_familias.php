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
$pdf->MultiCell(290,6,"Listado de Articulos por Familia",0,C,0);

$pdf->Ln(8);    
	
//Restauracin de colores y fuentes

    $pdf->SetFillColor(224,235,255);
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial','B',7);


//Buscamos y listamos las familias

$consulta="select codfamilia,nombre from familias where borrado=0 order by nombre asc";
$query = mysqli_query($descriptor,$consulta);
$item=1;   
while ($row = mysql_fetch_array($query))
        {
		$sel_articulos="select * from articulos where borrado=0 and codfamilia=".$row["codfamilia"];
		$rs_articulos=mysqli_query($descriptor,$sel_articulos);
		$contador=0;
		$numero_articulos=mysqli_num_rows($rs_articulos);
				if ($numero_articulos>0) {		
					$pdf->SetFont('Arial','',8);
					$pdf->MultiCell(220,6,$row["nombre"],0,L,0);
					
					//Ttulos de las columnas
					$header=array('Item','Cod. Articulo','Referencia','Descripcion','P. Tienda','P. Compra','Stock');
					
					//Colores, ancho de lnea y fuente en negrita
					$pdf->SetFillColor(200,200,200);
					$pdf->SetTextColor(0);
					$pdf->SetDrawColor(0,0,0);
					$pdf->SetLineWidth(.2);
					$pdf->SetFont('Arial','B',8);
						
					//Cabecera
					$w=array(10,20,30,80,15,15,15);
					for($i=0;$i<count($header);$i++)
						$pdf->Cell($w[$i],7,$header[$i],1,0,'C',1);
					$pdf->Ln();
					$pdf->SetFont('Arial','',8);
					while ($contador < mysqli_num_rows($rs_articulos)) {
						$pdf->Cell($w[0],5,$item,'LRTB',0,'C');
						$pdf->Cell($w[1],5,mysqli_result($rs_articulos,$contador,"codarticulo"),'LRTB',0,'C');
						$pdf->Cell($w[2],5,mysqli_result($rs_articulos,$contador,"referencia"),'LRTB',0,'C');
						$pdf->Cell($w[3],5,mysqli_result($rs_articulos,$contador,"descripcion"),'LRTB',0,'L');
						$pdf->Cell($w[4],5,mysqli_result($rs_articulos,$contador,"precio_tienda"),'LRTB',0,'C');
						$pdf->Cell($w[5],5,mysqli_result($rs_articulos,$contador,"precio_compra"),'LRTB',0,'C');
						$pdf->Cell($w[6],5,mysqli_result($rs_articulos,$contador,"stock"),'LRTB',0,'C');
						
						$pdf->Ln();
						$item++;
						$contador++;
					}
				};
	$pdf->Ln();			  
};
			
$pdf->Output();
?> 
