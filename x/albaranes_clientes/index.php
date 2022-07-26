<?php
include ("../conectar.php");

@$cadena_busqueda=$_GET["cadena_busqueda"];

if (!isset($cadena_busqueda)) { $cadena_busqueda=""; } else { $cadena_busqueda=str_replace("",",",$cadena_busqueda); }

if ($cadena_busqueda<>"") {
	$array_cadena_busqueda=explode("~",$cadena_busqueda);
	$codcliente=$array_cadena_busqueda[1];
	$nombre=$array_cadena_busqueda[2];
	$numalbaran=$array_cadena_busqueda[3];
	$cboEstados=$array_cadena_busqueda[4];
	$fechainicio=$array_cadena_busqueda[5];
	$fechafin=$array_cadena_busqueda[6];
} else {
	$codcliente="";
	$nombre="";
	$numalbaran="";
	$cboEstados="";
	$s="";
	$fechafin="";
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    
    <script src="app.js"></script>
</head>

<body>
<div class="card" style="--i:url(img1.jpg)">
        <div class="content">
            <h2>Asistencia</h2>
            <a href="../albaranes_proveedores/index.php">Ver Detalles</a>
        </div>
    </div>

    <div class="card" style="--i:url(img2.jpg)">
        <div class="content">
            <h2>Herramientas</h2>
            <a href="../articulos/index.php">Ver Detalles</a>
        </div>
    </div>

    <div class="card" style="--i:url(img3.jpg)">
        <div class="content">
            <h2>Crear Formulario</h2>
            <a href="../generador-formularios-master">Ver Detalles</a>
        </div>
    </div>
</html>
