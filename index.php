<?php 
    require_once "server/auth.php"; 
    include "header.php";
    include "menu.php";
    include "server/Visitas.php";
    
    $consulta = new Visitas();
    $totalHoy = $consulta->contarTotalHoy();
    $enPlanta = $consulta->contarEnPlanta();
    $egresos  = $consulta->contarEgresosHoy();
?>

<style>
/* ── Variables de Color (Modo Claro) ── */
:root {
    --bg-body: #f8fafc;
    --bg-card: #ffffff;
    --bg-topbar: #f1f5f9;
    --text-main: #0f172a;
    --text-sub: #64748b;
    --border-color: #e2e8f0;
    --input-bg: #f8fafc;
    --card-shadow: rgba(0, 0, 0, 0.06);
}

/* ── Variables Modo Oscuro ── */
.dark-mode {
    --bg-body: #0f172a;
    --bg-card: #1e293b;
    --bg-topbar: #1e293b;
    --text-main: #f1f5f9;
    --text-sub: #94a3b8;
    --border-color: #334155;
    --input-bg: #0f172a;
    --card-shadow: rgba(0, 0, 0, 0.3);
}

*, *::before, *::after { box-sizing: border-box; }

body { 
    background-color: var(--bg-body); 
    transition: background-color 0.3s ease;
    margin: 0;
    font-family: 'DM Sans', sans-serif;
    /* Evita scroll horizontal global */
    overflow-x: hidden;
}

/* ── Página: padding adaptable ── */
.lv-page {
    width: 100%;
    max-width: 100%;
    padding: 1rem;
}

/* ── Top bar ── */
.lv-top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bg-topbar);
    padding: 10px 16px;
    margin-bottom: 1rem;
    border-radius: 12px;
    border: 1px solid var(--border-color);
    color: var(--text-main);
    transition: all 0.3s ease;
    /* Nunca desborda */
    min-width: 0;
    gap: 8px;
}

.lv-clock {
    font-family: 'Sora', sans-serif;
    font-size: clamp(1.2rem, 5vw, 1.8rem); /* Escala con la pantalla */
    font-weight: 700;
    letter-spacing: 2px;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
}

