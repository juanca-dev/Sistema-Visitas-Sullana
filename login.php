<?php 
session_start();
// Si ya hay sesión, mandarlo directo al index
if(isset($_SESSION['usuario_id'])){ header("location:index.php"); }
include "header.php"; 
?>

<style>
    body { display: flex; min-height: 100vh; flex-direction: column; background-color: #f5f5f5; }
    .login-container { margin-top: 5%; }
    .card-login { border-radius: 15px; padding: 20px; }
    .logo-login { font-size: 5rem; color:#2196f3 }
</style>

<div class="container login-container">
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card card-login z-depth-4">
                <div class="card-content center-align">
                    <i class="material-icons logo-login">account_circle</i>
                    <span class="card-title">Acceso al Sistema</span>
                    <p class="grey-text">Libro de Visitas Digital - Sullana</p>
                    
                    <form action="server/login_proceso.php" method="POST">
                        <div class="input-field">
                            <i class="material-icons prefix">person</i>
                            <input type="text" name="usuario" id="usuario" required class="validate">
                            <label for="usuario">Nombre de Usuario</label>
                        </div>
                        
                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password" id="password" required class="validate">
                            <label for="password">Contraseña</label>
                        </div>
                        
                        <div class="row">
                            <button type="submit" class="btn-large waves-effect waves-light col s12 red lighten-1">
                                Ingresar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include "footer.php"; 
include "mensajes.php"; // Para mostrar "Usuario incorrecto", etc.
?>