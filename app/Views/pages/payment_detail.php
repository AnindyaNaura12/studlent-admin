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

        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #fff; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 13px; color: #6b7280; text-decoration: none; margin-bottom: 20px; }
        .btn-back:hover { background: #fff1e6; color: #f97316; }

        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; display: flex; justify-content: space-between; align-items: center; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-body { padding: 20px; }

        .amount-display { text-align: center; padding: 24px; background: #fff7f0; border-radius: 10px; margin-bottom: 20px; }
        .amount-label { font-size: 12px; color: #9ca3af; margin-bottom: 6px; }
        .amount-value { font-size: 36px; font-weight: 700; color: #f97316; }

        .info-list { display: flex; flex-direction: column; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 11px 0; border-bottom: 1px solid #fff1e6; font-size: 13px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #9ca3af; }
        .info-value { font-weight: 500; color: #111827; text-align: right; max-width: 60%; word-break: break-all; }

        .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-paid     { background: #d1fae5; color: #065f46; }
        .badge-failed   { background: #fee2e2; color: #991b1b; }
        .badge-expired  { background: #f3f4f6; color: #6b7280; }
        .badge-held     { background: #fef3c7; color: #92400e; }
        .badge-released { background: #d1fae5; color: #065f46; }
        .badge-refunded { background: #fee2e2; color: #991b1b; }

        /* Fee breakdown */
        .fee-breakdown { background: #fff7f0; border-radius: 10px; padding: 16px; }
        .fee-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ffe0cc; font-size: 13px; }
        .fee-row:last-child { border-bottom: none; font-weight: 700; font-size: 14px; }
        .fee-row.total { color: #f97316; margin-top: 4px; padding-top: 12px; }

        .payment-url { word-break: break-all; font-size: 12px; color: #6b7280; background: #f9fafb; padding: 8px 12px; border-radius: 6px; border: 1px solid #e5e7eb; }
        .payment-url a { color: #f97316; text-decoration: none; }
        .payment-url a:hover { text-decoration: underline; }
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
        <a href="<?= BASE_URL ?>payment" class="nav-item active"><i class="ti ti-credit-card"></i> Payments</a>
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
            <h1>Detail Payment</h1>
            <p>Informasi lengkap transaksi pembayaran</p>
        </div>
        <a href="<?= BASE_URL ?>profile" style="text-decoration:none">
            <div class="avatar" title="Profile Admin">A</div>
        </a>
    </div>

    <a href="<?= BASE_URL ?>payment" class="btn-back"><i class="ti ti-arrow-left"></i> Kembali ke Payments</a>

    <div class="detail-grid">

        <!-- Kiri -->
        <div>
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Informasi Transaksi</span>
                    <span class="badge badge-<?= htmlspecialchars($payment['status']) ?>"><?= ucfirst(htmlspecialchars($payment['status'])) ?></span>
                </div>
                <div class="panel-body">
                    <div class="amount-display">
                        <div class="amount-label">Total Pembayaran</div>
                        <div class="amount-value">Rp <?= number_format($payment['amount'] ?? 0, 0, ',', '.') ?></div>
                    </div>
                    <div class="info-list">
                        <div class="info-row">
                            <span class="info-label">ID Payment</span>
                            <span class="info-value" style="font-family:monospace;font-size:11px"><?= htmlspecialchars($payment['id_payment']) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">ID Order</span>
                            <span class="info-value" style="font-family:monospace;font-size:11px"><?= htmlspecialchars($payment['id_order'] ?? '-') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Metode</span>
                            <span class="info-value"><?= htmlspecialchars(strtoupper($payment['metode'] ?? '-')) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Gateway TRX ID</span>
                            <span class="info-value" style="font-family:monospace;font-size:11px"><?= htmlspecialchars($payment['gateway_trx_id'] ?? '-') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Escrow Status</span>
                            <span class="info-value"><span class="badge badge-<?= htmlspecialchars($payment['escrow_status'] ?? 'held') ?>"><?= ucfirst(htmlspecialchars($payment['escrow_status'] ?? '-')) ?></span></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal Bayar</span>
                            <span class="info-value"><?= !empty($payment['tanggal_bayar']) ? date('d M Y H:i', strtotime($payment['tanggal_bayar'])) : '-' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dibuat</span>
                            <span class="info-value"><?= !empty($payment['created_at']) ? date('d M Y H:i', strtotime($payment['created_at'])) : '-' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Diperbarui</span>
                            <span class="info-value"><?= !empty($payment['updated_at']) ? date('d M Y H:i', strtotime($payment['updated_at'])) : '-' ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment URL -->
            <?php if (!empty($payment['payment_url'])): ?>
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Payment URL</span>
                </div>
                <div class="panel-body">
                    <div class="payment-url">
                        <a href="<?= htmlspecialchars($payment['payment_url']) ?>" target="_blank">
                            <?= htmlspecialchars($payment['payment_url']) ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Kanan: Fee Breakdown -->
        <div>
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Rincian Keuangan</span>
                </div>
                <div class="panel-body">
                    <div class="fee-breakdown">
                        <div class="fee-row">
                            <span>Total Pembayaran</span>
                            <span>Rp <?= number_format($payment['amount'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                        <div class="fee-row">
                            <span>Admin Fee</span>
                            <span style="color:#ef4444">- Rp <?= number_format($payment['admin_fee'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                        <div class="fee-row">
                            <span>Platform Fee (<?= number_format($payment['fee_percent'] ?? 0, 1) ?>%)</span>
                            <span style="color:#ef4444">- Rp <?= number_format($payment['platform_fee'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                        <div class="fee-row total">
                            <span>Freelancer Menerima</span>
                            <span>Rp <?= number_format($payment['freelancer_receive'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

</body>
</html>