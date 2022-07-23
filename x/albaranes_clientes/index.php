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
    <script src="app.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3>Registro de capacitacion</h3>
                <hr>
                <form id="form">
                    <div class="mb-3">
                        <label for="curso" class="form-label">Cursos</label>
                        <select class="form-select" id="curso">
                            <option value="">Seleccione un curso</option>
                            <option value="Desarrollo de aplicaciones web">Trabajo en altura</option>
                            <option value="Desarrollo de aplicaciones moviles">Desarrollo de aplicaciones moviles</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="capa" class="form-label">Nombre de la Capacitacion</label>
                        <input type="text" class="form-control" id="capa">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellido">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electronico</label>
                        <input type="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="capa" class="form-label">Nombre de la Capacitacion</label>
                        <input type="text" class="form-control" id="capa">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="horas" class="form-label">N° de horas</label>
                            <input type="time" class="form-control" id="horas">
                        </div>
                        <div class="col-md-6">
                            <label for="nhoras" class="form-label">Hora de inicio</label>
                            <input type="time" class="form-control" id="nhoras">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni">
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono">
                        </div>
                    </div>

                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="empre" class="form-label">Empreza</label>
                            <input type="text" class="form-control" id="empre">
                        </div>
                        <div class="col-md-6">
                            <label for="ptra" class="form-label">Puesto de Trabajo</label>
                            <input type="text" class="form-control" id="ptra">
                        </div>
                    </div>

                    <span class="d-block pb-2">Firma digital aqui</span>
                    <div class="signature mb-2" style="width: 100%; height: 200px;">
                        <canvas id="signature-canvas"
                            style="border: 1px dashed red; width: 100%; height: 200px;"></canvas>
                    </div>

					<from name="form" action="" method="post" enctype="multiparth/from-data">
						<strong>Hulla digital</strong>
						<input typr="text" name="huelladiital" autocomplete="off" require value="">
						<strong>Seleccionar imagen</strong>
						<input type="file" name="imagen" id="imagen">
                    </from>   
						 
					

                    <button type="submit" class="btn btn-primary mb-4">Generar PDF</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
