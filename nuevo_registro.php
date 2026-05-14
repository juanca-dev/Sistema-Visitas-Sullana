<?php 
date_default_timezone_set('America/Lima');
session_start();
require_once 'config.php';
require_once 'server/auth.php';
require_once 'server/Visitas.php';

$obj = new Visitas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Registro - Libro de Visitas Digital</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!-- Notificaciones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
        }

        header {
            background: linear-gradient(135deg, #1565C0 0%, #0D47A1 100%);
            color: white;
            padding: 0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            height: 70px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 700;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: opacity 0.3s;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .btn-salir {
            background: #FF5252;
            color: white !important;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .container-form {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card-form {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .card-form h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1a237e;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-form > p {
            color: #999;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .form-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 18px;
        }

        .form-group.full {
            grid-template-columns: 1fr;
        }

        .input-field-custom label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #666;
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
        }

        .input-field-custom input,
        .input-field-custom textarea {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .input-field-custom input:focus,
        .input-field-custom textarea:focus {
            outline: none;
            border-color: #1565C0;
            box-shadow: 0 0 0 4px rgba(21, 101, 192, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1565C0, #0D47A1);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(21, 101, 192, 0.3);
        }

        .btn-volver {
            display: inline-block;
            margin-top: 16px;
            padding: 10px 20px;
            background: #e0e0e0;
            color: #333;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .btn-volver:hover {
            background: #d0d0d0;
        }

        @media (max-width: 600px) {
            .form-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="navbar">
        <div class="nav-brand">
            <i class="material-icons">assignment</i>
            Libro de Visitas
        </div>
        <div class="nav-right">
            <a href="index.php" class="nav-link">
                <i class="material-icons">dashboard</i> Dashboard
            </a>
            <a href="historico.php" class="nav-link">
                <i class="material-icons">history</i> Histórico
            </a>
            <a href="server/logout.php" class="btn-salir">Salir</a>
        </div>
    </div>
</header>

<div class="container-form">
    <div class="card-form">
        <h1><i class="material-icons">person_add</i> Nuevo Registro</h1>
        <p>Registra una nueva visita en el sistema</p>

        <form action="server/agregar.php" method="POST" id="formRegistro">
            <div class="form-group">
                <div class="input-field-custom">
                    <label>DNI *</label>
                    <input type="text" name="dni" id="dni" placeholder="12345678" maxlength="8" required>
                </div>
                <div class="input-field-custom">
                    <label>Nombre *</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Juan" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-field-custom">
                    <label>Ap. Paterno *</label>
                    <input type="text" name="paterno" id="paterno" placeholder="García" required>
                </div>
                <div class="input-field-custom">
                    <label>Ap. Materno *</label>
                    <input type="text" name="materno" id="materno" placeholder="López" required>
                </div>
            </div>

            <div class="form-group full">
                <div class="input-field-custom">
                    <label>Motivo de la Visita *</label>
                    <textarea name="motivo" placeholder="Ej: Reunión de trabajo, Entrega de documentos" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="material-icons">check_circle</i> Registrar Ingreso
            </button>

            <a href="index.php" class="btn-volver">
                <i class="material-icons">arrow_back</i> Volver al Dashboard
            </a>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Consulta RENIEC al escribir DNI
    document.getElementById('dni').addEventListener('blur', function() {
        const dni = this.value.trim();
        if (dni.length === 8) {
            fetch('server/consulta_reniec.php?dni=' + dni)
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('nombre').value = data.nombres || '';
                        document.getElementById('paterno').value = data.apellidoPaterno || '';
                        document.getElementById('materno').value = data.apellidoMaterno || '';
                        toastr.success('Datos encontrados en RENIEC', 'Éxito');
                    } else {
                        toastr.warning(data.msg || 'DNI no encontrado', 'Aviso');
                    }
                })
                .catch(e => {
                    toastr.error('Error al consultar RENIEC', 'Error');
                    console.log('Error:', e);
                });
        }
    });

    // Validar formulario
    document.getElementById('formRegistro').addEventListener('submit', function(e) {
        const dni = document.getElementById('dni').value.trim();
        
        if (dni.length !== 8 || isNaN(dni)) {
            e.preventDefault();
            toastr.error('El DNI debe tener 8 dígitos', 'Error');
        }
    });
</script>

</body>
</html>