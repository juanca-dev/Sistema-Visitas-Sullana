<?php
/**
 * ticket.php — Pase de visita estilo ticket físico
 * Ubicación: raíz del proyecto
 */

session_start();
require_once "server/Visitas.php";

$token = trim($_GET['token'] ?? '');
if (empty($token)) { header('Location: index.php'); exit; }

$obj    = new Visitas();
$visita = $obj->buscarPorToken($token);

if (!$visita) {
    $_SESSION['mensaje'] = 'token_invalido';
    header('Location: index.php');
    exit;
}

// ── Datos ──
$nombre   = htmlspecialchars($visita['nombre'],  ENT_QUOTES, 'UTF-8');
$paterno  = htmlspecialchars($visita['paterno'], ENT_QUOTES, 'UTF-8');
$materno  = htmlspecialchars($visita['materno'], ENT_QUOTES, 'UTF-8');
$fullName = strtoupper("$nombre $paterno $materno");
$dni      = htmlspecialchars($visita['dni']    ?? '', ENT_QUOTES, 'UTF-8');
$motivo   = htmlspecialchars($visita['motivo'] ?? '', ENT_QUOTES, 'UTF-8');
$enPlanta = (int)($visita['en_planta'] ?? 1);

// Fecha y hora separadas
$fechaRaw = $visita['fecha'] ?? date('Y-m-d H:i:s');
$fechaFmt = date('d/m/Y',  strtotime($fechaRaw));
$horaFmt  = date('h:i A',  strtotime($fechaRaw));

