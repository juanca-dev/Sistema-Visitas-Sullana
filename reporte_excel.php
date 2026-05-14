<?php
/**
 * reporte_excel.php
 * Exporta todo el historial de visitas como archivo .xls
 * Ubicación: raíz del proyecto
 */

require_once "server/Visitas.php";

$obj      = new Visitas();
$conexion = $obj->getConexion();   // ← método público correcto

$fecha_reporte = date("d-m-Y");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Visitas_$fecha_reporte.xls");

$sql       = "SELECT * FROM t_visitas ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $sql);
?>
<meta charset="utf-8">
<table border="1">
    <tr style="background-color:#1d4ed8; color:white;">
        <th>DNI</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>Nombres</th>
        <th>Motivo</th>
        <th>Fecha de Ingreso</th>
        <th>Estado</th>
    </tr>
    <?php while ($fila = mysqli_fetch_assoc($resultado)): ?>
    <tr>
        <td><?php echo htmlspecialchars($fila['dni'],     ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($fila['paterno'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($fila['materno'], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($fila['nombre'],  ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($fila['motivo'],  ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo htmlspecialchars($fila['fecha'],   ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?php echo ($fila['en_planta'] == 1) ? 'DENTRO' : 'SALIO'; ?></td>
    </tr>
    <?php endwhile; ?>
</table>