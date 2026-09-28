<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'RisolKu'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #fdfbf7; /* Warna off-white/cream khas kuliner */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .btn-primary-custom {
            background-color: #d97706; /* Cokelat hangat */
            border-color: #d97706;
            color: white;
        }
        .btn-primary-custom:hover {
            background-color: #b45309;
            border-color: #b45309;
            color: white;
        }
        .text-warning-emphasis {
            color: #d97706 !important;
        }
    </style>
</head>
<body>