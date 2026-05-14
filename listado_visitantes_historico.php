<?php
// Ya no es necesario instanciar aquí si se hace en historico.php, 
// pero mantenemos la lógica de obtención de datos.
$visitas = new Visitas();
$items = $visitas->mostrarTodos();
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.material.min.css">
<style>
    /* Personalización para que coincida con tu diseño de Sullana Motos */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
        padding: 5px !important;
        margin-bottom: 15px;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: bold;
    }
    .status-in { background-color: #e8f5e9; color: #2e7d32; }
    .status-out { background-color: #ffebee; color: #c62828; }
    
    table.dataTable thead th {
        background-color: #1976d2 !important; /* Azul profesional */
        color: white !important;
        border-bottom: none !important;
    }
    
</style>

<div class="card-panel z-depth-1" style="border-radius: 8px;">
    <table id="tablaHistorico" class="highlight responsive-table" style="width:100%">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Visitante</th>
                <th>Motivo de Visita</th>
                <th>Fecha y Hora</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($item['dni']); ?></strong></td>
                    <td>
                        <?php echo htmlspecialchars($item['paterno'] . " " . $item['materno'] . ", " . $item['nombre']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($item['motivo']); ?></td>
                    <td>
                        <span style="font-size: 0.9rem; color: #667;">
                            <i class="material-icons tiny">access_time</i> 
                            <?php echo date('d/m/Y H:i', strtotime($item['fecha'])); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($item['en_planta'] == 1): ?>
                            <span class="status-badge status-in">DENTRO</span>
                        <?php else: ?>
                            <span class="status-badge status-out">SALIÓ</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.material.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tablaHistorico').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "order": [[3, "desc"]], // Ordenar por fecha por defecto
            "pageLength": 10,
            "dom": '<"top"f>rt<"bottom"ip><"clear">', // Limpia la interfaz
        });
    });
</script>