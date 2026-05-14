<?php 
    include "server/auth.php"; 
    include "header.php";
    include "server/Visitas.php";
    $obj = new Visitas();
    $items = $obj->mostrarTodos();
    $totalRegistros = count($items);
    $enPlanta = count(array_filter($items, fn($i) => $i['en_planta'] == 1));
    $salieron  = $totalRegistros - $enPlanta;
?>

<style>
    .hist-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin: 32px 0 20px;
    }
    .hist-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 1.6rem;
        font-weight: 500;
        color: #1565c0;
    }
    .hist-title i {
        font-size: 2rem;
    }
    .hist-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 20px;
        border-radius: 6px;
        font-size: 0.88rem;
        font-weight: 600;
        letter-spacing: 0.4px;
        text-decoration: none;
        transition: opacity 0.2s, box-shadow 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }
    .btn-export:hover { opacity: 0.88; box-shadow: 0 3px 8px rgba(0,0,0,0.18); }
    .btn-excel { background: #2e7d32; color: #fff; }
    .btn-pdf   { background: #c62828; color: #fff; }

    .stats-row {
        display: flex;
        gap: 14px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }
    .stat-card {
        flex: 1;
        min-width: 140px;
        border-radius: 10px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }
    .stat-card.total  { background: #e8f4fd; border: 1px solid #b3d7f5; }
    .stat-card.inside { background: #e8f5e9; border: 1px solid #a5d6a7; }
    .stat-card.out    { background: #fce4ec; border: 1px solid #f48fb1; }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
    }
    .stat-icon.total  { background: #bbdefb; color: #0d47a1; }
    .stat-icon.inside { background: #c8e6c9; color: #1b5e20; }
    .stat-icon.out    { background: #f8bbd0; color: #880e4f; }
    .stat-label { font-size: 0.78rem; color: #78909c; margin: 0 0 2px; }
    .stat-value { font-size: 1.45rem; font-weight: 600; color: #263238; margin: 0; line-height: 1; }

    .hist-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        border: 1px solid #e3e8f0;
        margin-bottom: 32px;
    }
</style>

<div class="container">
    <?php include "menu.php"; ?>

    <div class="hist-header">
        <h4 class="hist-title">
            <i class="material-icons">history</i> Historial General
        </h4>
        <div class="hist-actions">
            <a href="reporte_excel.php" class="btn-export btn-excel">
                <i class="material-icons" style="font-size:18px;">description</i> Excel
            </a>
            <a href="reporte_pdf.php" class="btn-export btn-pdf">
                <i class="material-icons" style="font-size:18px;">picture_as_pdf</i> PDF
            </a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card total">
            <div class="stat-icon total"><i class="material-icons">people</i></div>
            <div>
                <p class="stat-label" style="color:#1565c0;">Total registros</p>
                <p class="stat-value" style="color:#0d47a1;"><?php echo $totalRegistros; ?></p>
            </div>
        </div>
        <div class="stat-card inside">
            <div class="stat-icon inside"><i class="material-icons">domain</i></div>
            <div>
                <p class="stat-label" style="color:#2e7d32;">En planta</p>
                <p class="stat-value" style="color:#1b5e20;"><?php echo $enPlanta; ?></p>
            </div>
        </div>
        <div class="stat-card out">
            <div class="stat-icon out"><i class="material-icons">exit_to_app</i></div>
            <div>
                <p class="stat-label" style="color:#ad1457;">Salieron</p>
                <p class="stat-value" style="color:#880e4f;"><?php echo $salieron; ?></p>
            </div>
        </div>
    </div>

    <div class="hist-card">
        <?php include "listado_visitantes_historico.php"; ?>
    </div>
</div>

<?php include "footer.php"; ?>