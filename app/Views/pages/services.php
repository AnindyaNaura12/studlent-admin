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

        .main { margin-left: 240px; padding: 28px 32px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; }
        .topbar h1 { font-size: 22px; font-weight: 600; }
        .topbar p { font-size: 13px; color: #9ca3af; margin-top: 2px; }
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #ffe0cc; position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: #f97316; }
        .stat-card.pending::before { background: #f59e0b; }
        .stat-card.active::before { background: #10b981; }
        .stat-card.inactive::before { background: #6b7280; }
        .stat-card.rejected::before { background: #ef4444; }
        .stat-icon { width: 40px; height: 40px; border-radius: 10px; background: #fff1e6; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; font-size: 20px; color: #f97316; }
        .stat-card.pending .stat-icon { background: #fef3c7; color: #f59e0b; }
        .stat-card.active .stat-icon { background: #d1fae5; color: #10b981; }
        .stat-card.inactive .stat-icon { background: #f3f4f6; color: #6b7280; }
        .stat-card.rejected .stat-icon { background: #fee2e2; color: #ef4444; }
        .stat-label { font-size: 12px; color: #9ca3af; margin-bottom: 4px; }
        .stat-value { font-size: 26px; font-weight: 700; }

        .toolbar { display: flex; gap: 12px; margin-bottom: 16px; flex-wrap: wrap; }
        .search-wrap { position: relative; flex: 1; min-width: 200px; }

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
            transition: color 0.15s ease;
        }
        .search-icon-btn:hover { color: #f97316; }

        .search-wrap input {
            width: 100%;
            padding: 9px 42px 9px 38px;
            border: 1px solid #ffe0cc;
            border-radius: 8px;
            font-size: 14px;
            background: #fff;
            outline: none;
        }
        .search-wrap input:focus { border-color: #f97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }

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
        .clear-search.show { display: flex; }
        .clear-search:hover { background: #fff1e6; color: #f97316; }

        select { padding: 9px 12px; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 14px; background: #fff; color: #374151; outline: none; cursor: pointer; }
        select:focus { border-color: #f97316; }
        .btn-filter { padding: 9px 18px; background: #f97316; color: #fff; border: none; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
        .btn-filter:hover { background: #ea6c0a; }
        .btn-reset { padding: 9px 14px; background: #fff; color: #6b7280; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 14px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 6px; }
        .btn-reset:hover { background: #f9fafb; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; display: flex; justify-content: space-between; align-items: center; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .total-badge { font-size: 12px; background: #fff1e6; color: #f97316; padding: 3px 10px; border-radius: 20px; }

        table { width: 100%; border-collapse: collapse; }
        th { font-size: 11px; text-transform: uppercase; color: #9ca3af; padding: 10px 20px; text-align: left; background: #fff7f0; }
        td { font-size: 13px; padding: 12px 20px; border-top: 1px solid #fff1e6; color: #374151; vertical-align: middle; }
        tr:hover td { background: #fff7f0; }

        .thumbnail { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; background: #fff1e6; display: flex; align-items: center; justify-content: center; color: #f97316; font-size: 20px; flex-shrink: 0; }
        .thumbnail img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
        .service-info { display: flex; align-items: center; gap: 12px; }
        .service-title { font-weight: 500; color: #111827; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

        .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-active { background: #d1fae5; color: #065f46; }
        .badge-inactive { background: #f3f4f6; color: #6b7280; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .rating { display: flex; align-items: center; gap: 4px; font-size: 13px; color: #f59e0b; font-weight: 600; }

        .action-wrap { display: flex; gap: 6px; }
        .btn-detail { padding: 5px 12px; background: #fff1e6; color: #f97316; border: 1px solid #fed7aa; border-radius: 6px; font-size: 12px; text-decoration: none; display: flex; align-items: center; gap: 4px; }
        .btn-detail:hover { background: #fed7aa; }
        .btn-approve { padding: 5px 12px; background: #d1fae5; color: #059669; border: 1px solid #a7f3d0; border-radius: 6px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 4px; }
        .btn-approve:hover { background: #a7f3d0; }
        .btn-reject { padding: 5px 12px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 6px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 4px; }
        .btn-reject:hover { background: #fecaca; }

        .empty-state { text-align: center; padding: 48px 20px; color: #9ca3af; }
        .empty-state i { font-size: 40px; display: block; margin-bottom: 10px; }
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
        <a href="<?= BASE_URL ?>service" class="nav-item active"><i class="ti ti-briefcase"></i> Services</a>
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
            <h1>Services</h1>
            <p>Kelola semua layanan freelancer Studlent</p>
        </div>
        <a href="<?= BASE_URL ?>profile" style="text-decoration:none">
            <div class="avatar" title="Profile Admin">A</div>
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card pending">
            <div class="stat-icon"><i class="ti ti-clock"></i></div>
            <div class="stat-label">Pending Review</div>
            <div class="stat-value"><?= number_format($statusCounts['pending'] ?? 0) ?></div>
        </div>
        <div class="stat-card active">
            <div class="stat-icon"><i class="ti ti-circle-check"></i></div>
            <div class="stat-label">Active</div>
            <div class="stat-value"><?= number_format($statusCounts['active'] ?? 0) ?></div>
        </div>
        <div class="stat-card inactive">
            <div class="stat-icon"><i class="ti ti-eye-off"></i></div>
            <div class="stat-label">Inactive</div>
            <div class="stat-value"><?= number_format($statusCounts['inactive'] ?? 0) ?></div>
        </div>
        <div class="stat-card rejected">
            <div class="stat-icon"><i class="ti ti-circle-x"></i></div>
            <div class="stat-label">Rejected</div>
            <div class="stat-value"><?= number_format($statusCounts['rejected'] ?? 0) ?></div>
        </div>
    </div>

    <form method="GET" action="<?= BASE_URL ?>service" id="filterForm">
        <div class="toolbar">
            <div class="search-wrap">
                <button type="submit" class="search-icon-btn" aria-label="Cari">
                    <i class="ti ti-search"></i>
                </button>
                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    placeholder="Cari judul service..."
                    value="<?= htmlspecialchars($search) ?>"
                    autocomplete="off"
                >
                <button type="button" id="clearSearchBtn" class="clear-search" aria-label="Hapus pencarian">
                    <i class="ti ti-x"></i>
                </button>
            </div>

            <select name="category">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id_category']) ?>" <?= $category === $cat['id_category'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="status">
                <option value="">Semua Status</option>
                <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                <option value="rejected" <?= $status === 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>

            <button type="submit" class="btn-filter"><i class="ti ti-filter"></i> Filter</button>
            <a href="<?= BASE_URL ?>service" class="btn-reset"><i class="ti ti-x"></i> Reset</a>
        </div>
    </form>

    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Daftar Services</span>
            <span class="total-badge"><?= count($services) ?> service</span>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>ID Freelancer</th>
                    <th>Rating</th>
                    <th>Total Order</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $svc): ?>
                    <tr>
                        <td>
                            <div class="service-info">
                                <div class="thumbnail">
                                    <?php if (!empty($svc['thumbnail_url'])): ?>
                                        <img src="<?= htmlspecialchars($svc['thumbnail_url']) ?>" alt="">
                                    <?php else: ?>
                                        <i class="ti ti-briefcase"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="service-title"><?= htmlspecialchars($svc['judul'] ?? '-') ?></div>
                            </div>
                        </td>
                        <td style="font-family:monospace;font-size:12px"><?= htmlspecialchars(substr($svc['id_freelancer'] ?? '-', 0, 8)) ?></td>
                        <td>
                            <div class="rating">
                                <i class="ti ti-star-filled" style="font-size:14px"></i>
                                <?= number_format($svc['rating_avg'] ?? 0, 1) ?>
                            </div>
                        </td>
                        <td><?= number_format($svc['total_order'] ?? 0) ?></td>
                        <td><span class="badge badge-<?= htmlspecialchars($svc['status']) ?>"><?= ucfirst(htmlspecialchars($svc['status'])) ?></span></td>
                        <td><?= !empty($svc['created_at']) ? date('d M Y', strtotime($svc['created_at'])) : '-' ?></td>
                        <td>
                            <div class="action-wrap">
                                <a href="<?= BASE_URL ?>service/detail?id=<?= urlencode($svc['id_service']) ?>" class="btn-detail">
                                    <i class="ti ti-eye"></i> Detail
                                </a>
                                <?php if ($svc['status'] === 'pending'): ?>
                                    <form method="POST" action="<?= BASE_URL ?>service/updatestatus" style="margin:0;display:flex;gap:6px">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($svc['id_service']) ?>">
                                        <button type="submit" name="status" value="active" class="btn-approve" onclick="return confirm('Approve service ini?')">
                                            <i class="ti ti-check"></i> Approve
                                        </button>
                                        <button type="submit" name="status" value="rejected" class="btn-reject" onclick="return confirm('Reject service ini?')">
                                            <i class="ti ti-x"></i> Reject
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="ti ti-briefcase-off"></i>
                                Tidak ada service ditemukan
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
</html>