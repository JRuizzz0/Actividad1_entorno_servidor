<?php
session_start();

require_once 'conexión.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'añadir') {
        $texto_tarea = trim($_POST['descripcion'] ?? '');

        if ($texto_tarea !== '') {
            $sql = "INSERT INTO Tareas (descripcion, estado) VALUES (:descripcion, 'pendiente')";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':descripcion', $texto_tarea);
            $stmt->execute();

            header("Location: tareas_db.php");
            exit;
        }
    }

    if ($accion === 'completar') {
        $id_buscado = $_POST['id_tarea'] ?? '';

        if (!empty($id_buscado)) {
            $sql = "UPDATE Tareas SET estado = 'completada' WHERE id_tarea = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id_buscado);
            $stmt->execute();
        }

        header("Location: tareas_db.php");
        exit;
    }

    if ($accion === 'eliminar') {
        $id_buscado = $_POST['id_tarea'] ?? '';

        if (!empty($id_buscado)) {
            $sql = "DELETE FROM Tareas WHERE id_tarea = :id";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id_buscado);
            $stmt->execute();
        }

        header("Location: tareas_db.php");
        exit;
    }
}

$sql_leer = "SELECT * FROM Tareas ORDER BY id_tarea ASC";
$stmt_leer = $conexion->query($sql_leer);
$lista_tareas = $stmt_leer->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas - Base de Datos</title>
    <link rel="stylesheet" href="styles4.css?v=1">
</head>
<body>

<main class="contenedor">
    <header class="header">
        <h1>Lista de Tareas</h1>
    </header>

    <form method="post" class="formulario">
        <input type="text" name="descripcion" placeholder="Introduce la tarea..." required>
        <button type="submit" name="accion" value="añadir" class="btn btn-primario">Agregar Tarea</button>
    </form>

    <ul class="lista-tareas">
        <?php if (empty($lista_tareas)): ?>
            <li class="tarea-vacia">No hay tareas registradas en la base de datos.</li>
        <?php else: ?>
            <?php foreach ($lista_tareas as $tarea): ?>
                <li class="tarea-item <?php echo $tarea['estado'] === 'completada' ? 'completada' : ''; ?>">
                    <div class="tarea-info">
                        <span class="tarea-desc"><?php echo htmlspecialchars($tarea['descripcion']); ?></span>
                        <span class="tarea-badge"><?php echo htmlspecialchars($tarea['estado']); ?></span>
                    </div>

                    <div class="tarea-acciones">
                        <?php if ($tarea['estado'] !== 'completada'): ?>
                            <form method="post" class="form-accion">
                                <input type="hidden" name="id_tarea" value="<?php echo htmlspecialchars($tarea['id_tarea']); ?>">
                                <button type="submit" name="accion" value="completar" class="btn btn-completar" title="Marcar como completada">✔</button>
                            </form>
                        <?php endif; ?>

                        <form method="post" class="form-accion">
                            <input type="hidden" name="id_tarea" value="<?php echo htmlspecialchars($tarea['id_tarea']); ?>">
                            <button type="submit" name="accion" value="eliminar" class="btn btn-eliminar" title="Eliminar tarea">🗑</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</main>

</body>
</html>