<?php
session_start();
require_once 'config/database.php';

if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $stmt = $koneksi->prepare("SELECT id_user, nama, password, role FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Username tidak ditemukan dalam sistem!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Penjualan</title>
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
            min-height: 100vh;
            background: linear-gradient(135deg, var(--c1), var(--c2) 55%, var(--c3));
            background-size: 200% 200%;
            animation: geser 12s ease infinite;
            position: relative;
            overflow: hidden;
        }
        @keyframes geser {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* lingkaran dekorasi */
        body::before, body::after {
            content: ""; position: absolute; border-radius: 50%;
            background: rgba(255,255,255,.12); z-index: 0;
        }
        body::before { width: 340px; height: 340px; top: -90px; left: -90px; }
        body::after  { width: 260px; height: 260px; bottom: -70px; right: -60px; }

        .login-card {
            position: relative; z-index: 1;
            width: 100%; max-width: 410px;
            background: rgba(255,255,255,.95);
            border: 0; border-radius: 22px;
            box-shadow: 0 25px 60px rgba(30,20,90,.35);
        }
        .logo-bulat {
            width: 70px; height: 70px; border-radius: 20px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2rem; color: #fff;
            background: linear-gradient(135deg, var(--c1), var(--c2));
            box-shadow: 0 10px 25px rgba(79,70,229,.45);
        }
        .input-group-text { background: #f3f4f9; border: 0; color: var(--c1); border-radius: 12px 0 0 12px; }
        .form-control { background: #f3f4f9; border: 0; padding: .7rem .9rem; border-radius: 0 12px 12px 0; }
        .form-control:focus { box-shadow: 0 0 0 .2rem rgba(79,70,229,.25); background: #fff; }
        .btn-masuk {
            border: 0; color: #fff; font-weight: 600; padding: .75rem;
            background: linear-gradient(135deg, var(--c1), var(--c2));
            box-shadow: 0 8px 20px rgba(79,70,229,.4);
            transition: transform .15s, box-shadow .15s;
        }
        .btn-masuk:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 12px 26px rgba(79,70,229,.5); }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100 p-3">
        <div class="card login-card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="logo-bulat mb-3"><i class="bi bi-shop"></i></div>
                    <h3 class="fw-bold mb-1">Selamat Datang</h3>
                    <p class="text-muted small mb-0">Masuk ke Aplikasi Penjualan &amp; Kasir</p>
                </div>

                <?php if ($error != ''): ?>
                    <div class="alert alert-danger border-0 rounded-3 py-2 small mb-3">
                        <i class="bi bi-exclamation-circle me-1"></i><?= htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-masuk w-100 rounded-pill">
                        Masuk Sekarang <i class="bi bi-arrow-right ms-1"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
