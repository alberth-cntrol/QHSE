<?php
define('FPDF_FONTPATH','font/');
require('fpdf.php');
include("../conectar.php");
//require('code39.php');

$codalbaran=$_GET["codalbaran"];
$sel_lineas="SELECT sum(cantidad) as suma FROM albalinea WHERE codalbaran='$codalbaran'";
$rs_lineas=mysqli_query($descriptor,$sel_lineas);

$numetiquetas=mysqli_result($rs_lineas,0,"suma");

class PDF extends FPDF
{
function EAN13($x,$y,$barcode,$h=10,$w=.28)
{
	$this->Barcode($x,$y,$barcode,$h,$w,13);
}

function UPC_A($x,$y,$barcode,$h=8,$w=.25)
{
	$this->Barcode($x,$y,$barcode,$h,$w,12);
}

function GetCheckDigit($barcode)
{
	//Compute the check digit
	$sum=0;
	for($i=1;$i<=11;$i+=2)
		$sum+=3*$barcode{$i};
	for($i=0;$i<=10;$i+=2)
		$sum+=$barcode{$i};
	$r=$sum%10;
	if($r>0)
		$r=10-$r;
	return $r;
}

function TestCheckDigit($barcode)
{
	//Test validity of check digit
	$sum=0;
	for($i=1;$i<=11;$i+=2)
		$sum+=3*$barcode{$i};
	for($i=0;$i<=10;$i+=2)
		$sum+=$barcode{$i};
	return ($sum+$barcode{12})%10==0;
}

function Barcode($x,$y,$barcode,$h,$w,$len)
{
	//Padding
	$barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
	if($len==12)
		$barcode='0'.$barcode;
	//Add or control the check digit
	if(strlen($barcode)==13) {}
		//$barcode.=$this->GetCheckDigit($barcode);
	elseif(!$this->TestCheckDigit($barcode))
		$this->Error('Error codigo incorrecto');
	//Convert digits to bars
	$codes=array(
		'A'=>array(
			'0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
			'5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
		'B'=>array(
			'0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
			'5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
		'C'=>array(
			'0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
			'5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
		);

	$parities=array(
		'0'=>array('A','A','A','A','A','A'),
		'1'=>array('A','A','B','A','B','B'),
		'2'=>array('A','A','B','B','A','B'),
		'3'=>array('A','A','B','B','B','A'),
		'4'=>array('A','B','A','A','B','B'),
		'5'=>array('A','B','B','A','A','B'),
		'6'=>array('A','B','B','B','A','A'),
		'7'=>array('A','B','A','B','A','B'),
		'8'=>array('A','B','A','B','B','A'),
		'9'=>array('A','B','B','A','B','A')
		);
	$code='101';
	$p=$parities[$barcode{0}];
	for($i=1;$i<=6;$i++)
		$code.=$codes[$p[$i-1]][$barcode{$i}];
	$code.='01010';
	for($i=7;$i<=12;$i++)
		$code.=$codes['C'][$barcode{$i}];
	$code.='101';
	//Draw bars
	for($i=0;$i<strlen($code);$i++)
	{
		if($code{$i}=='1')
			$this->Rect($x+$i*$w,$y,$w,$h,'F');
	}
	//Print text uder barcode
	$this->SetFont('Arial','',5);
	$this->Text($x+7,$y+$h+6/$this->k,substr($barcode,-$len));
}
}

$pdf=new PDF(); 
define('EURO',chr(128));
$ancho=29;
//$largo=27 * $numetiquetas; 
//Este largo es el largo de cada pagina, ten en cuenta que cada etiqueta con espacios y demas
//son 27
$largo=540;
$pdf=new PDF (P,mm,array($ancho,$largo) );
$pdf->Open();
$pdf->AddPage();

$sel_lineas="SELECT * FROM albalinea INNER JOIN articulos ON albalinea.codigo=articulos.codarticulo WHERE codalbaran='$codalbaran'";
$rs_lineas=mysqli_query($descriptor,$sel_lineas);
$contador=0;
$desplazamiento=0;
$contador20=0;

while ($contador < mysqli_num_rows($rs_lineas)) {
	$descripcion=mysqli_result($rs_lineas,$contador,"descripcion_corta");
	$referencia=mysqli_result($rs_lineas,$contador,"referencia");
	$codigobarras=mysqli_result($rs_lineas,$contador,"codigobarras");
	$descripcion=substr($descripcion,0,31);
	$precio=mysqli_result($rs_lineas,$contador,"precio_tienda");
	$precio=number_format($precio,2,",",".");
	$cantidad=mysqli_result($rs_lineas,$contador,"cantidad");
	$contador2=0;
	while ($contador2 < $cantidad) {
		$contador20++;
		$pdf->SetFont('Arial','',5);
		$pdf->Text(2,3 + $desplazamiento,$descripcion);
		$pdf->EAN13(1,4 + $desplazamiento,$codigobarras);
		$pdf->SetFont('Arial','',7);
		$pdf->Text(1,19 + $desplazamiento,"Ref.: ".$referencia); 
		$pdf->SetFont('Arial','',9);    
		$pdf->Text(5,23 + $desplazamiento,"PVP: ".$precio." ".EURO);
		$desplazamiento=$desplazamiento + 27;
		$contador2++;
		
		//aqui se pregunta si han llegado a 20 etiquetas para hacer el salto de página
		//si quieres modificarlo ya sabes que tienes que cambiar también en alto arriba
		if ($contador20==20) {
			$desplazamiento=0;
			$pdf->AddPage();
			$contador20=0;
		}
	}
	$contador++;
}

/*
$pdf->SetFont('Arial','',5);
$pdf->Text(2,3,$descripcion);
$pdf->EAN13(1,4,$codigobarras);
$pdf->SetFont('Arial','',7);
$pdf->Text(1,19,"Ref.: ".$referencia); 
$pdf->SetFont('Arial','',9);    
$pdf->Text(5,23,"PVP: ".$precio." ".EURO);*/

//segundo
/*
$pdf->SetFont('Arial','',7);
$pdf->Text(2,30,$descripcion);
$pdf->EAN13(10,32,$codigobarras);
$pdf->SetFont('Arial','',5);
$pdf->Text(1,49,"Referencia: ".$referencia); 
$pdf->SetFont('Arial','',8);    
$pdf->Text(22,49,"PVP: ".$precio." Eur.");*/
$pdf->Output();
?>
