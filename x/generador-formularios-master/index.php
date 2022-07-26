<?php 

ob_start();
require_once('./classes/DBConnection.php');
$db = new DBConnection();

$page = isset($_GET['p']) ? $_GET['p'] : "forms";
ob_end_flush();

?>
<!DOCTYPE html>
<html lang="en">
<style>
    /* canvas {
        height: 250px !important
    } */
    
    table th,
    table td {
        padding: 3px !important
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sencillo Constructor de Formularios</title>
    <?php include('./header.php') ?>
</head>

<body class=''>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100 border-bottom border-light mb-2" id="top-nav">
        <a class="navbar-brand" href="./">Crear Formulario</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav-menu" aria-controls="nav-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

        <div class="collapse navbar-collapse" id="nav-menu">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item nav-forms">
                    <a class="nav-link" href="./index.php?p=forms"><i class="fa fa-th-list"></i> Formularios</a>
                </li>
                <li class="nav-item nav-manage_forms">
                    <a class="nav-link" href="./index.php?p=manage_forms"><i class="fa fa-plus"></i> Crear Nuevo</a>
                </li>
                
        </div>
    </nav>
    <div class="container-fluid">
        <?php include("./".$page.".php") ?>
    </div>
</body>
<script>
    $(function(){
        var page = "<?php echo $page ?>";

        $('#nav-menu').find(".nav-item.nav-"+page).addClass("active")
    })
</script>
</html>