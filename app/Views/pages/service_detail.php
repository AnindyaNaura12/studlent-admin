<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #fff7f0; color: #1a1a1a; min-height: 100vh; }

        .sidebar { position: fixed; top: 0; left: 0; width: 240px; height: 100vh; background: #fff; border-right: 1px solid #ffe0cc; display: flex; flex-direction: column; z-index: 100; }
        .sidebar-logo { padding: 24px 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #ffe0cc; }
        .logo-box { width: 40px; height: 40px; background: #f97316; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .logo-box svg { width: 22px; height: 22px; }
        .logo-text { font-size: 18px; font-weight: 600; color: #f97316; }
        .logo-sub { font-size: 11px; color: #9ca3af; margin-top: -2px; }
        .sidebar-nav { flex: 1; padding: 16px 12px; }
        .nav-label { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; padding: 8px 8px 4px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; font-size: 14px; color: #6b7280; text-decoration: none; margin-bottom: 2px; transition: all 0.15s; }
        .nav-item:hover { background: #fff1e6; color: #f97316; }
        .nav-item.active { background: #fff1e6; color: #f97316; font-weight: 600; }
        .nav-item i { font-size: 18px; }

        .main { margin-left: 240px; padding: 28px 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .topbar h1 { font-size: 22px; font-weight: 600; }
        .topbar p { font-size: 13px; color: #9ca3af; margin-top: 2px; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; }

        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #fff; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 13px; color: #6b7280; text-decoration: none; margin-bottom: 20px; }
        .btn-back:hover { background: #fff1e6; color: #f97316; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; display: flex; justify-content: space-between; align-items: center; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-body { padding: 20px; }

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .field-value { font-size: 14px; color: #111827; font-weight: 500; }
        .field-value.empty { color: #d1d5db; font-style: italic; font-weight: 400; }
        .field-full { grid-column: span 2; }

        .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-active   { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #f3f4f6; color: #6b7280; }
        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .thumbnail-lg { width: 100%; max-height: 220px; object-fit: cover; border-radius: 10px; border: 1px solid #ffe0cc; }
        .thumbnail-placeholder { width: 100%; height: 180px; background: #fff1e6; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #f97316; font-size: 48px; border: 1px solid #ffe0cc; }

        .images-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px; }
        .images-grid img { width: 100%; height: 90px; object-fit: cover; border-radius: 8px; border: 1px solid #ffe0cc; }

        .package-card { border: 1px solid #ffe0cc; border-radius: 10px; padding: 16px; margin-bottom: 12px; }
        .package-card:last-child { margin-bottom: 0; }
        .package-name { font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #111827; }
        .package-meta { display: flex; gap: 16px; margin-bottom: 8px; }
        .package-meta span { font-size: 12px; color: #6b7280; display: flex; align-items: center; gap: 4px; }
        .package-price { font-size: 18px; font-weight: 700; color: #f97316; }
        .package-desc { font-size: 13px; color: #6b7280; margin-top: 6px; }

        .rating { display: flex; align-items: center; gap: 4px; color: #f59e0b; font-weight: 600; }

        .status-form { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-approve { padding: 9px 20px; background: #d1fae5; color: #059669; border: 1px solid #a7f3d0; border-radius: 8px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 600; }
        .btn-approve:hover { background: #a7f3d0; }
        .btn-reject  { padding: 9px 20px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 600; }
        .btn-reject:hover { background: #fecaca; }
        .btn-inactive { padding: 9px 20px; background: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
        .btn-inactive:hover { background: #e5e7eb; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="logo-box">
            <svg viewBox="0 0 36 36" fill="none">
                <path d="M6 10C6 8.34 7.34 7 9 7H27C28.66 7 30 8.34 30 10V22C30 23.66 28.66 25 27 25H20L18 29L16 25H9C7.34 25 6 23.66 6 22V10Z" fill="white" opacity="0.9"/>
                <rect x="10" y="12" width="6" height="2" rx="1" fill="#f97316"/>
                <rect x="10" y="16" width="10" height="2" rx="1" fill="#f97316"/>
                <rect x="10" y="20" width="7" height="2" rx="1" fill="#f97316"/>
                <circle cx="26" cy="12" r="2.5" fill="#fdba74"/>
            </svg>
        </div>
        <div>
            <div class="logo-text">Studlent</div>
            <div class="logo-sub">Admin Panel</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="/studlent-admin/public/dashboard" class="nav-item">
            <i class="ti ti-layout-dashboard"></i> Dashboard
        </a>
        <a href="/studlent-admin/public/user" class="nav-item">
            <i class="ti ti-users"></i> Users
        </a>
        <a href="/studlent-admin/public/order" class="nav-item">
            <i class="ti ti-shopping-cart"></i> Orders
        </a>
        <a href="/studlent-admin/public/service" class="nav-item active">
            <i class="ti ti-briefcase"></i> Services
        </a>
        <a href="/studlent-admin/public/withdrawals" class="nav-item">
            <i class="ti ti-cash"></i> Withdrawals
        </a>

        <div class="nav-label" style="margin-top:12px">Keuangan</div>
        <a href="/studlent-admin/public/payments" class="nav-item">
            <i class="ti ti-credit-card"></i> Payments
        </a>
        <a href="/studlent-admin/public/escrow" class="nav-item">
            <i class="ti ti-safe"></i> Escrow
        </a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Detail Service</h1>
            <p>Informasi lengkap layanan freelancer</p>
        </div>
        <div class="avatar">A</div>
    </div>

    <a href="<?= BASE_URL ?>service" class="btn-back"><i class="ti ti-arrow-left"></i> Kembali ke Services</a>

    <div class="detail-grid">

        <!-- Kiri: Info utama -->
        <div>
            <!-- Thumbnail -->
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Thumbnail</span>
                </div>
                <div class="panel-body">
                    <?php if (!empty($service['thumbnail_url'])): ?>
                        <img src="<?= htmlspecialchars($service['thumbnail_url']) ?>" class="thumbnail-lg" alt="">
                    <?php else: ?>
                        <div class="thumbnail-placeholder"><i class="ti ti-photo"></i></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Gambar tambahan -->
            <?php if (!empty($images)): ?>
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Galeri Gambar</span>
                </div>
                <div class="panel-body">
                    <div class="images-grid">
                        <?php foreach ($images as $img): ?>
                            <img src="<?= htmlspecialchars($img['image_url']) ?>" alt="">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Kanan: Detail -->
        <div>
            <!-- Info Service -->
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Informasi Service</span>
                    <span class="badge badge-<?= htmlspecialchars($service['status']) ?>"><?= ucfirst($service['status']) ?></span>
                </div>
                <div class="panel-body">
                    <div class="field-grid">
                        <div class="field-full">
                            <div class="field-label">Judul</div>
                            <div class="field-value"><?= htmlspecialchars($service['judul'] ?? '-') ?></div>
                        </div>
                        <div>
                            <div class="field-label">Rating</div>
                            <div class="rating">
                                <i class="ti ti-star-filled" style="font-size:14px"></i>
                                <?= number_format($service['rating_avg'] ?? 0, 1) ?>
                            </div>
                        </div>
                        <div>
                            <div class="field-label">Total Order</div>
                            <div class="field-value"><?= number_format($service['total_order'] ?? 0) ?></div>
                        </div>
                        <div>
                            <div class="field-label">ID Freelancer</div>
                            <div class="field-value" style="font-family:monospace;font-size:12px"><?= htmlspecialchars($service['id_freelancer'] ?? '-') ?></div>
                        </div>
                        <div>
                            <div class="field-label">Dibuat</div>
                            <div class="field-value"><?= !empty($service['created_at']) ? date('d M Y', strtotime($service['created_at'])) : '-' ?></div>
                        </div>
                        <div class="field-full">
                            <div class="field-label">Deskripsi</div>
                            <div class="field-value <?= empty($service['deskripsi']) ? 'empty' : '' ?>" style="font-weight:400;line-height:1.6">
                                <?= nl2br(htmlspecialchars($service['deskripsi'] ?? 'Tidak ada deskripsi')) ?>
                            </div>
                        </div>
                        <div class="field-full">
                            <div class="field-label">What You Get</div>
                            <div class="field-value <?= empty($service['what_you_get']) ? 'empty' : '' ?>" style="font-weight:400;line-height:1.6">
                                <?= nl2br(htmlspecialchars($service['what_you_get'] ?? 'Tidak ada informasi')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approve / Reject -->
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Update Status Service</span>
                </div>
                <div class="panel-body">
                    <form method="POST" action="<?= BASE_URL ?>service/updatestatus">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($service['id_service']) ?>">
                        <input type="hidden" name="from" value="<?= htmlspecialchars($service['id_service']) ?>">
                        <div class="status-form">
                            <?php if ($service['status'] !== 'active'): ?>
                            <button type="submit" name="status" value="active" class="btn-approve" onclick="return confirm('Approve service ini?')">
                                <i class="ti ti-check"></i> Approve
                            </button>
                            <?php endif; ?>
                            <?php if ($service['status'] !== 'rejected'): ?>
                            <button type="submit" name="status" value="rejected" class="btn-reject" onclick="return confirm('Reject service ini?')">
                                <i class="ti ti-x"></i> Reject
                            </button>
                            <?php endif; ?>
                            <?php if ($service['status'] === 'active'): ?>
                            <button type="submit" name="status" value="inactive" class="btn-inactive" onclick="return confirm('Nonaktifkan service ini?')">
                                <i class="ti ti-eye-off"></i> Nonaktifkan
                            </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Packages -->
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Paket Layanan</span>
        </div>
        <div class="panel-body">
            <?php if (!empty($packages)): ?>
                <?php foreach ($packages as $pkg): ?>
                <div class="package-card">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start">
                        <div class="package-name"><?= htmlspecialchars($pkg['nama'] ?? '-') ?></div>
                        <div class="package-price">Rp <?= number_format($pkg['harga'] ?? 0, 0, ',', '.') ?></div>
                    </div>
                    <div class="package-meta">
                        <span><i class="ti ti-clock"></i> <?= htmlspecialchars($pkg['delivery_time'] ?? '-') ?> hari</span>
                    </div>
                    <div class="package-desc"><?= nl2br(htmlspecialchars($pkg['deskripsi'] ?? '-')) ?></div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#9ca3af;font-size:13px">Belum ada paket layanan.</p>
            <?php endif; ?>
        </div>
    </div>

</main>

</body>
</html>