<?php

session_start();

if(!isset($_SESSION['logueado'])){

header("Location:login.php");

exit();


}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>

</head>
<body>
    
<h1>Bienvenido a la zona VIP</h1>

    
</body>
</html>