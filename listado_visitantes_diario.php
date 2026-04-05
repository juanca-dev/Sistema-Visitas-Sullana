<?php

    // Si alguien intenta entrar directo a este archivo sin pasar por index.php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['usuario_id'])) {
        exit("Acceso denegado."); 
    }

    require_once "server/Visitas.php"; 
    $visitas = new Visitas();
    $items = $visitas->mostrarDia();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Visitantes</title>
    <style>
        /* Mantengo tus estilos y añado una mejora para el botón */
        .resaltado-movimiento {
            font-weight: bold;
            color:#2196f3
            font-size: 1.8em;
            text-align: center;
            margin-bottom: 20px;
        }

        table.striped {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table.striped th, table.striped td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table.striped th {
            background-color: #1565c0; /* Color blue de Materialize */
            color: white;
        }

        .btn-salida {
            background-color: #ff9800 !important; /* Naranja */
        }
    </style>
</head>
<body>
    <table class="striped centered responsive-table">
        <caption class="resaltado-movimiento">Visitantes en Planta (Hoy)</caption>
        <thead>
            <tr>
                <th>DNI</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombre</th>
                <th>Motivo</th>
                <th>Ingreso</th>
                <th>Acción</th> </tr>
        </thead>
        <tbody>
            <?php if (empty($items)) : ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay visitantes dentro del edificio en este momento.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><b><?php echo htmlspecialchars($item['dni'], ENT_QUOTES, 'UTF-8'); ?></b></td>
                        <td><?php echo htmlspecialchars($item['paterno'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['materno'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['motivo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo date("H:i A", strtotime($item['fecha'])); ?></td>
                        <td>
                            <a href="server/marcar_salida.php?token=<?php echo $item['qr_token']; ?>" 
                               class="btn-floating btn-small waves-effect waves-light orange tooltipped"
                               data-position="top" data-tooltip="Marcar Salida">
                               <i class="material-icons">exit_to_app</i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>