.lv-clock svg { width: 22px; height: 22px; stroke: #2563eb; flex-shrink: 0; }

.dark-mode-toggle {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    color: var(--text-main);
    padding: 7px 11px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: 0.3s;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── Page header ── */
.lv-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 1.25rem;
}

.lv-page-header h1 {
    color: var(--text-main);
    font-family: 'Sora', sans-serif;
    font-size: clamp(1.2rem, 4vw, 1.5rem);
    font-weight: 700;
    margin: 0 0 4px 0;
}

.lv-date-badge {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    padding: 7px 13px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 7px;
    color: var(--text-sub);
    font-size: 0.9rem;
    white-space: nowrap;
}

/* ── Stats grid: 3 col desktop, 1 fila mobile (scroll horizontal suave) ── */
.lv-stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

/* En pantallas pequeñas: scroll horizontal natural, sin desborde feo */
@media (max-width: 600px) {
    .lv-stats-grid {
        /* Mantiene las 3 tarjetas visibles con un mínimo razonable */
        grid-template-columns: repeat(3, minmax(130px, 1fr));
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        /* Scroll snap para deslizar tarjeta a tarjeta */
        scroll-snap-type: x mandatory;
        gap: 0.75rem;
        padding-bottom: 4px; /* espacio para scrollbar */
    }
    .lv-stat-card {
        scroll-snap-align: start;
        min-width: 130px;
    }
}

.lv-stat-card {
    border-radius: 16px;
    padding: 1.2rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}

.lv-stat-icon {
    flex-shrink: 0;
    padding: 10px;
    border-radius: 10px;
}

.lv-stat-number {
    font-size: clamp(1.5rem, 5vw, 2rem);
    font-weight: 700;
    display: block;
    line-height: 1;
}

.lv-stat-label {
    font-size: 0.72rem;
    opacity: 0.85;
    display: block;
    margin-top: 4px;
}

/* ── Main grid: formulario + tabla ── */
.lv-main-grid {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 1.5rem;
    align-items: start;
}

@media (max-width: 900px) {
    .lv-main-grid {
        grid-template-columns: 1fr; /* Apila en móvil */
    }
}

/* ── Tarjetas ── */
.lv-card {
    background: var(--bg-card);
    border-radius: 16px;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 6px var(--card-shadow);
    color: var(--text-main);
    transition: all 0.3s ease;
    /* Evita que la tabla interna desborde la tarjeta */
    min-width: 0;
    overflow: hidden;
}

.lv-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.lv-card-header p {
    font-weight: 700;
    margin: 0;
    font-size: 0.95rem;
}

.lv-card-body {
    padding: 1.25rem 1.5rem;
}

/* ── Formulario ── */
.lv-field {
    margin-bottom: 12px;
}

.lv-field label {
    display: block;
    margin-bottom: 5px;
    color: var(--text-sub);
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

/* 
 * Usamos máxima especificidad para sobrescribir Materialize/Bootstrap.
 * !important solo en las propiedades que el framework resetea.
 */
.lv-card .lv-card-body input.lv-inp,
.lv-card .lv-card-body input[type="text"].lv-inp {
    display: block !important;
    width: 100% !important;
    height: 44px !important;
    min-height: 44px !important;
    padding: 0 12px !important;
    margin: 0 0 0 0 !important;
    background: var(--input-bg) !important;
    border: 1.5px solid var(--border-color) !important;
    border-bottom: 1.5px solid var(--border-color) !important; /* Materialize solo pone border-bottom */
    border-radius: 8px !important;
    color: var(--text-main) !important;
    font-size: 0.95rem !important;
    font-family: 'DM Sans', sans-serif !important;
    box-shadow: none !important;       /* Materialize añade box-shadow en focus */
    outline: none !important;
    transition: border-color 0.2s, box-shadow 0.2s;
    box-sizing: border-box !important;
    line-height: normal !important;
    appearance: none !important;
    -webkit-appearance: none !important;
}

.lv-card .lv-card-body input.lv-inp:focus,
.lv-card .lv-card-body input[type="text"].lv-inp:focus {
    border: 1.5px solid #2563eb !important;
    border-bottom: 1.5px solid #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.15) !important;
    background: var(--bg-card) !important;
}

.lv-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.lv-submit-btn {
    width: 100%;
    height: 46px;
    background: #2563eb;
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 14px;
    transition: background 0.2s, transform 0.1s;
}

.lv-submit-btn:hover { background: #1d4ed8; }
.lv-submit-btn:active { transform: scale(0.98); }

/* ── Tabla wrapper con scroll interno ── */
.lv-table-wrap {
    padding: 1rem;
    /* Scroll horizontal SOLO en la tabla, la tarjeta no desborda */
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
</style>

<main id="main-wrapper">
<div class="lv-page">

    <!-- Top bar -->
    <div class="lv-top-bar">
        <div class="lv-clock">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            <span id="time-string">00:00:00</span>
        </div>
        <button class="dark-mode-toggle" onclick="toggleDarkMode()">
            <svg id="moon-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
            <span id="toggle-text">Modo Oscuro</span>
        </button>
    </div>

    <!-- Page header -->
    <div class="lv-page-header">
        <div>
            <h1>Panel de Control</h1>
            <p style="color: var(--text-sub); margin: 0; font-size: 0.9rem;">
                Registra y monitorea el acceso de visitantes en tiempo real
            </p>
        </div>
        <div class="lv-date-badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <?php echo date('d/m/Y'); ?>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="lv-stats-grid">
        <div class="lv-stat-card" style="background: linear-gradient(135deg, #1d4ed8, #2563eb); color: white;">
            <div class="lv-stat-icon" style="background: rgba(255,255,255,0.2);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
            </div>
            <div style="text-align: right;">
                <span class="lv-stat-number"><?php echo $totalHoy; ?></span>
                <span class="lv-stat-label">TOTAL HOY</span>
            </div>
        </div>

        <div class="lv-stat-card" style="background: linear-gradient(135deg, #c2410c, #ea580c); color: white;">
            <div class="lv-stat-icon" style="background: rgba(255,255,255,0.2);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div style="text-align: right;">
                <span class="lv-stat-number"><?php echo $enPlanta; ?></span>
                <span class="lv-stat-label">EN PLANTA</span>
            </div>
        </div>

        <div class="lv-stat-card" style="background: #1e293b; color: white; border: 1px solid rgba(255,255,255,0.1);">
            <div class="lv-stat-icon" style="background: rgba(255,255,255,0.1);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                </svg>
            </div>
            <div style="text-align: right;">
                <span class="lv-stat-number"><?php echo $egresos; ?></span>
                <span class="lv-stat-label">EGRESOS</span>
            </div>
        </div>
    </div>

    <!-- Main grid -->
    <div class="lv-main-grid">

        <!-- Formulario -->
        <div class="lv-card">
            <div class="lv-card-header">
                <p>Registro de Visitante</p>
            </div>
            <div class="lv-card-body">
                <form action="server/agregar.php" method="post">
                    <div class="lv-field">
                        <label>DNI</label>
                        <input type="text" name="dni" id="dni" class="lv-inp" required maxlength="8" placeholder="12345678" inputmode="numeric">
                    </div>
                    <div class="lv-field">
                        <label>Nombres</label>
                        <input type="text" name="nombre" id="nombre" class="lv-inp" required>
                    </div>
                    <div class="lv-row-2">
                        <div class="lv-field">
                            <label>Ap. Paterno</label>
                            <input type="text" name="paterno" id="paterno" class="lv-inp" required>
                        </div>
                        <div class="lv-field">
                            <label>Ap. Materno</label>
                            <input type="text" name="materno" id="materno" class="lv-inp" required>
                        </div>
                    </div>
                    <div class="lv-field">
                        <label>Motivo</label>
                        <input type="text" name="motivo" id="motivo" class="lv-inp" required>
                    </div>
                    <button type="submit" class="lv-submit-btn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M12 5v14M5 12l7 7 7-7"/>
                        </svg>
                        Capturar e Ingresar
                    </button>
                </form>
            </div>
        </div>

        <!-- Tabla visitantes -->
        <div class="lv-card">
            <div class="lv-card-header">
                <p>Visitantes de Hoy</p>
            </div>
            <div class="lv-table-wrap">
                <?php include "listado_visitantes_diario.php"; ?>
            </div>
        </div>

    </div>
</div>
</main>

<script>
// Toggle Modo Oscuro
function toggleDarkMode() {
    const body = document.body;
    const btnText = document.getElementById('toggle-text');
    body.classList.toggle('dark-mode');
    if (body.classList.contains('dark-mode')) {
        btnText.innerText = "Modo Claro";
        localStorage.setItem('theme', 'dark');
    } else {
        btnText.innerText = "Modo Oscuro";
        localStorage.setItem('theme', 'light');
    }
}

// Cargar preferencia guardada
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-mode');
    document.getElementById('toggle-text').innerText = "Modo Claro";
}

// Reloj
function actualizarReloj() {
    document.getElementById('time-string').textContent =
        new Date().toLocaleTimeString('es-PE', { hour12: false });
}
setInterval(actualizarReloj, 1000);
actualizarReloj();

// RENIEC
document.getElementById('dni').addEventListener('keyup', function () {
    if (this.value.trim().length === 8) {
        fetch('server/consulta_reniec.php?dni=' + this.value.trim())
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('nombre').value  = data.nombres;
                    document.getElementById('paterno').value = data.apellidoPaterno;
                    document.getElementById('materno').value = data.apellidoMaterno;
                }
            });
    }
});
</script>

<?php 
    include "footer.php"; 
    include "mensajes.php";
?>

 