// QR apunta a marcar_salida.php — accesible desde celular en la misma red WiFi
$base      = 'http://192.168.1.10/LibrodeVisitasDigital';
$urlSalida = $base . '/server/marcar_salida.php?token=' . urlencode($token);
$qrUrl     = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&color=1a56db&bgcolor=ffffff&data=' . urlencode($urlSalida);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pase de Visita</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #e8edf5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ── Ticket container ── */
        .ticket {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 12px 48px rgba(0,0,0,.14);
        }

        /* ── Header azul ── */
        .ticket-header {
            background: linear-gradient(160deg, #1a56db 0%, #1e40af 100%);
            padding: 1.6rem 1.5rem 1.4rem;
            text-align: center;
            position: relative;
        }

        .ticket-header-label {
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255,255,255,.65);
            margin-bottom: .55rem;
        }

        .ticket-header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-family: 'Sora', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: .8rem;
        }

        .ticket-header-title svg {
            width: 22px; height: 22px;
            stroke: #fff; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        /* Badge estado */
        .ticket-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 100px;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .ticket-status.active {
            background: #16a34a;
            color: #fff;
        }

        .ticket-status.inactive {
            background: rgba(255,255,255,.15);
            color: rgba(255,255,255,.7);
            border: 1px solid rgba(255,255,255,.2);
        }

        .ticket-status svg {
            width: 13px; height: 13px;
            stroke: currentColor; fill: none;
            stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round;
        }

        /* ── Dashed separator (corte de ticket) ── */
        .ticket-cut {
            position: relative;
            height: 0;
            border-top: 2px dashed #d1d5db;
            margin: 0;
        }

        .ticket-cut::before,
        .ticket-cut::after {
            content: '';
            position: absolute;
            top: 50%; transform: translateY(-50%);
            width: 22px; height: 22px;
            background: #e8edf5;
            border-radius: 50%;
        }

        .ticket-cut::before { left: -11px; }
        .ticket-cut::after  { right: -11px; }

        /* ── Nombre grande ── */
        .ticket-name {
            padding: 1.4rem 1.5rem .6rem;
            text-align: center;
        }

        .ticket-name h1 {
            font-family: 'Sora', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: #1a56db;
            letter-spacing: .02em;
            line-height: 1.2;
        }

        /* ── Datos en filas ── */
        .ticket-fields {
            padding: .4rem 1.5rem 1rem;
        }

        .ticket-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: .75rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .ticket-row:last-child { border-bottom: none; }

        .ticket-row-label {
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: #94a3b8;
        }

        .ticket-row-value {
            font-size: .9rem;
            font-weight: 600;
            color: #1e293b;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }

        /* ── QR section ── */
        .ticket-qr-section {
            margin: 0 1.5rem 1.4rem;
            border: 1.5px dashed #bfdbfe;
            border-radius: 14px;
            padding: 1.1rem;
            background: #f0f7ff;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .75rem;
        }

        .ticket-qr-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #60a5fa;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .ticket-qr-label svg {
            width: 13px; height: 13px;
            stroke: #60a5fa; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .ticket-qr-img {
            width: 180px; height: 180px;
            display: block;
            border-radius: 8px;
        }

        .ticket-qr-hint {
            font-size: .72rem;
            color: #94a3b8;
            text-align: center;
            line-height: 1.5;
        }

        /* ── Footer azul con botones ── */
        .ticket-footer {
            background: linear-gradient(160deg, #1a56db 0%, #1e40af 100%);
            padding: 1.1rem 1.5rem;
            display: flex;
            gap: .75rem;
        }

        .btn-ticket {
            flex: 1;
            height: 44px;
            border-radius: 100px;
            display: flex; align-items: center; justify-content: center;
            gap: 7px;
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: opacity .15s, transform .1s;
        }

        .btn-ticket:hover { opacity: .88; }
        .btn-ticket:active { transform: scale(.97); }

        .btn-ticket svg {
            width: 15px; height: 15px;
            stroke: currentColor; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }

        .btn-print {
            background: #fff;
            color: #1a56db;
        }

        .btn-home {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255,255,255,.4) !important;
        }

        /* ── Print styles ── */
        @media print {
            body { background: #fff; padding: 0; }
            .ticket { box-shadow: none; max-width: 100%; }
            .ticket-footer { display: none; }
        }
    </style>
</head>
<body>

<div class="ticket">

    <!-- ── Header ── -->
    <div class="ticket-header">
        <div class="ticket-header-label">Libro de Visitas Digital</div>
        <div class="ticket-header-title">
            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            Pase de Visita
        </div>
        <?php if ($enPlanta): ?>
            <div class="ticket-status active">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Ingreso Registrado
            </div>
        <?php else: ?>
            <div class="ticket-status inactive">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                Visita Finalizada
            </div>
        <?php endif; ?>
    </div>

    <!-- ── Dashed cut ── -->
    <div class="ticket-cut"></div>

    <!-- ── Nombre ── -->
    <div class="ticket-name">
        <h1><?php echo $fullName; ?></h1>
    </div>

    <!-- ── Campos ── -->
    <div class="ticket-fields">
        <div class="ticket-row">
            <span class="ticket-row-label">DNI</span>
            <span class="ticket-row-value"><?php echo $dni; ?></span>
        </div>
        <div class="ticket-row">
            <span class="ticket-row-label">Motivo</span>
            <span class="ticket-row-value"><?php echo $motivo; ?></span>
        </div>
        <div class="ticket-row">
            <span class="ticket-row-label">Fecha</span>
            <span class="ticket-row-value"><?php echo $fechaFmt; ?></span>
        </div>
        <div class="ticket-row">
            <span class="ticket-row-label">Hora de Ingreso</span>
            <span class="ticket-row-value"><?php echo $horaFmt; ?></span>
        </div>
    </div>

    <!-- ── QR Code ── -->
    <?php if ($enPlanta): ?>
    <div class="ticket-qr-section">
        <div class="ticket-qr-label">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="3" height="3"/></svg>
            Escanear para registrar salida
        </div>
        <img
            src="<?php echo htmlspecialchars($qrUrl, ENT_QUOTES, 'UTF-8'); ?>"
            alt="QR de salida"
            class="ticket-qr-img"
            loading="lazy"
        >
        <div class="ticket-qr-hint">Muestra este código en recepción al salir</div>
    </div>
    <?php endif; ?>

    <!-- ── Footer botones ── -->
    <div class="ticket-footer">
        <button class="btn-ticket btn-print" onclick="window.print()">
            <svg viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Imprimir
        </button>
        <a href="index.php" class="btn-ticket btn-home">
            <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            ← Inicio
        </a>
    </div>

</div><!-- /ticket -->

</body>
</html>