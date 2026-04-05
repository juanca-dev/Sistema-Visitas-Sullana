<?php 
    // PASO 1: El Middleware verificará si es ADMIN
    include "server/auth.php"; 

    include "header.php";
    include "server/Visitas.php";
    $obj = new Visitas();
    $items = $obj->mostrarTodos(); // Jalamos toda la historia
?>

<div class="container">
    <?php include "menu.php"; ?>
    
    <div class="row" style="margin-top: 30px;">
        <div class="col s12 m6">
            <h4 class="blue-text text-darken-3" style="font-weight: 500; margin: 0;">
                <i class="material-icons left" style="font-size: 35px;">history</i> Historial General
            </h4>
        </div>
        
        <div class="col s12 m6 right-align">
            <div style="display: inline-flex; gap: 10px; margin-top: 10px;">
                <a href="reporte_excel.php" class="btn green darken-2 waves-effect z-depth-2" style="border-radius: 4px;">
                    <i class="material-icons left">description</i> EXCEL
                </a>
                
                <a href="reporte_pdf.php" class="btn red darken-1 waves-effect z-depth-2" style="border-radius: 4px;">
                    <i class="material-icons left">picture_as_pdf</i> PDF
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card" style="border-radius: 10px; overflow: hidden;">
                <div class="card-content" style="padding: 10px;">
                    <?php include "listado_visitantes_historico.php"; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>