<?php

session_start();

if (!isset($_SESSION['lista_tareas'])) {
    $_SESSION['lista_tareas'] = []; 
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['accion']) && $_POST['accion'] === 'añadir'){

        $texto_tarea = trim($_POST['descripcion']);

        if($texto_tarea !==''){


            $nueva_tarea = [
                'id' => uniqid(),
                'descripcion' => $texto_tarea,
                'estado' => 'pendiente'
            ];

            $_SESSION['lista_tareas'][] = $nueva_tarea;
            header("Location: listaDeTareas.php");
            exit;

        }

    }
}

if(isset($_POST['accion']) && $_POST['accion'] === 'completar'){
    $id_buscado = $_POST['id_tarea'];

    foreach($_SESSION['lista_tareas'] as  $indice => $tarea){

        if( $id_buscado === $tarea['id']){
            $_SESSION['lista_tareas'][$indice]['estado'] = 'completada';
        break;   
        }

    }

    header("Location: listaDeTareas.php");
    exit;

}

if(isset($_POST['accion']) && $_POST['accion'] === 'eliminar'){
    $id_buscado = $_POST['id_tarea'];

    foreach($_SESSION['lista_tareas'] as  $indice => $tarea){

        if( $id_buscado === $tarea['id']){
            unset($_SESSION['lista_tareas'][$indice]);
           
            
        break;   
        }

    }

    header("Location: listaDeTareas.php");
    exit;

}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header class="header">
    <h1 id="titulo">Lista de Tareas</h1>
</header>

<main class="main">

<form method="post" class="formulario">

    <input type="text" name="descripcion" id="desc" placeholder="Introduce la tarea">

    <button type="submit" name="accion" value="añadir">Agregar Tarea</button>

</form>

<ul id="listaTareas" class="lista">
    <?php

    foreach($_SESSION['lista_tareas'] as $tarea):

    
    ?>
    <li id="tarea1" class="elemento">
        <span class="texto-tarea">
            <?php echo $tarea['descripcion']; ?> - <strong>(<?php echo $tarea['estado']; ?>)</strong>
        </span>

     
        <form method="post" style="display: inline-block;">
           <input type="hidden" name="id_tarea" value="<?php echo $tarea['id']; ?>">
           <button type="submit" name="accion" value="completar">✔ Marcar</button>
        </form>

    
        <form method="post" style="display: inline-block;">
            <input type="hidden" name="id_tarea" value="<?php echo $tarea['id']; ?>">
            <button type="submit" name="accion" value="eliminar">🗑 Eliminar</button>
        </form>
    </li>

    <?php endforeach; ?>

</ul>

</main>




    
</body>
</html>