<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

</head>

<body>
    <form action="validar.php" method="POST" class="form-box animated fadeInUp">
        <h1 class="form-title">SignIn</h1>
        <input type="text" placeholder="Username" autofocus name="usuario">
        <input type="password" placeholder="Password" name="password">


        <button  type="submit">
            Login
        </button>
    </form>
</body>

</html>