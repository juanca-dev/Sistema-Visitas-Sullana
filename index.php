<?php 
    // PASO 1: Seguridad
    require_once "server/auth.php"; 

    // PASO 2: Cargar el diseño base
    include "header.php";
    include "menu.php";
    
    // PASO 3: Lógica de datos
    include "server/Visitas.php";
    
    // Instanciamos la clase y obtenemos los números reales de la BD
    $consulta = new Visitas();
    $totalHoy = $consulta->contarTotalHoy();
    $enPlanta = $consulta->contarEnPlanta();
    $egresos  = $consulta->contarEgresosHoy();
?>

<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col s12 m4">
                <div class="card blue darken-1 white-text" style="border-radius: 8px; padding: 15px;">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s4"><i class="material-icons medium">group</i></div>
                        <div class="col s8 right-align">
                            <h5 style="margin: 0;"><?php echo $totalHoy; ?></h5>
                            <p style="margin: 0; font-size: 0.9rem;">Total Hoy</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="card orange darken-3 white-text" style="border-radius: 8px; padding: 15px;">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s4"><i class="material-icons medium">transfer_within_a_station</i></div>
                        <div class="col s8 right-align">
                            <h5 style="margin: 0;"><?php echo $enPlanta; ?></h5>
                            <p style="margin: 0; font-size: 0.9rem;">En Planta</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="card blue-grey darken-2 white-text" style="border-radius: 8px; padding: 15px;">
                    <div class="row valign-wrapper" style="margin-bottom: 0;">
                        <div class="col s4"><i class="material-icons medium">exit_to_app</i></div>
                        <div class="col s8 right-align">
                            <h5 style="margin: 0;"><?php echo $egresos; ?></h5>
                            <p style="margin: 0; font-size: 0.9rem;">Egresos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 10px;">
        <div class="card-panel z-depth-2" style="border-radius: 8px;">
            <form action="server/agregar.php" method="post">
                <div class="row">
                    <h4 class="center-align blue-text text-darken-3" style="font-weight: 500;">Registro de Visitante</h4>
                    <p class="center-align grey-text">Ingresa el DNI para consultar datos automáticamente</p>
                    
                    <div class="input-field col s12 m2">
                        <i class="material-icons prefix">fingerprint</i>
                        <input type="text" name="dni" id="dni" required maxlength="8" class="validate">
                        <label for="dni">DNI</label>
                    </div>

                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">account_circle</i>
                        <input type="text" name="nombre" id="nombre" required class="validate">
                        <label for="nombre">Nombre</label>
                    </div>

                    <div class="input-field col s12 m3">
                        <i class="material-icons prefix">account_circle</i>
                        <input type="text" name="paterno" id="paterno" required class="validate">
                        <label for="paterno">Apellido Paterno</label>
                    </div>

                    <div class="input-field col s12 m4">
                        <i class="material-icons prefix">account_circle</i>
                        <input type="text" name="materno" id="materno" required class="validate">
                        <label for="materno">Apellido Materno</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">comment</i>
                        <input type="text" name="motivo" id="motivo" required class="validate">
                        <label for="motivo">Motivo de la visita</label>
                    </div>
                </div>

                <div class="row center-align">
                    <button type="submit" class="waves-effect waves-light btn-large blue darken-2" style="width: 100%; max-width: 400px; border-radius: 30px;">
                        <i class="material-icons left">send</i>
                        Capturar e Ingresar
                    </button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="card" style="border-radius: 8px;">
                    <div class="card-content">
                        <span class="card-title blue-text text-darken-4">
                            <i class="material-icons left">list</i>Visitantes de Hoy
                        </span>
                        <div class="divider" style="margin-bottom: 20px;"></div>
                        <?php include "listado_visitantes_diario.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="librerias/butterup-main/butterup.js"></script>

<script>
    // Inicializar Materialize
    document.addEventListener('DOMContentLoaded', function() {
        M.AutoInit();
    });

    // Lógica de RENIEC
    document.getElementById('dni').addEventListener('keyup', function() {
        let dni = this.value;
        if (dni.length === 8) {
            if(typeof butterup !== 'undefined') {
                butterup.toast({title: 'Consultando RENIEC', message: 'Buscando datos...', type: 'info'});
            }
            fetch('server/consulta_reniec.php?dni=' + dni)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('nombre').value = data.nombres;
                        document.getElementById('paterno').value = data.apellidoPaterno;
                        document.getElementById('materno').value = data.apellidoMaterno;
                        M.updateTextFields();
                    }
                });
        }
    });
</script>

<?php 
    include "footer.php"; 
    include "mensajes.php";
?>