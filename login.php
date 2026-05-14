<?php
session_start();
$mensaje = $_SESSION['mensaje'] ?? '';
unset($_SESSION['mensaje']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Libro de Visitas · Acceso</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --cobalt:    #1A56DB;
  --cobalt-dk: #1040B0;
  --cobalt-lt: #3B82F6;
  --slate:     #0F172A;
  --slate-mid: #1E293B;
  --slate-lt:  #334155;
  --mist:      #F1F5F9;
  --mist-dk:   #E2E8F0;
  --text:      #0F172A;
  --text-2:    #475569;
  --text-3:    #94A3B8;
  --green:     #10B981;
  --white:     #FFFFFF;
  --panel-w:   42%;
}

html, body {
  height: 100%;
  font-family: 'Sora', sans-serif;
  background: var(--mist);
  overflow: hidden;
}

/* ── LAYOUT ── */
.screen {
  display: flex;
  height: 100vh;
  width: 100vw;
}

/* ── LEFT PANEL ── */
.brand-panel {
  width: var(--panel-w);
  background: var(--slate);
  position: relative;
  display: flex;
  flex-direction: column;
  padding: 40px 48px;
  overflow: hidden;
  flex-shrink: 0;
}

/* Geometric background */
.brand-panel::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 80% 60% at 20% 80%, rgba(26,86,219,0.28) 0%, transparent 70%),
    radial-gradient(ellipse 60% 50% at 85% 10%, rgba(59,130,246,0.15) 0%, transparent 65%);
  pointer-events: none;
}

.geo-lines {
  position: absolute;
  inset: 0;
  pointer-events: none;
  overflow: hidden;
}
.geo-lines svg {
  width: 100%; height: 100%;
  opacity: 0.07;
}

