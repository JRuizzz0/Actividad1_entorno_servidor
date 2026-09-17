<?php

   session_start();

   $usuarios_validos = ['admin' => '1234', 'Jaime' => '1111'];

   $mensaje_error = "";

   if($_SERVER['REQUEST_METHOD'] === 'POST'){

     if(isset($_POST['usuario'])){

        $usuario_escrito = $_POST['usuario'];
   }
   else{
        $usuario_escrito = "";
   }

   if(isset($_POST['password'])){

        $password_escrito = $_POST['password'];
   }
   else{
        $password_escrito = "";
   }


   if(isset($usuarios_validos[$usuario_escrito])&& $usuarios_validos[$usuario_escrito] === $password_escrito){
    
    $_SESSION['logueado'] =  true;

    header("Location: bienvenida.php");

    exit();


   }

    else{
        $mensaje_error = "No se ha podido loguear de forma correcta";
    }

   }



?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="styles2.css">
</head>
<body>

<header class="header">
    <h1 id="titulo">Login</h1>
</header>

<main class="main">

<form method="post" class="formulario">

    <input type="text" name="usuario" id="us" placeholder="Introduce tu nombre de usuario">
    <input type="text" name="password" id="password" placeholder="Introduce tu contraseña">

    <button type="submit">Entrar</button>

</form>

<?php if ($mensaje_error !== ""): ?>
    <p style="color: red; text-align: center;">
        <?php echo $mensaje_error; ?>
    </p>
<?php endif; ?>

</main>

</body>
</html>