<?php 
if (isset($_SESSION['mensaje'])) {
    $mensaje_key = $_SESSION['mensaje']; // Guardamos la llave del mensaje
    unset($_SESSION['mensaje']); // Limpiamos la sesión inmediatamente

    $titulo = '';
    $mensaje_texto = '';
    $alerta = 'info'; // Valor por defecto

    // Lógica para definir qué mostrar según el caso
    switch ($mensaje_key) {
        case 'exito':
            $titulo = '¡Éxito!';
            $mensaje_texto = 'Visitante registrado correctamente.';
            $alerta = 'success';
            break;
            
        case 'salida_exitosa':
            $titulo = 'Salida Registrada';
            $mensaje_texto = 'El visitante se ha retirado de la planta.';
            $alerta = 'success';
            break;

        case 'error':
            $titulo = '¡Error!';
            $mensaje_texto = 'Hubo un fallo en el servidor.';
            $alerta = 'error';
            break;

        case 'campos_vacios':
            $titulo = '¡Atención!';
            $mensaje_texto = 'Debes completar todos los campos obligatorios.';
            $alerta = 'warning';
            break;

        default:
            $titulo = 'Información';
            $mensaje_texto = $mensaje_key; // Muestra el texto tal cual si no coincide con los anteriores
            $alerta = 'info';
            break;
    }
?>
    <script>
        // Usamos los valores procesados en PHP para disparar Butterup
        butterup.toast({
            title: '<?php echo $titulo; ?>',
            message: '<?php echo $mensaje_texto; ?>',
            type: '<?php echo $alerta; ?>',
            icon: true,
            dismissable: true
        });
    </script>
<?php 
} 
?>