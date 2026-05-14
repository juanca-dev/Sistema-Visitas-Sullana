<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Visitas Digital</title>

    <!-- Materialize (requerido por el proyecto) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Butterup -->
    <link rel="stylesheet" href="librerias/butterup-main/butterup.css">
    <!-- Tipografías modernas -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ── Reset & base ── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4f8;
            color: #1e293b;
            min-height: 100vh;
        }

        /* ── CSS Variables ── */
        :root {
            --navy:       #0d1a2e;
            --navy-mid:   #0f2545;
            --blue:       #2563eb;
            --blue-light: #3b82f6;
            --blue-dim:   rgba(37,99,235,.12);
            --orange:     #ea580c;
            --slate:      #475569;
            --slate-mid:  #334155;
            --surface:    #ffffff;
            --bg:         #f0f4f8;
            --border:     rgba(0,0,0,.07);
            --radius-sm:  8px;
            --radius-md:  12px;
            --radius-lg:  16px;
            --shadow-sm:  0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md:  0 4px 16px rgba(0,0,0,.08);
            --shadow-lg:  0 8px 32px rgba(0,0,0,.10);
        }

        /* ── Neutralizar Materialize donde interfiere ── */
        nav { box-shadow: none !important; }
        .card { box-shadow: none !important; }
        input:not([type]), input[type=text],
        input[type=password], input[type=email],
        input[type=number] { border-bottom: none !important; box-shadow: none !important; }
        .input-field .prefix.active { color: var(--blue) !important; }
        .input-field input:focus { border-bottom: none !important; box-shadow: none !important; }

        /* ── Utilidades ── */
        .lv-font-display { font-family: 'Sora', sans-serif; }
    </style>
</head>
<body>