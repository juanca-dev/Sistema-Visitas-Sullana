<?php
$visitas = new Visitas();
$items = $visitas->mostrarTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Visitantes Histórico</title>
    <style>
        .boton-buscar {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .boton-buscar:hover {
            background-color: #0056b3;
        }

        .boton-buscar:focus {
            outline: none;
        }

        .resaltado-movimiento {
            font-weight: bold;
            color: #ff6347;
            font-size: 1.5em;
            text-align: center;
            animation: moverTexto 2s linear infinite;
        }

        @keyframes moverTexto {
            0% { transform: translateX(0); }
            50% { transform: translateX(20px); }
            100% { transform: translateX(0); }
        }

        table.striped {
            width: 100%;
            border-collapse: collapse;
        }

        table.striped th, table.striped td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table.striped tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table.striped th {
            background-color: #007BFF;
            color: white;
        }

        #searchInput {
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <!-- Campo de búsqueda -->
    <input type="text" id="searchInput" placeholder="Buscar visitante..." />

    <!-- Botón para búsqueda -->
    <button class="boton-buscar" id="buscarBtn">Buscar</button>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('table.striped tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let rowContainsQuery = false;

                // Recorremos todas las celdas de la fila
                for (let i = 0; i < cells.length; i++) {
                    const cellText = cells[i].textContent || cells[i].innerText;
                    if (cellText.toLowerCase().includes(query)) {
                        rowContainsQuery = true;
                        break;
                    }
                }

                // Mostramos u ocultamos la fila según si contiene el texto de búsqueda
                row.style.display = rowContainsQuery ? '' : 'none';
            });
        });

        // Funcionalidad del botón de búsqueda (opcional, puedes quitarlo si lo prefieres)
        document.getElementById('buscarBtn').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('table.striped tbody tr');
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let rowContainsQuery = false;

                for (let i = 0; i < cells.length; i++) {
                    const cellText = cells[i].textContent || cells[i].innerText;
                    if (cellText.toLowerCase().includes(query)) {
                        rowContainsQuery = true;
                        break;
                    }
                }

                row.style.display = rowContainsQuery ? '' : 'none';
            });
        });
    </script>

    <!-- Tabla de visitantes -->
    <table class="striped">
        <caption class="resaltado-movimiento">Listado de visitantes Histórico</caption>
        <thead>
            <tr>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombre</th>
                <th>Motivo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($items)) : ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No hay visitantes registrados hoy</td>
                </tr>
            <?php else : ?>
                <?php foreach ($items as $item) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['paterno'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['materno'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['motivo'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($item['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
