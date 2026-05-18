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
        .sidebar-footer { padding: 16px 12px; border-top: 1px solid #ffe0cc; }
        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; font-size: 14px; color: #ef4444; text-decoration: none; transition: all 0.15s; width: 100%; background: none; border: none; cursor: pointer; }
        .logout-btn:hover { background: #fee2e2; }
    
         /* Main */

        .main { margin-left: 240px; padding: 28px 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .topbar h1 { font-size: 22px; font-weight: 600; }
        .topbar p { font-size: 13px; color: #9ca3af; margin-top: 2px; }

        /* Avatar topbar */
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; overflow: hidden; flex-shrink: 0; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .admin-name { font-size: 13px; font-weight: 500; color: #374151; }

        .detail-grid { display: grid; grid-template-columns: 280px 1fr; gap: 24px; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-body { padding: 24px; }

        /* Profile card kiri */
        .profile-card { text-align: center; }
        .profile-foto-wrap { position: relative; width: 100px; height: 100px; margin: 0 auto 16px; }
        .profile-foto { width: 100px; height: 100px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 36px; font-weight: 700; overflow: hidden; border: 3px solid #fff1e6; }
        .profile-foto img { width: 100%; height: 100%; object-fit: cover; }
        .foto-edit-btn { position: absolute; bottom: 0; right: 0; width: 30px; height: 30px; background: #f97316; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; cursor: pointer; border: 2px solid #fff; }
        .profile-name { font-size: 18px; font-weight: 600; margin-bottom: 4px; }
        .profile-email { font-size: 13px; color: #9ca3af; margin-bottom: 12px; }
        .profile-badge { display: inline-block; font-size: 11px; padding: 3px 12px; border-radius: 20px; background: #fff1e6; color: #f97316; font-weight: 500; }
        .profile-joined { font-size: 12px; color: #9ca3af; margin-top: 12px; }

        /* Form */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 17px; pointer-events: none; }
        .input-wrap input { width: 100%; padding: 10px 12px 10px 38px; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 14px; background: #fafafa; color: #111827; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
        .input-wrap input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); background: #fff; }
        .input-wrap input[type="file"] { padding: 8px 12px 8px 38px; cursor: pointer; }

        .btn-save { padding: 10px 24px; background: #f97316; color: #fff; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
        .btn-save:hover { background: #ea6c0a; }

        .divider { border: none; border-top: 1px solid #fff1e6; margin: 24px 0; }

        /* Alert */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; font-size: 14px; color: #ef4444; text-decoration: none; transition: all 0.15s; width: 100%; background: none; border: none; cursor: pointer; }
        .logout-btn:hover { background: #fee2e2; }
        .logout-btn i { font-size: 18px; }
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
        <a href="<?= BASE_URL ?>dashboard" class="nav-item"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
        <a href="<?= BASE_URL ?>user" class="nav-item"><i class="ti ti-users"></i> Users</a>
        <a href="<?= BASE_URL ?>order" class="nav-item"><i class="ti ti-shopping-cart"></i> Orders</a>
        <a href="<?= BASE_URL ?>service" class="nav-item"><i class="ti ti-briefcase"></i> Services</a>
        <a href="<?= BASE_URL ?>withdrawal" class="nav-item"><i class="ti ti-cash"></i> Withdrawals</a>
        <div class="nav-label" style="margin-top:12px">Keuangan</div>
        <a href="<?= BASE_URL ?>payment" class="nav-item"><i class="ti ti-credit-card"></i> Payments</a>
        <a href="<?= BASE_URL ?>escrow" class="nav-item"><i class="ti ti-safe"></i> Escrow</a>
        <div class="nav-label" style="margin-top:12px">Akun</div>
        <a href="<?= BASE_URL ?>profile" class="nav-item active"><i class="ti ti-user-circle"></i> Profile</a>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>auth/logout" class="logout-btn">
            <i class="ti ti-logout"></i> Logout
        </a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <div>
            <h1>Profile Admin</h1>
            <p>Kelola informasi akun kamu</p>
        </div>
        <div class="topbar-right">
            <div class="avatar">
                <?php if (!empty($admin['foto'])): ?>
                    <img src="<?= htmlspecialchars($admin['foto']) ?>" alt="">
                <?php else: ?>
                    <?= strtoupper(substr($admin['nama'] ?? 'A', 0, 1)) ?>
                <?php endif; ?>
            </div>
            <span class="admin-name"><?= htmlspecialchars($admin['nama'] ?? 'Admin') ?></span>
        </div>
    </div>

    <!-- Alert -->
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><i class="ti ti-circle-check"></i> <?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><i class="ti ti-alert-circle"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="detail-grid">

        <!-- Kiri: Profile Card -->
        <div>
            <div class="panel">
                <div class="panel-body profile-card">
                    <div class="profile-foto-wrap">
                        <div class="profile-foto">
                            <?php if (!empty($admin['foto'])): ?>
                                <img src="<?= htmlspecialchars($admin['foto']) ?>" alt="">
                            <?php else: ?>
                                <?= strtoupper(substr($admin['nama'] ?? 'A', 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                        <label for="foto_trigger" class="foto-edit-btn" title="Ganti foto">
                            <i class="ti ti-camera"></i>
                        </label>
                    </div>
                    <div class="profile-name"><?= htmlspecialchars($admin['nama'] ?? '-') ?></div>
                    <div class="profile-email"><?= htmlspecialchars($admin['email'] ?? '-') ?></div>
                    <span class="profile-badge">Administrator</span>
                    <div class="profile-joined">
                        Bergabung <?= !empty($admin['created_at']) ? date('d M Y', strtotime($admin['created_at'])) : '-' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan: Form -->
        <div>

            <!-- Edit Profile -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Edit Profile</div>
                </div>
                <div class="panel-body">
                    <form method="POST" action="<?= BASE_URL ?>profile/update" enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <div class="input-wrap">
                                <i class="ti ti-user"></i>
                                <input type="text" name="nama" value="<?= htmlspecialchars($admin['nama'] ?? '') ?>" placeholder="Nama lengkap" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <div class="input-wrap">
                                <i class="ti ti-mail"></i>
                                <input type="email" name="email" value="<?= htmlspecialchars($admin['email'] ?? '') ?>" placeholder="Email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Foto Profil <span style="color:#9ca3af;font-weight:400">(maks. 2MB, JPG/PNG/WebP)</span></label>
                            <div class="input-wrap">
                                <i class="ti ti-photo"></i>
                                <input type="file" name="foto" id="foto_trigger" accept="image/jpeg,image/png,image/webp">
                            </div>
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                        </button>
                    </form>

                    <hr class="divider">

                    <!-- Ganti Password -->
                    <div style="font-size:14px;font-weight:600;margin-bottom:16px">Ganti Password</div>
                    <form method="POST" action="<?= BASE_URL ?>profile/password">

                        <div class="form-group">
                            <label>Password Lama</label>
                            <div class="input-wrap">
                                <i class="ti ti-lock"></i>
                                <input type="password" name="current_password" placeholder="Masukkan password lama" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password Baru</label>
                            <div class="input-wrap">
                                <i class="ti ti-lock-plus"></i>
                                <input type="password" name="new_password" placeholder="Minimal 8 karakter" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <div class="input-wrap">
                                <i class="ti ti-lock-check"></i>
                                <input type="password" name="confirm_password" placeholder="Ulangi password baru" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="ti ti-key"></i> Ubah Password
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>

</body>
</html>