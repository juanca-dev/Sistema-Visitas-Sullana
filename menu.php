<nav>
    <div class="nav-wrapper">
      <a href="index.php" class="brand-logo">
        <i class="material-icons">book</i>
        Libro de Visitas Digital
        </a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="index.php"></a></li>
        <li><a href="historico.php"></a></li>
      </ul>
    </div>
  </nav>

<nav class="blue darken-3">
    <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo"></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="index.php"><i class="material-icons left">edit</i>Registro</a></li>
            
            <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                <li><a href="historico.php"><i class="material-icons left">history</i>Histórico</a></li>
            <?php endif; ?>

            <li>
                <span class="white-text" style="margin: 0 20px;">
                    <i class="material-icons left">account_circle</i>
                    <?php echo $_SESSION['usuario_nom']; ?> (<?php echo ucfirst($_SESSION['rol']); ?>)
                </span>
            </li>
            
            <li><a href="server/logout.php" class="red btn-small waves-effect waves-light">Salir</a></li>
        </ul>
    </div>
</nav>