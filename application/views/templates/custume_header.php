<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= isset($title) ? $title : 'RisolKu'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background-color: #fdfbf7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            padding-bottom: 70px; /* Spacer untuk bottom nav */
        }
        .brand-color { color: #d97706; }
        .bg-brand { background-color: #d97706; color: white; }
        .btn-brand { background-color: #d97706; border-color: #d97706; color: white; }
        .btn-brand:hover { background-color: #b45309; border-color: #b45309; color: white; }
        
        /* Styling Kartu Produk */
        .product-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: transform 0.2s;
        }
        .product-card:active { transform: scale(0.98); }
        
        /* Placeholder gambar produk (warna cream terang) */
        .product-image-placeholder {
            width: 100%;
            aspect-ratio: 1 / 1;
            background-color: #f3ece1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Top Navbar Simple Customer -->
    <nav class="navbar navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid px-3 py-1">
            <a class="navbar-brand fw-bold brand-color" href="<?= base_url(); ?>">
                <i class="fas fa-box-open me-1"></i> RisolKu
            </a>
            <a href="<?= base_url('login'); ?>" class="text-muted text-decoration-none small">
                <i class="fas fa-user-circle fs-4 mt-1"></i>
            </a>
        </div>
    </nav>