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

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background: #fff;
            border-right: 1px solid #ffe0cc;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #ffe0cc;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: #f97316;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-box svg { width: 22px; height: 22px; }
        .logo-text { font-size: 18px; font-weight: 600; color: #f97316; }
        .logo-sub { font-size: 11px; color: #9ca3af; margin-top: -2px; }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
        }

        .nav-label {
            font-size: 10px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 8px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
            color: #6b7280;
            text-decoration: none;
            margin-bottom: 2px;
            transition: all 0.15s;
        }

        .nav-item:hover {
            background: #fff1e6;
            color: #f97316;
        }

        .nav-item.active {
            background: #fff1e6;
            color: #f97316;
            font-weight: 600;
        }

        .nav-item i { font-size: 18px; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid #ffe0cc;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
            color: #ef4444;
            text-decoration: none;
            transition: all 0.15s;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover { background: #fee2e2; }

        .main {
            margin-left: 240px;
            padding: 28px 32px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .topbar h1 { font-size: 22px; font-weight: 600; }
        .topbar p { font-size: 13px; color: #9ca3af; margin-top: 2px; }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #f97316;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #ffe0cc;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #f97316;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #fff1e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 20px;
            color: #f97316;
        }

        .stat-label { font-size: 12px; color: #9ca3af; margin-bottom: 4px; }
        .stat-value { font-size: 26px; font-weight: 700; }

        .toolbar {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .search-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-icon-btn {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            border: none;
            background: transparent;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            z-index: 2;
            transition: all 0.15s ease;
        }

        .search-icon-btn:hover {
            color: #f97316;
        }

        .search-wrap input {
            width: 100%;
            padding: 9px 42px 9px 38px;
            border: 1px solid #ffe0cc;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            outline: none;
        }

        .search-wrap input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.1);
        }

        .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            border: none;
            background: #f3f4f6;
            color: #6b7280;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            padding: 0;
            transition: all 0.15s ease;
        }

        .clear-search.show {
            display: flex;
        }

        .clear-search:hover {
            background: #fff1e6;
            color: #f97316;
        }

        select {
            padding: 9px 12px;
            border: 1px solid #ffe0cc;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            color: #374151;
            outline: none;
            cursor: pointer;
        }

        select:focus { border-color: #f97316; }

        .btn-filter {
            padding: 9px 18px;
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-filter:hover { background: #ea6c0a; }

        .btn-reset {
            padding: 9px 14px;
            background: #fff;
            color: #6b7280;
            border: 1px solid #ffe0cc;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-reset:hover { background: #f9fafb; }

        .panel {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #ffe0cc;
            overflow: hidden;
        }

        .panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid #ffe0cc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title { font-size: 14px; font-weight: 600; }

        .total-badge {
            font-size: 12px;
            background: #fff1e6;
            color: #f97316;
            padding: 3px 10px;
            border-radius: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            font-size: 11px;
            text-transform: uppercase;
            color: #9ca3af;
            padding: 10px 20px;
            text-align: left;
            background: #fff7f0;
        }

        td {
            font-size: 13px;
            padding: 12px 20px;
            border-top: 1px solid #fff1e6;
            color: #374151;
            vertical-align: middle;
        }

        tr:hover td { background: #fff7f0; }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f97316;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 13px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name { font-weight: 500; color: #111827; }
        .user-username { font-size: 12px; color: #9ca3af; }

        .badge {
            display: inline-block;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge-client     { background: #dbeafe; color: #1e40af; }
        .badge-freelancer { background: #d1fae5; color: #065f46; }
        .badge-admin      { background: #fae8ff; color: #7e22ce; }
        .badge-active     { background: #d1fae5; color: #065f46; }
        .badge-inactive   { background: #fee2e2; color: #991b1b; }

        .action-wrap { display: flex; gap: 6px; }

        .btn-detail {
            padding: 5px 12px;
            background: #fff1e6;
            color: #f97316;
            border: 1px solid #fed7aa;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-detail:hover { background: #fed7aa; }

        .btn-toggle-on {
            padding: 5px 12px;
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-toggle-off {
            padding: 5px 12px;
            background: #d1fae5;
            color: #059669;
            border: 1px solid #a7f3d0;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-toggle-on:hover { background: #fecaca; }
        .btn-toggle-off:hover { background: #a7f3d0; }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 40px;
            display: block;
            margin-bottom: 10px;
        }
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
        <a href="<?= BASE_URL ?>user" class="nav-item active"><i class="ti ti-users"></i> Users</a>
        <a href="<?= BASE_URL ?>order" class="nav-item"><i class="ti ti-shopping-cart"></i> Orders</a>
        <a href="<?= BASE_URL ?>service" class="nav-item"><i class="ti ti-briefcase"></i> Services</a>
        <a href="<?= BASE_URL ?>withdrawal" class="nav-item"><i class="ti ti-cash"></i> Withdrawals</a>
        <div class="nav-label" style="margin-top:12px">Keuangan</div>
        <a href="<?= BASE_URL ?>payment" class="nav-item"><i class="ti ti-credit-card"></i> Payments</a>
        <a href="<?= BASE_URL ?>escrow" class="nav-item"><i class="ti ti-safe"></i> Escrow</a>
        <div class="nav-label" style="margin-top:12px">Akun</div>
        <a href="<?= BASE_URL ?>profile" class="nav-item"><i class="ti ti-user-circle"></i> Profile</a>
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
            <h1>Users</h1>
            <p>Kelola semua pengguna Studlent</p>
        </div>
        <a href="<?= BASE_URL ?>profile" style="text-decoration:none">
            <div class="avatar" title="Profile Admin">A</div>
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-user"></i></div>
            <div class="stat-label">Client</div>
            <div class="stat-value"><?= number_format($roleCounts['client'] ?? 0) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-tool"></i></div>
            <div class="stat-label">Freelancer</div>
            <div class="stat-value"><?= number_format($roleCounts['freelancer'] ?? 0) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-shield"></i></div>
            <div class="stat-label">Admin</div>
            <div class="stat-value"><?= number_format($roleCounts['admin'] ?? 0) ?></div>
        </div>
    </div>

    <form method="GET" action="<?= BASE_URL ?>user" id="filterForm">
        <div class="toolbar">
            <div class="search-wrap">
                <button type="submit" class="search-icon-btn" aria-label="Cari">
                    <i class="ti ti-search"></i>
                </button>

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    placeholder="Cari nama, email, username..."
                    value="<?= htmlspecialchars($search) ?>"
                    autocomplete="off"
                >

                <button type="button" id="clearSearchBtn" class="clear-search" aria-label="Hapus pencarian">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <select name="role">
                <option value="">Semua Role</option>
                <option value="client" <?= $role === 'client' ? 'selected' : '' ?>>Client</option>
                <option value="freelancer" <?= $role === 'freelancer' ? 'selected' : '' ?>>Freelancer</option>
                <option value="admin" <?= $role === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>

            <select name="status">
                <option value="">Semua Status</option>
                <option value="true" <?= $status === 'true' ? 'selected' : '' ?>>Aktif</option>
                <option value="false" <?= $status === 'false' ? 'selected' : '' ?>>Nonaktif</option>
            </select>

            <button type="submit" class="btn-filter">
                <i class="ti ti-filter"></i> Filter
            </button>

            <a href="<?= BASE_URL ?>user" class="btn-reset">
                <i class="ti ti-x"></i> Reset
            </a>
        </div>
    </form>

    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Daftar Users</span>
            <span class="total-badge"><?= count($users) ?> user</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <?php if (!empty($user['foto'])): ?>
                                        <img src="<?= htmlspecialchars($user['foto']) ?>" alt="">
                                    <?php else: ?>
                                        <?= strtoupper(substr($user['nama'] ?? 'U', 0, 1)) ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="user-name"><?= htmlspecialchars($user['nama'] ?? '-') ?></div>
                                    <div class="user-username">@<?= htmlspecialchars($user['username'] ?? '-') ?></div>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($user['no_hp'] ?? '-') ?></td>
                        <td>
                            <span class="badge badge-<?= htmlspecialchars($user['role'] ?? '') ?>">
                                <?= ucfirst(htmlspecialchars($user['role'] ?? '-')) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($user['is_active']): ?>
                                <span class="badge badge-active">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-inactive">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td><?= !empty($user['joined_at']) ? date('d M Y', strtotime($user['joined_at'])) : '-' ?></td>
                        <td>
                            <div class="action-wrap">
                                <a href="<?= BASE_URL ?>user/detail?id=<?= urlencode($user['id_user']) ?>" class="btn-detail">
                                    <i class="ti ti-eye"></i> Detail
                                </a>

                                <form method="POST" action="<?= BASE_URL ?>user/toggle" style="margin:0">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id_user']) ?>">
                                    <input type="hidden" name="status" value="<?= $user['is_active'] ? '1' : '0' ?>">

                                    <?php if ($user['is_active']): ?>
                                        <button type="submit" class="btn-toggle-on" onclick="return confirm('Nonaktifkan user ini?')">
                                            <i class="ti ti-user-off"></i> Nonaktifkan
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn-toggle-off" onclick="return confirm('Aktifkan user ini?')">
                                            <i class="ti ti-user-check"></i> Aktifkan
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="ti ti-users-off"></i>
                                Tidak ada user ditemukan
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const filterForm = document.getElementById('filterForm');

    function toggleClearButton() {
        if (searchInput.value.trim() !== '' || document.activeElement === searchInput) {
            clearSearchBtn.classList.add('show');
        } else {
            clearSearchBtn.classList.remove('show');
        }
    }

    searchInput.addEventListener('input', toggleClearButton);
    searchInput.addEventListener('focus', toggleClearButton);
    searchInput.addEventListener('blur', function () {
        setTimeout(toggleClearButton, 100);
    });

    clearSearchBtn.addEventListener('click', function () {
        searchInput.value = '';
        filterForm.submit();
    });

    toggleClearButton();
</script>

</body>
</html>s