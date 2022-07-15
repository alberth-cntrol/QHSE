<?php
require('fpdf.php');

class PDF_MySQL_Table extends FPDF
{
var $ProcessingTable=false;
var $aCols=array();
var $TableX;
var $HeaderColor;
var $RowColors;
var $ColorIndex;

function Header()
{
	//Imprime l'en-t�te du tableau si n�cessaire
	if($this->ProcessingTable)
		$this->TableHeader();
}

function TableHeader()//parametre de l'entete du tableau
{
	$this->SetFont('Arial','B',10);
	$this->SetX($this->TableX);
	$fill=!empty($this->HeaderColor);
	if($fill)
		$this->SetFillColor($this->HeaderColor[0],$this->HeaderColor[1],$this->HeaderColor[2]);
	foreach($this->aCols as $col)
		$this->Cell($col['w'],6,$col['c'],1,0,'C',$fill);
	$this->Ln();
}

function Row($data)
{
	$this->SetX($this->TableX);
	$ci=$this->ColorIndex;
	$fill=!empty($this->RowColors[$ci]);
	if($fill)
		$this->SetFillColor($this->RowColors[$ci][0],$this->RowColors[$ci][1],$this->RowColors[$ci][2]);
	foreach($this->aCols as $col)
		$this->Cell($col['w'],5,$data[$col['f']],1,0,$col['a'],$fill);
	$this->Ln();
	$this->ColorIndex=1-$ci;
}

function CalcWidths($width,$align)
{
	//Calcule les largeurs des colonnes
	$TableWidth=0;
	foreach($this->aCols as $i=>$col)
	{
		$w=$col['w'];
		if($w==-1)
			$w=$width/count($this->aCols);
		elseif(substr($w,-1)=='%')
			$w=$w/100*$width;
		$this->aCols[$i]['w']=$w;
		$TableWidth+=$w;
	}
	//Calcule l'abscisse du tableau
	if($align=='C')
		$this->TableX=max(($this->w-$TableWidth)/2,0);
	elseif($align=='R')
		$this->TableX=max($this->w-$this->rMargin-$TableWidth,0);
	else
		$this->TableX=$this->lMargin;
}

function AddCol($field=-1,$width=-1,$caption='',$align='L')
{
	//Ajoute une colonne au tableau
	if($field==-1)
		$field=count($this->aCols);
	$this->aCols[]=array('f'=>$field,'c'=>$caption,'w'=>$width,'a'=>$align);
}

function Table($query,$prop=array())
{
	//Ex�cute la requ�te
	$res=mysqli_query($descriptor,$query) or die('Erreur: '.mysql_error()."<BR>Requ�te: $query");
	//Ajoute toutes les colonnes si aucune n'a �t� d�finie
	if(count($this->aCols)==0)
	{
		$nb=mysql_num_fields($res);
		for($i=0;$i<$nb;$i++)
			$this->AddCol();
	}
	//D�termine les noms des colonnes si non sp�cifi�s
	foreach($this->aCols as $i=>$col)
	{
		if($col['c']=='')
		{
			if(is_string($col['f']))
				$this->aCols[$i]['c']=ucfirst($col['f']);
			else
				$this->aCols[$i]['c']=ucfirst(mysql_field_name($res,$col['f']));
		}
	}
	//Traite les propri�t�s
	if(!isset($prop['width']))
		$prop['width']=0;
	if($prop['width']==0)
		$prop['width']=$this->w-$this->lMargin-$this->rMargin;
	if(!isset($prop['align']))
		$prop['align']='C';
	if(!isset($prop['padding']))
		$prop['padding']=$this->cMargin;
	$cMargin=$this->cMargin;
	$this->cMargin=$prop['padding'];
	if(!isset($prop['HeaderColor']))
		$prop['HeaderColor']=array();
	$this->HeaderColor=$prop['HeaderColor'];
	if(!isset($prop['color1']))
		$prop['color1']=array();
	if(!isset($prop['color2']))
		$prop['color2']=array();
	$this->RowColors=array($prop['color1'],$prop['color2']);
	//Calcule les largeurs des colonnes
	$this->CalcWidths($prop['width'],$prop['align']);
	//Imprime l'en-t�te
	$this->TableHeader();
	//Imprime les lignes
	$this->SetFont('Arial','',8);//police des lignes du tableau
	$this->ColorIndex=0;
	$this->ProcessingTable=true;
	while($row=mysql_fetch_array($res))
		$this->Row($row);
	$this->ProcessingTable=false;
	$this->cMargin=$cMargin;
	$this->aCols=array();
}
}
?>