/* Logo row */
.logo-row {
  display: flex;
  align-items: center;
  gap: 12px;
  position: relative;
  z-index: 2;
  animation: fadeUp 0.7s ease both;
}
.logo-box {
  width: 44px; height: 44px;
  background: var(--cobalt);
  border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.logo-box svg { width: 24px; height: 24px; color: #fff; }
.logo-text { line-height: 1.1; }
.logo-name {
  font-size: 0.92rem;
  font-weight: 600;
  color: var(--white);
  letter-spacing: 0.01em;
}
.logo-sub {
  font-size: 0.68rem;
  font-weight: 400;
  color: var(--text-3);
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.live-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(16,185,129,0.12);
  border: 1px solid rgba(16,185,129,0.3);
  border-radius: 20px;
  padding: 4px 11px;
  font-size: 0.67rem;
  font-weight: 600;
  color: var(--green);
  letter-spacing: 0.08em;
  margin-left: auto;
}
.live-dot {
  width: 6px; height: 6px;
  background: var(--green);
  border-radius: 50%;
  animation: pulse 1.8s ease-in-out infinite;
}

/* Hero text */
.brand-body {
  position: relative;
  z-index: 2;
  margin-top: auto;
  padding-bottom: 10px;
  animation: fadeUp 0.7s 0.15s ease both;
}
.brand-eyebrow {
  font-size: 0.7rem;
  font-weight: 500;
  color: var(--cobalt-lt);
  letter-spacing: 0.14em;
  text-transform: uppercase;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.brand-eyebrow::before {
  content: '';
  display: block;
  width: 28px; height: 1.5px;
  background: var(--cobalt-lt);
}
.brand-headline {
  font-size: clamp(1.75rem, 3vw, 2.4rem);
  font-weight: 700;
  color: var(--white);
  line-height: 1.18;
  margin-bottom: 18px;
  letter-spacing: -0.02em;
}
.brand-headline span { color: var(--cobalt-lt); }
.brand-desc {
  font-size: 0.85rem;
  font-weight: 300;
  color: #94A3B8;
  line-height: 1.7;
  max-width: 320px;
}

/* Feature pills */
.feature-list {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 36px;
  position: relative;
  z-index: 2;
  animation: fadeUp 0.7s 0.28s ease both;
}
.feature-item {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 0.8rem;
  color: #CBD5E1;
  font-weight: 400;
}
.feature-icon {
  width: 28px; height: 28px;
  background: rgba(26,86,219,0.2);
  border: 1px solid rgba(26,86,219,0.35);
  border-radius: 7px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.feature-icon svg { width: 14px; height: 14px; color: var(--cobalt-lt); }

/* Footer */
.brand-footer {
  position: relative;
  z-index: 2;
  margin-top: 40px;
  padding-top: 24px;
  border-top: 1px solid rgba(255,255,255,0.06);
  font-size: 0.7rem;
  color: #475569;
  font-weight: 300;
  animation: fadeUp 0.7s 0.35s ease both;
}

/* ── RIGHT PANEL ── */
.form-panel {
  flex: 1;
  background: var(--white);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 48px 56px;
  position: relative;
  overflow-y: auto;
}

/* Top-right security badge */
.security-bar {
  position: absolute;
  top: 20px;
  right: 24px;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 0.7rem;
  color: #059669;
  font-weight: 500;
  background: #ECFDF5;
  border: 1px solid #A7F3D0;
  border-radius: 6px;
  padding: 5px 10px;
}
.security-bar svg { width: 13px; height: 13px; }

.form-inner {
  width: 100%;
  max-width: 400px;
  animation: fadeUp 0.6s 0.1s ease both;
}

/* Welcome */
.welcome-block { margin-bottom: 32px; }
.welcome-label {
  font-size: 0.7rem;
  font-weight: 500;
  color: var(--cobalt);
  letter-spacing: 0.14em;
  text-transform: uppercase;
  margin-bottom: 8px;
}
.welcome-title {
  font-size: 1.85rem;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -0.03em;
  line-height: 1.1;
  margin-bottom: 8px;
}
.welcome-sub {
  font-size: 0.83rem;
  color: var(--text-2);
  font-family: 'DM Sans', sans-serif;
  font-weight: 400;
  line-height: 1.5;
}

/* Role selector */
.role-label {
  font-size: 0.68rem;
  font-weight: 600;
  color: var(--text-3);
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 10px;
}
.role-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 10px;
  margin-bottom: 28px;
}
.role-card {
  border: 1.5px solid var(--mist-dk);
  border-radius: 12px;
  padding: 14px 16px;
  cursor: pointer;
  transition: border-color 0.2s, background 0.2s, transform 0.15s;
  position: relative;
  background: var(--white);
  user-select: none;
}
.role-card:hover {
  border-color: #93C5FD;
  background: #F0F7FF;
  transform: translateY(-1px);
}
.role-card.active {
  border-color: var(--cobalt);
  background: #EFF6FF;
}
.role-card.active .role-check {
  opacity: 1; transform: scale(1);
}
.role-check {
  position: absolute;
  top: 10px; right: 10px;
  width: 18px; height: 18px;
  background: var(--cobalt);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  opacity: 0;
  transform: scale(0.5);
  transition: opacity 0.2s, transform 0.2s;
}
.role-check svg { width: 10px; height: 10px; color: #fff; }
.role-icon-wrap {
  width: 34px; height: 34px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 10px;
}
.role-icon-wrap.admin  { background: #DBEAFE; }
.role-icon-wrap.recep  { background: #D1FAE5; }
.role-icon-wrap svg    { width: 18px; height: 18px; }
.role-icon-wrap.admin svg { color: var(--cobalt); }
.role-icon-wrap.recep svg  { color: #059669; }
.role-name {
  font-size: 0.85rem;
  font-weight: 600;
  color: var(--text);
  margin-bottom: 3px;
}
.role-desc {
  font-size: 0.7rem;
  color: var(--text-2);
  line-height: 1.4;
  font-family: 'DM Sans', sans-serif;
}
.role-status {
  display: flex; align-items: center; gap: 5px;
  font-size: 0.65rem;
  color: var(--green);
  font-weight: 500;
  margin-top: 8px;
}
.role-status-dot {
  width: 5px; height: 5px;
  background: var(--green);
  border-radius: 50%;
}

/* Form fields */
.field-group { margin-bottom: 16px; }
.field-label {
  display: block;
  font-size: 0.68rem;
  font-weight: 600;
  color: var(--text-2);
  letter-spacing: 0.09em;
  text-transform: uppercase;
  margin-bottom: 7px;
}
.field-wrap {
  position: relative;
  display: flex;
  align-items: center;
}
.field-icon {
  position: absolute;
  left: 14px;
  width: 17px; height: 17px;
  color: var(--text-3);
  pointer-events: none;
  transition: color 0.2s;
}
.field-wrap:focus-within .field-icon { color: var(--cobalt); }
.field-input {
  width: 100%;
  height: 46px;
  background: var(--mist);
  border: 1.5px solid transparent;
  border-radius: 10px;
  padding: 0 44px 0 42px;
  font-family: 'DM Sans', sans-serif;
  font-size: 0.88rem;
  color: var(--text);
  outline: none;
  transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
}
.field-input::placeholder { color: var(--text-3); font-size: 0.83rem; }
.field-input:focus {
  border-color: var(--cobalt);
  background: var(--white);
  box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
}
.eye-btn {
  position: absolute;
  right: 13px;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--text-3);
  padding: 4px;
  display: flex; align-items: center;
  transition: color 0.2s;
}
.eye-btn:hover { color: var(--cobalt); }
.eye-btn svg { width: 17px; height: 17px; }

/* Submit */
.btn-submit {
  width: 100%;
  height: 50px;
  background: var(--cobalt);
  color: #fff;
  border: none;
  border-radius: 12px;
  font-family: 'Sora', sans-serif;
  font-size: 0.85rem;
  font-weight: 600;
  letter-spacing: 0.06em;
  cursor: pointer;
  display: flex; align-items: center; justify-content: center; gap: 10px;
  margin-top: 24px;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
  box-shadow: 0 4px 14px rgba(26,86,219,0.35);
  position: relative;
  overflow: hidden;
}
.btn-submit::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 60%);
}
.btn-submit:hover {
  background: var(--cobalt-dk);
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(26,86,219,0.45);
}
.btn-submit:active { transform: translateY(0); }
.btn-submit svg { width: 18px; height: 18px; }

/* Extra links */
.extra-links {
  display: flex;
  justify-content: center;
  gap: 24px;
  margin-top: 18px;
}
.extra-links a {
  font-size: 0.75rem;
  color: var(--text-3);
  text-decoration: none;
  font-family: 'DM Sans', sans-serif;
  transition: color 0.2s;
}
.extra-links a:hover { color: var(--cobalt); }

/* Form footer */
.form-footer {
  position: absolute;
  bottom: 20px;
  left: 0; right: 0;
  text-align: center;
  font-size: 0.68rem;
  color: var(--text-3);
  font-family: 'DM Sans', sans-serif;
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.form-footer strong { color: var(--text-2); font-weight: 500; }

/* Alert error */
.alert-error {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #FEF2F2;
  border: 1.5px solid #FECACA;
  border-radius: 10px;
  padding: 12px 16px;
  font-size: 0.82rem;
  color: #991B1B;
  font-family: 'DM Sans', sans-serif;
  margin-bottom: 20px;
  animation: fadeUp 0.3s ease both;
}
.alert-error svg { width: 18px; height: 18px; flex-shrink: 0; color: #DC2626; }

/* Divider */
.field-divider {
  height: 1px;
  background: var(--mist-dk);
  margin: 20px 0;
}

/* Animations */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes pulse {
  0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(16,185,129,0.5); }
  50%       { opacity: 0.7; box-shadow: 0 0 0 5px rgba(16,185,129,0); }
}

/* Responsive */
@media (max-width: 720px) {
  :root { --panel-w: 0%; }
  .brand-panel { display: none; }
  .form-panel { padding: 32px 24px; }
}
</style>
</head>
<body>

<div class="screen">

  <!-- ══ LEFT: BRAND PANEL ══ -->
  <div class="brand-panel">

    <div class="geo-lines">
      <svg viewBox="0 0 420 700" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
        <line x1="0" y1="120" x2="420" y2="360" stroke="white" stroke-width="1"/>
        <line x1="0" y1="280" x2="420" y2="520" stroke="white" stroke-width="1"/>
        <line x1="0" y1="440" x2="420" y2="680" stroke="white" stroke-width="1"/>
        <line x1="80" y1="0" x2="340" y2="700" stroke="white" stroke-width="0.8"/>
        <line x1="220" y1="0" x2="420" y2="380" stroke="white" stroke-width="0.8"/>
        <circle cx="60" cy="580" r="140" stroke="white" stroke-width="0.8" fill="none"/>
        <circle cx="60" cy="580" r="90"  stroke="white" stroke-width="0.5" fill="none"/>
        <circle cx="370" cy="80" r="80"  stroke="white" stroke-width="0.6" fill="none"/>
      </svg>
    </div>

    <div class="logo-row">
      <div class="logo-box">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14,2 14,8 20,8"/>
          <line x1="8" y1="13" x2="16" y2="13"/>
          <line x1="8" y1="17" x2="12" y2="17"/>
        </svg>
      </div>
      <div class="logo-text">
        <div class="logo-name">Libro de Visitas</div>
        <div class="logo-sub">Sullana · Digital</div>
      </div>
      <div class="live-badge">
        <span class="live-dot"></span>EN VIVO
      </div>
    </div>

    <div class="brand-body">
      <div class="brand-eyebrow">Sistema corporativo</div>
      <h1 class="brand-headline">
        Control de accesos<br><span>en tiempo real</span>
      </h1>
      <p class="brand-desc">
        Optimice y gestione el registro de visitantes en sus instalaciones de forma centralizada y segura.
      </p>
    </div>

    <div class="feature-list">
      <div class="feature-item">
        <div class="feature-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        Acceso seguro con roles diferenciados
      </div>
      <div class="feature-item">
        <div class="feature-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
        </div>
        Historial completo con exportación
      </div>
      <div class="feature-item">
        <div class="feature-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/>
          </svg>
        </div>
        Reportes en tiempo real
      </div>
    </div>

    <div class="brand-footer">
      © 2026 Libro de Visitas Digital · Sullana, Piura
    </div>
  </div>

  <!-- ══ RIGHT: FORM PANEL ══ -->
  <div class="form-panel">

    <div class="security-bar">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
      Conexión segura
    </div>

    <div class="form-inner">

      <div class="welcome-block">
        <div class="welcome-label">Acceso al sistema</div>
        <h2 class="welcome-title">Bienvenido</h2>
        <p class="welcome-sub">Seleccione su rol y proporcione sus credenciales de acceso.</p>
      </div>

      <?php if ($mensaje === 'credenciales_incorrectas'): ?>
      <div class="alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Usuario o contraseña incorrectos. Verifique sus credenciales.
      </div>
      <?php elseif ($mensaje === 'campos_vacios'): ?>
      <div class="alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Por favor complete todos los campos antes de continuar.
      </div>
      <?php endif; ?>

      <div class="role-label">Seleccionar rol</div>
      <div class="role-grid">
        <div class="role-card active" id="card-admin" onclick="selectRole('admin')">
          <div class="role-check" id="check-admin">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20,6 9,17 4,12"/>
            </svg>
          </div>
          <div class="role-icon-wrap admin">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <div class="role-name">Administrador</div>
          <div class="role-desc">Reportes y configuraciones globales</div>
          <div class="role-status"><span class="role-status-dot"></span>Disponible</div>
        </div>

        <div class="role-card" id="card-recep" onclick="selectRole('recep')">
          <div class="role-check" id="check-recep">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20,6 9,17 4,12"/>
            </svg>
          </div>
          <div class="role-icon-wrap recep">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <rect x="2" y="7" width="20" height="14" rx="2"/>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
          </div>
          <div class="role-name">Recepción</div>
          <div class="role-desc">Registro de ingresos y salidas</div>
          <div class="role-status"><span class="role-status-dot"></span>Disponible</div>
        </div>
      </div>

      <div class="field-divider"></div>

      <!-- Formulario real PHP -->
      <form method="POST" action="server/login_proceso.php" autocomplete="off">
        <input type="hidden" name="rol" id="input-rol" value="admin">

        <div class="field-group">
          <label class="field-label" for="usuario">Usuario</label>
          <div class="field-wrap">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
            <input class="field-input" type="text" id="usuario" name="usuario"
                   placeholder="Escriba su nombre de usuario" required autocomplete="off">
          </div>
        </div>

        <div class="field-group">
          <label class="field-label" for="password">Contraseña</label>
          <div class="field-wrap">
            <svg class="field-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <rect x="3" y="11" width="18" height="11" rx="2"/>
              <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
            <input class="field-input" type="password" id="password" name="password"
                   placeholder="Ingrese su contraseña de acceso" required autocomplete="off">
            <button type="button" class="eye-btn" onclick="togglePwd()" id="eye-btn" aria-label="Mostrar contraseña">
              <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
        </div>

        <button class="btn-submit" type="submit">
          INGRESAR AL SISTEMA
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12,5 19,12 12,19"/>
          </svg>
        </button>
      </form>

      <div class="extra-links">
        <a href="#">¿Olvidó su contraseña?</a>
        <a href="#">¿No tiene cuenta?</a>
      </div>

    </div>

    <div class="form-footer">
      <span><strong>Sistema interno</strong> · Solo personal autorizado</span>
      <span>© 2026 Libro de Visitas Digital · Sullana</span>
    </div>

  </div>
</div>

<script>
function selectRole(role) {
  ['admin','recep'].forEach(r => {
    document.getElementById('card-' + r).classList.remove('active');
  });
  document.getElementById('card-' + role).classList.add('active');
  document.getElementById('input-rol').value = role;
}

const eyeOpen = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
const eyeOff  = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
let visible = false;

function togglePwd() {
  visible = !visible;
  document.getElementById('password').type = visible ? 'text' : 'password';
  document.getElementById('eye-icon').innerHTML = visible ? eyeOff : eyeOpen;
}
</script>
</body>
</html>