<?php 

ob_start();
require_once('./classes/DBConnection.php');
$db = new DBConnection();

$code = isset($_GET['code']) ? $_GET['code'] : "";
if(empty($code)){
    echo "<script> alert('form code is not provided'); location.replace('./')</script>";
    exit;
}
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
    <title>Simple Form Builder</title>
    <?php include('./header.php') ?>
    <script>
        var form_code = "<?php echo $code ?>";
    </script>
    <script src="./js/form-build-display.js"></script>
</head>

<body class='bg-dark'>
    <div class="container pt-4">
        <?php 
        include './forms/'.$code.'.html';
        ?>
        <div class="w-100 d-flex justify-content-center">
            <button class="btn btn-primary" form="form-data" id="">Enviar</button>
        </div>
    </div>
</body>

</html>