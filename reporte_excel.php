<?php
// 1. Incluimos la clase para usar la conexión
require_once "server/Visitas.php";
$obj = new Visitas();
$conexion = $obj->conexion();

// 2. Definimos el nombre del archivo con la fecha de hoy
$fecha_reporte = date("d-m-Y");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte_Visitas_$fecha_reporte.xls");

// 3. Consultamos los datos (puedes filtrar por fecha si quieres)
$sql = "SELECT * FROM t_visitas ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $sql);
?>

<meta charset="utf-8">
<table border="1">
    <tr style="background-color: #009688; color: white;">
        <th>DNI</th>
        <th>Apellido Paterno</th>
        <th>Apellido Materno</th>
        <th>Nombres</th>
        <th>Motivo</th>
        <th>Fecha de Ingreso</th>
        <th>Estado (En Planta)</th>
    </tr>

    <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
    <tr>
        <td><?php echo $fila['dni']; ?></td>
        <td><?php echo $fila['paterno']; ?></td>
        <td><?php echo $fila['materno']; ?></td>
        <td><?php echo $fila['nombre']; ?></td>
        <td><?php echo $fila['motivo']; ?></td>
        <td><?php echo $fila['fecha']; ?></td>
        <td><?php echo ($fila['en_planta'] == 1) ? 'DENTRO' : 'SALIO'; ?></td>
    </tr>
    <?php endwhile; ?>
</table>