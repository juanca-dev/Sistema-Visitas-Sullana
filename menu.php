<style>
/* ── Navbar ── */
.lv-nav {
    background: var(--navy);
    height: 56px;
    display: flex;
    align-items: center;
    border-bottom: 1px solid rgba(255,255,255,.06);
    position: sticky;
    top: 0;
    z-index: 100;
}

.lv-nav-inner {
    width: 100%;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.lv-nav-brand {
    display: flex;
    align-items: center;
    gap: .6rem;
    text-decoration: none;
}

.lv-nav-brand-icon {
    width: 32px; height: 32px;
    background: var(--blue);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.lv-nav-brand-icon .material-icons {
    font-size: 1rem;
    color: #fff;
}

.lv-nav-brand-text {
    font-family: 'Sora', sans-serif;
    font-size: .9rem;
    font-weight: 600;
    color: #f1f5f9;
    letter-spacing: -.01em;
}

.lv-nav-links {
    display: flex;
    align-items: center;
    gap: .25rem;
    list-style: none;
    margin: 0; padding: 0;
}

.lv-nav-links li a {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: var(--radius-sm);
    font-size: .85rem;
    font-weight: 500;
    color: #94a3b8;
    text-decoration: none;
    transition: background .15s, color .15s;
}

.lv-nav-links li a:hover {
    background: rgba(255,255,255,.07);
    color: #f1f5f9;
}

.lv-nav-links li a.active {
    background: var(--blue-dim);
    color: var(--blue-light);
}

.lv-nav-links li a .material-icons {
    font-size: 1rem;
}

.lv-nav-divider {
    width: 1px;
    height: 20px;
    background: rgba(255,255,255,.1);
    margin: 0 .5rem;
}

.lv-nav-user {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 5px 12px;
    border-radius: var(--radius-sm);
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
}

.lv-nav-avatar {
    width: 26px; height: 26px;
    border-radius: 50%;
    background: var(--blue-dim);
    border: 1px solid rgba(37,99,235,.4);
    display: flex; align-items: center; justify-content: center;
}

.lv-nav-avatar .material-icons { font-size: .9rem; color: var(--blue-light); }

.lv-nav-username {
    font-size: .82rem;
    font-weight: 500;
    color: #cbd5e1;
}

.lv-nav-role {
    font-size: .7rem;
    color: #475569;
    background: rgba(255,255,255,.06);
    padding: 2px 7px;
    border-radius: 100px;
}

.lv-btn-salir {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.2);
    border-radius: var(--radius-sm);
    color: #fca5a5 !important;
    font-size: .82rem;
    font-weight: 500;
    text-decoration: none;
    transition: background .15s, border-color .15s;
}

.lv-btn-salir:hover {
    background: rgba(239,68,68,.18) !important;
    border-color: rgba(239,68,68,.35) !important;
    color: #fca5a5 !important;
}

.lv-btn-salir .material-icons { font-size: .9rem; }
</style>

<nav class="lv-nav">
    <div class="lv-nav-inner">

        <!-- Brand -->
        <a href="index.php" class="lv-nav-brand">
            <div class="lv-nav-brand-icon">
                <i class="material-icons">book</i>
            </div>
            <span class="lv-nav-brand-text">Libro de Visitas</span>
        </a>

        <!-- Links + usuario -->
        <ul class="lv-nav-links">
            <li>
                <a href="index.php" class="active">
                    <i class="material-icons">edit</i>Registro
                </a>
            </li>

            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
            <li>
                <a href="historico.php">
                    <i class="material-icons">history</i>Histórico
                </a>
            </li>
            <?php endif; ?>

            <div class="lv-nav-divider"></div>

            <li>
                <div class="lv-nav-user">
                    <div class="lv-nav-avatar">
                        <i class="material-icons">account_circle</i>
                    </div>
                    <span class="lv-nav-username"><?php echo htmlspecialchars($_SESSION['usuario_nom']); ?></span>
                    <span class="lv-nav-role"><?php echo ucfirst($_SESSION['rol']); ?></span>
                </div>
            </li>

            <li>
                <a href="server/logout.php" class="lv-btn-salir">
                    <i class="material-icons">logout</i>Salir
                </a>
            </li>
        </ul>

    </div>
</nav>