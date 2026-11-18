<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
// Halaman aktif (hanya huruf, angka, underscore, strip -> cegah path traversal)
$page = isset($_GET['page']) ? preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['page']) : 'dashboard';
if ($page === '') { $page = 'dashboard'; }
function aktif($nama, $page) { return $nama === $page ? ' active' : ''; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>App Penjualan Ritel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --c1: #4f46e5;
            --c2: #7c3aed;
            --c3: #06b6d4;
        }
        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: #f4f5fb;
            padding-top: 72px; padding-bottom: 30px;
        }
        /* Navbar */
        .navbar-app {
            background: linear-gradient(90deg, var(--c1), var(--c2));
            box-shadow: 0 6px 20px rgba(79,70,229,.3);
        }
        .navbar-app .navbar-brand { letter-spacing: .5px; }
        .user-pill {
            background: rgba(255,255,255,.16); border-radius: 50px;
            padding: 5px 14px 5px 10px; color: #fff;
        }
        /* Offcanvas */
        .offcanvas-header-app {
            background: linear-gradient(135deg, var(--c1), var(--c2));
            color: #fff; padding: 22px 20px;
        }
        .menu-link {
            display: flex; align-items: center; gap: 14px;
            margin: 4px 12px; padding: 12px 16px;
            border-radius: 12px; color: #374151; text-decoration: none;
            font-weight: 500; transition: all .2s;
        }
        .menu-link i { font-size: 1.15rem; color: var(--c1); transition: color .2s; }
        .menu-link:hover { background: #eef0ff; color: var(--c1); transform: translateX(4px); }
        .menu-link.active {
            background: linear-gradient(135deg, var(--c1), var(--c2)); color: #fff;
            box-shadow: 0 6px 16px rgba(79,70,229,.35);
        }
        .menu-link.active i { color: #fff; }
        .menu-label { font-size: .7rem; letter-spacing: 1.2px; color: #9ca3af; margin: 14px 24px 4px; font-weight: 600; }
        /* Komponen umum untuk modul berikutnya */
        .card { border: 0; border-radius: 16px; box-shadow: 0 4px 18px rgba(30,30,80,.07); }
        .btn-primary { background: linear-gradient(135deg, var(--c1), var(--c2)); border: 0; }
        .btn-primary:hover { filter: brightness(1.08); }
        .table thead th { background: #eef0ff; color: var(--c1); border: 0; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-app fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler border-0 focus-ring focus-ring-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuSamping">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand me-auto ms-2 fw-bold" href="index.php"><i class="bi bi-shop me-1"></i>APP PENJUALAN</a>
            <div class="user-pill small d-flex align-items-center">
                <i class="bi bi-person-circle fs-5 me-2"></i>
                <span class="d-none d-sm-inline fw-semibold"><?= htmlspecialchars($_SESSION['nama']); ?></span>
                <span class="badge rounded-pill bg-light text-primary ms-2"><?= htmlspecialchars($_SESSION['role']); ?></span>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start border-0" tabindex="-1" id="menuSamping" style="max-width: 285px;">
        <div class="offcanvas-header-app d-flex justify-content-between align-items-start">
            <div>
                <h5 class="mb-1 fw-bold"><i class="bi bi-shop me-2"></i>Menu Navigasi</h5>
                <small class="opacity-75"><?= htmlspecialchars($_SESSION['nama']); ?> &bull; <?= htmlspecialchars($_SESSION['role']); ?></small>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0 d-flex flex-column">
            <div class="mt-2">
                <div class="menu-label">UTAMA</div>
                <a href="index.php" class="menu-link<?= aktif('dashboard', $page); ?>">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') { ?>
                <div class="menu-label">ADMINISTRASI</div>
                <a href="index.php?page=user" class="menu-link<?= aktif('user', $page); ?>">
                    <i class="bi bi-shield-lock"></i> Data Pengguna
                </a>
                <?php } ?>

                <div class="menu-label">DATA &amp; TRANSAKSI</div>
                <a href="index.php?page=produk" class="menu-link<?= aktif('produk', $page); ?>">
                    <i class="bi bi-box-seam"></i> Data Produk
                </a>
                <a href="index.php?page=pelanggan" class="menu-link<?= aktif('pelanggan', $page); ?>">
                    <i class="bi bi-people"></i> Data Pelanggan
                </a>
                <a href="index.php?page=pesan" class="menu-link<?= aktif('pesan', $page); ?>">
                    <i class="bi bi-cart"></i> Transaksi Pesanan
                </a>
                <a href="index.php?page=faktur" class="menu-link<?= aktif('faktur', $page); ?>">
                    <i class="bi bi-receipt"></i> Faktur &amp; Kuitansi
                </a>
            </div>
            <div class="mt-auto p-3">
                <a href="logout.php" class="btn btn-outline-danger w-100 rounded-pill">
                    <i class="bi bi-box-arrow-right me-2"></i> Keluar (Logout)
                </a>
            </div>
        </div>
    </div>

    <!-- Konten Utama Dinamis -->
    <div class="container-fluid px-3">
        <?php
        if ($page == 'dashboard') {
            include 'dashboard.php';
        } else {
            $file = "modul/" . $page . "/index.php";
            if (file_exists($file)) {
                include $file;
            } else {
                echo "<div class='alert alert-warning shadow-sm border-0 rounded-4 mt-3'>
                        <i class='bi bi-info-circle me-2'></i>Modul <b>" . htmlspecialchars($page) . "</b> belum tersedia. Silakan buat filenya terlebih dahulu.
                      </div>";
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
