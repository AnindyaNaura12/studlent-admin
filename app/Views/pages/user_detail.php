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

        .detail-grid { display: grid; grid-template-columns: 300px 1fr; gap: 20px; }

        /* Profile Card */
        .profile-card { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; padding: 28px 20px; text-align: center; }
        .profile-avatar { width: 90px; height: 90px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 32px; font-weight: 700; margin: 0 auto 16px; overflow: hidden; }
        .profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .profile-name { font-size: 18px; font-weight: 600; margin-bottom: 4px; }
        .profile-username { font-size: 13px; color: #9ca3af; margin-bottom: 12px; }
        .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-client     { background: #dbeafe; color: #1e40af; }
        .badge-freelancer { background: #d1fae5; color: #065f46; }
        .badge-admin      { background: #fae8ff; color: #7e22ce; }
        .badge-active     { background: #d1fae5; color: #065f46; }
        .badge-inactive   { background: #fee2e2; color: #991b1b; }

        .profile-divider { border: none; border-top: 1px solid #fff1e6; margin: 16px 0; }
        .profile-meta { text-align: left; }
        .meta-row { display: flex; align-items: flex-start; gap: 10px; padding: 8px 0; border-bottom: 1px solid #fff7f0; font-size: 13px; }
        .meta-row:last-child { border-bottom: none; }
        .meta-row i { color: #f97316; font-size: 16px; margin-top: 1px; flex-shrink: 0; }
        .meta-label { color: #9ca3af; font-size: 11px; }
        .meta-value { color: #374151; }

        /* Info Panel */
        .info-panel { display: flex; flex-direction: column; gap: 20px; }
        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-body { padding: 20px; }
        .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field { }
        .field-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .field-value { font-size: 14px; color: #111827; font-weight: 500; }
        .field-value.empty { color: #d1d5db; font-style: italic; font-weight: 400; }

        .freelancer-foto { width: 100%; max-height: 200px; object-fit: cover; border-radius: 8px; margin-top: 8px; }
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
        <a href="/studlent-admin/public/dashboard" class="nav-item"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
        <a href="/studlent-admin/public/user" class="nav-item active"><i class="ti ti-users"></i> Users</a>
        <a href="/studlent-admin/public/order" class="nav-item"><i class="ti ti-shopping-cart"></i> Orders</a>
        <a href="/studlent-admin/public/service" class="nav-item"><i class="ti ti-briefcase"></i> Services</a>
        <a href="/studlent-admin/public/withdrawals" class="nav-item"><i class="ti ti-cash"></i> Withdrawals</a>
        <div class="nav-label" style="margin-top:12px">Keuangan</div>
        <a href="/studlent-admin/public/payments" class="nav-item"><i class="ti ti-credit-card"></i> Payments</a>
        <a href="/studlent-admin/public/escrow" class="nav-item"><i class="ti ti-safe"></i> Escrow</a>
    </nav>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Detail User</h1>
            <p>Informasi lengkap pengguna</p>
        </div>
        <div class="avatar">A</div>
    </div>

    <a href="/user" class="btn-back"><i class="ti ti-arrow-left"></i> Kembali ke Users</a>

    <div class="detail-grid">

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-avatar">
                <?php if (!empty($user['foto'])): ?>
                    <img src="<?= htmlspecialchars($user['foto']) ?>" alt="">
                <?php else: ?>
                    <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?>
                <?php endif; ?>
            </div>
            <div class="profile-name"><?= htmlspecialchars($user['nama'] ?? '-') ?></div>
            <div class="profile-username">@<?= htmlspecialchars($user['username'] ?? '-') ?></div>
            <span class="badge badge-<?= htmlspecialchars($user['role'] ?? '') ?>"><?= ucfirst($user['role'] ?? '-') ?></span>
            &nbsp;
            <span class="badge <?= $user['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                <?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>
            </span>

            <hr class="profile-divider">

            <div class="profile-meta">
                <div class="meta-row">
                    <i class="ti ti-mail"></i>
                    <div>
                        <div class="meta-label">Email</div>
                        <div class="meta-value"><?= htmlspecialchars($user['email'] ?? '-') ?></div>
                    </div>
                </div>
                <div class="meta-row">
                    <i class="ti ti-phone"></i>
                    <div>
                        <div class="meta-label">No. HP</div>
                        <div class="meta-value"><?= htmlspecialchars($user['no_hp'] ?? '-') ?></div>
                    </div>
                </div>
                <div class="meta-row">
                    <i class="ti ti-calendar"></i>
                    <div>
                        <div class="meta-label">Bergabung</div>
                        <div class="meta-value"><?= !empty($user['joined_at']) ? date('d M Y', strtotime($user['joined_at'])) : '-' ?></div>
                    </div>
                </div>
            </div>

            <!-- Toggle Active -->
            <form method="POST" action="/user/toggle" style="margin-top:20px">
                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id_user']) ?>">
                <input type="hidden" name="status" value="<?= $user['is_active'] ? '1' : '0' ?>">
                <?php if ($user['is_active']): ?>
                    <button type="submit" style="width:100%;padding:9px;background:#fee2e2;color:#dc2626;border:1px solid #fecaca;border-radius:8px;font-size:13px;cursor:pointer" onclick="return confirm('Nonaktifkan user ini?')">
                        <i class="ti ti-user-off"></i> Nonaktifkan User
                    </button>
                <?php else: ?>
                    <button type="submit" style="width:100%;padding:9px;background:#d1fae5;color:#059669;border:1px solid #a7f3d0;border-radius:8px;font-size:13px;cursor:pointer" onclick="return confirm('Aktifkan user ini?')">
                        <i class="ti ti-user-check"></i> Aktifkan User
                    </button>
                <?php endif; ?>
            </form>
        </div>

        <!-- Info Panels -->
        <div class="info-panel">

            <!-- Info Umum -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Informasi Umum</div>
                </div>
                <div class="panel-body">
                    <div class="field-grid">
                        <div class="field">
                            <div class="field-label">Nama Lengkap</div>
                            <div class="field-value"><?= htmlspecialchars($user['nama'] ?? '-') ?></div>
                        </div>
                        <div class="field">
                            <div class="field-label">Username</div>
                            <div class="field-value"><?= htmlspecialchars($user['username'] ?? '-') ?></div>
                        </div>
                        <div class="field">
                            <div class="field-label">Product Interest</div>
                            <div class="field-value <?= empty($user['product_interest']) ? 'empty' : '' ?>">
                                <?= htmlspecialchars($user['product_interest'] ?? 'Belum diisi') ?>
                            </div>
                        </div>
                        <div class="field">
                            <div class="field-label">Professional Status</div>
                            <div class="field-value <?= empty($user['professional_status']) ? 'empty' : '' ?>">
                                <?= htmlspecialchars($user['professional_status'] ?? 'Belum diisi') ?>
                            </div>
                        </div>
                        <div class="field">
                            <div class="field-label">Dibuat</div>
                            <div class="field-value"><?= !empty($user['created_at']) ? date('d M Y H:i', strtotime($user['created_at'])) : '-' ?></div>
                        </div>
                        <div class="field">
                            <div class="field-label">Diperbarui</div>
                            <div class="field-value"><?= !empty($user['updated_at']) ? date('d M Y H:i', strtotime($user['updated_at'])) : '-' ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Foto Freelancer (hanya tampil jika role freelancer) -->
            <?php if (($user['role'] ?? '') === 'freelancer'): ?>
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Foto Freelancer</div>
                </div>
                <div class="panel-body">
                    <?php if (!empty($user['foto_freelancer'])): ?>
                        <img src="<?= htmlspecialchars($user['foto_freelancer']) ?>" class="freelancer-foto" alt="Foto Freelancer">
                    <?php else: ?>
                        <p style="color:#9ca3af;font-size:13px">Belum ada foto freelancer.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</main>

</body>
</html>