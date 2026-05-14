<?php
// Desactivamos los avisos de "Deprecated" para que no rompan el PDF
error_reporting(E_ALL & ~E_DEPRECATED);

require('librerias/fpdf/fpdf.php');
require_once "server/Visitas.php";

// Función auxiliar para manejar tildes y Ñ en PHP 8+
function depurar_texto($texto) {
    if (function_exists('mb_convert_encoding')) {
        return mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8');
    }
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $texto);
}

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10, depurar_texto('REPORTE CRONOLÓGICO DE VISITAS'),0,1,'C');
        $this->SetFont('Arial','I',10);
        $this->Cell(0,10, 'Sullana, Piura - ' . date('d/m/Y'),0,1,'C');
        $this->Ln(10);

        $this->SetFillColor(0, 150, 136);
        $this->SetTextColor(255);
        $this->SetFont('Arial','B',10);
        $this->Cell(25,7,'DNI',1,0,'C',true);
        $this->Cell(70,7,'APELLIDOS Y NOMBRES',1,0,'C',true);
        $this->Cell(60,7,'MOTIVO',1,0,'C',true);
        $this->Cell(35,7,'FECHA',1,1,'C',true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10, depurar_texto('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$obj      = new Visitas();
$conexion = $obj->getConexion();  // ← corregido: antes era conexion()

$sql      = "SELECT * FROM t_visitas ORDER BY fecha DESC";
$resultado = mysqli_query($conexion, $sql);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);

while ($row = mysqli_fetch_assoc($resultado)) {
    $nombreCompleto = $row['paterno'] . ' ' . $row['materno'] . ', ' . $row['nombre'];

    $pdf->Cell(25,6, $row['dni'],1);
    $pdf->Cell(70,6, depurar_texto($nombreCompleto),1);
    $pdf->Cell(60,6, depurar_texto($row['motivo']),1);
    $pdf->Cell(35,6, $row['fecha'],1,1);
}

if (ob_get_contents()) ob_end_clean();

$pdf->Output('D', 'Reporte_Visitas_Sullana.pdf');