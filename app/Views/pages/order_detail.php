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

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; display: flex; justify-content: space-between; align-items: center; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-body { padding: 20px; }

        .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .field-value { font-size: 14px; color: #111827; font-weight: 500; }
        .field-value.empty { color: #d1d5db; font-style: italic; font-weight: 400; }
        .field-full { grid-column: span 2; }

        .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-active    { background: #d1fae5; color: #065f46; }
        .badge-completed { background: #dbeafe; color: #1e40af; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        .progress-wrap { margin-top: 8px; }
        .progress-bar { height: 8px; background: #fff1e6; border-radius: 4px; }
        .progress-fill { height: 8px; border-radius: 4px; background: #f97316; transition: width 0.3s; }
        .progress-text { font-size: 12px; color: #9ca3af; margin-top: 4px; }

        /* Update status form */
        .status-form { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
        .status-form select { padding: 8px 12px; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 13px; background: #fff; outline: none; }
        .status-form select:focus { border-color: #f97316; }
        .btn-update { padding: 8px 18px; background: #f97316; color: #fff; border: none; border-radius: 8px; font-size: 13px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
        .btn-update:hover { background: #ea6c0a; }
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
        <a href="/studlent-admin/public/order" class="nav-item active">
            <i class="ti ti-shopping-cart"></i> Orders
        </a>
        <a href="/studlent-admin/public/service" class="nav-item">
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
            <h1>Detail Order</h1>
            <p>Informasi lengkap order</p>
        </div>
        <div class="avatar">A</div>
    </div>

    <a href="<?= BASE_URL ?>order" class="btn-back"><i class="ti ti-arrow-left"></i> Kembali ke Orders</a>

    <!-- Info Utama -->
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Informasi Order</span>
            <span class="badge badge-<?= htmlspecialchars($order['status']) ?>"><?= ucfirst(htmlspecialchars($order['status'])) ?></span>
        </div>
        <div class="panel-body">
            <div class="field-grid">
                <div>
                    <div class="field-label">ID Order</div>
                    <div class="field-value" style="font-family:monospace"><?= htmlspecialchars($order['id_order']) ?></div>
                </div>
                <div>
                    <div class="field-label">ID Service</div>
                    <div class="field-value" style="font-family:monospace"><?= htmlspecialchars($order['id_service'] ?? '-') ?></div>
                </div>
                <div>
                    <div class="field-label">ID Client</div>
                    <div class="field-value" style="font-family:monospace"><?= htmlspecialchars($order['id_client'] ?? '-') ?></div>
                </div>
                <div>
                    <div class="field-label">ID Freelancer</div>
                    <div class="field-value" style="font-family:monospace"><?= htmlspecialchars($order['id_freelancer'] ?? '-') ?></div>
                </div>
                <div>
                    <div class="field-label">ID Deal</div>
                    <div class="field-value" style="font-family:monospace"><?= htmlspecialchars($order['id_deal'] ?? '-') ?></div>
                </div>
                <div>
                    <div class="field-label">ID Package</div>
                    <div class="field-value" style="font-family:monospace"><?= htmlspecialchars($order['id_package'] ?? '-') ?></div>
                </div>
                <div>
                    <div class="field-label">Deadline</div>
                    <div class="field-value"><?= !empty($order['deadline']) ? date('d M Y', strtotime($order['deadline'])) : '-' ?></div>
                </div>
                <div>
                    <div class="field-label">Dibuat</div>
                    <div class="field-value"><?= !empty($order['created_at']) ? date('d M Y H:i', strtotime($order['created_at'])) : '-' ?></div>
                </div>
                <div class="field-full">
                    <div class="field-label">Progress</div>
                    <?php $progress = intval($order['progress'] ?? 0); ?>
                    <div class="progress-wrap">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width:<?= $progress ?>%"></div>
                        </div>
                        <div class="progress-text"><?= $progress ?>% selesai</div>
                    </div>
                </div>
                <div class="field-full">
                    <div class="field-label">Detail Pesanan</div>
                    <div class="field-value <?= empty($order['detail_pesanan']) ? 'empty' : '' ?>">
                        <?= nl2br(htmlspecialchars($order['detail_pesanan'] ?? 'Tidak ada detail')) ?>
                    </div>
                </div>
                <div class="field-full">
                    <div class="field-label">Catatan</div>
                    <div class="field-value <?= empty($order['catatan']) ? 'empty' : '' ?>">
                        <?= nl2br(htmlspecialchars($order['catatan'] ?? 'Tidak ada catatan')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status -->
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">Update Status Order</span>
        </div>
        <div class="panel-body">
            <form method="POST" action="<?= BASE_URL ?>order/updatestatus">
                <input type="hidden" name="id" value="<?= htmlspecialchars($order['id_order']) ?>">
                <div class="status-form">
                    <select name="status">
                        <option value="pending"   <?= $order['status'] === 'pending'   ? 'selected' : '' ?>>Pending</option>
                        <option value="active"    <?= $order['status'] === 'active'    ? 'selected' : '' ?>>Active</option>
                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                    <button type="submit" class="btn-update" onclick="return confirm('Update status order ini?')">
                        <i class="ti ti-refresh"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>