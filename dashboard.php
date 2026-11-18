<style>
    .hero-welcome {
        background: linear-gradient(135deg, var(--c1), var(--c2) 60%, var(--c3));
        color: #fff; border-radius: 20px; padding: 28px;
        box-shadow: 0 14px 34px rgba(79,70,229,.35);
        position: relative; overflow: hidden;
    }
    .hero-welcome::after {
        content: ""; position: absolute; right: -50px; top: -50px;
        width: 200px; height: 200px; border-radius: 50%; background: rgba(255,255,255,.14);
    }
    .quick-card {
        display: block; text-decoration: none; color: inherit; background: #fff;
        border-radius: 16px; padding: 18px 12px; text-align: center;
        box-shadow: 0 4px 18px rgba(30,30,80,.07); transition: all .2s;
    }
    .quick-card:hover { transform: translateY(-5px); box-shadow: 0 12px 26px rgba(79,70,229,.2); color: inherit; }
    .quick-icon {
        width: 52px; height: 52px; border-radius: 15px; margin: 0 auto 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; color: #fff;
    }
</style>

<div class="mt-3">
    <div class="hero-welcome">
        <small class="opacity-75"><i class="bi bi-hand-thumbs-up me-1"></i>Halo kembali</small>
        <h3 class="fw-bold mt-1 mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']); ?>!</h3>
        <p class="mb-0 opacity-90">
            Saat ini Anda mengakses sistem dengan hak akses sebagai
            <span class="badge rounded-pill bg-light text-primary"><?= htmlspecialchars($_SESSION['role']); ?></span>
        </p>
    </div>

    <h6 class="fw-bold mt-4 mb-3 text-secondary">Akses Cepat</h6>
    <div class="row g-3">
        <div class="col-6 col-md-3">
            <a href="index.php?page=produk" class="quick-card">
                <div class="quick-icon" style="background:linear-gradient(135deg,#4f46e5,#6366f1)"><i class="bi bi-box-seam"></i></div>
                <div class="fw-semibold small">Data Produk</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?page=pelanggan" class="quick-card">
                <div class="quick-icon" style="background:linear-gradient(135deg,#06b6d4,#0ea5e9)"><i class="bi bi-people"></i></div>
                <div class="fw-semibold small">Pelanggan</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?page=pesan" class="quick-card">
                <div class="quick-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316)"><i class="bi bi-cart"></i></div>
                <div class="fw-semibold small">Transaksi</div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="index.php?page=faktur" class="quick-card">
                <div class="quick-icon" style="background:linear-gradient(135deg,#10b981,#22c55e)"><i class="bi bi-receipt"></i></div>
                <div class="fw-semibold small">Faktur</div>
            </a>
        </div>
    </div>
</div>
