<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['usuario_id'])) {
        exit("Acceso denegado."); 
    }

    require_once "server/Visitas.php"; 
    $visitas = new Visitas();
    $items   = $visitas->mostrarDia();
?>
<style>
/*
 * Estilos de la tabla de visitantes.
 * No incluye <html>/<body> porque este archivo se embebe dentro de index.php.
 * Usa las mismas CSS variables de index.php para respetar el modo oscuro.
 */

.lv-visitors-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
    /* La tabla puede crecer; el scroll lo maneja .lv-table-wrap del padre */
    min-width: 560px;
}

.lv-visitors-table caption {
    font-weight: 700;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-sub);
    text-align: left;
    padding: 0 0 10px 0;
}

.lv-visitors-table thead tr {
    background: #1565c0;
}

.lv-visitors-table th {
    padding: 10px 12px;
    text-align: left;
    color: #ffffff;
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
}

/* Primera columna: DNI no rompe en varias líneas */
.lv-visitors-table td {
    padding: 10px 12px;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-main);
    vertical-align: middle;
    white-space: nowrap;
}

.lv-visitors-table tbody tr:last-child td {
    border-bottom: none;
}

/* Hover sobre filas */
.lv-visitors-table tbody tr:hover {
    background: var(--bg-topbar);
    transition: background 0.15s;
}

/* DNI en negrita */
.lv-visitors-table td.col-dni {
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* Hora pequeña */
.lv-visitors-table td.col-hora {
    font-variant-numeric: tabular-nums;
    font-size: 0.82rem;
    color: var(--text-sub);
}

/* Botón de salida */
.btn-salida {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    background: #ea580c;
    border-radius: 50%;
    color: white;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, transform 0.1s;
}

.btn-salida:hover  { background: #c2410c; }
.btn-salida:active { transform: scale(0.92); }

.btn-salida svg {
    width: 16px;
    height: 16px;
    stroke: white;
    fill: none;
    stroke-width: 2.2;
    flex-shrink: 0;
}

/* Fila vacía */
.lv-empty-row td {
    text-align: center;
    color: var(--text-sub);
    padding: 24px;
    font-size: 0.9rem;
}
</style>

<table class="lv-visitors-table">
    <caption>Visitantes en Planta (Hoy)</caption>
    <thead>
        <tr>
            <th>DNI</th>
            <th>Paterno</th>
            <th>Materno</th>
            <th>Nombre</th>
            <th>Motivo</th>
            <th>Ingreso</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($items)) : ?>
            <tr class="lv-empty-row">
                <td colspan="7">No hay visitantes dentro del edificio en este momento.</td>
            </tr>
        <?php else : ?>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <td class="col-dni"><?php echo htmlspecialchars($item['dni'],     ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['paterno'],  ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['materno'],  ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['nombre'],   ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars($item['motivo'],   ENT_QUOTES, 'UTF-8'); ?></td>
                    <td class="col-hora"><?php echo date("H:i", strtotime($item['fecha'])); ?></td>
                    <td>
                        <a href="server/marcar_salida.php?token=<?php echo urlencode($item['qr_token']); ?>"
                           class="btn-salida"
                           title="Marcar Salida">
                            <!-- ícono de salida inline (sin dependencia de Material Icons) -->
                            <svg viewBox="0 0 24 24">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                                <polyline points="10 17 15 12 10 7"/>
                                <line x1="15" y1="12" x2="3" y2="12"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>