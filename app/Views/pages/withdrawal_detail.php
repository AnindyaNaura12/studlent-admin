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
        .avatar { width: 38px; height: 38px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; }

        .btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; background: #fff; border: 1px solid #ffe0cc; border-radius: 8px; font-size: 13px; color: #6b7280; text-decoration: none; margin-bottom: 20px; }
        .btn-back:hover { background: #fff1e6; color: #f97316; }

        .detail-wrap { max-width: 600px; }

        .panel { background: #fff; border-radius: 12px; border: 1px solid #ffe0cc; overflow: hidden; margin-bottom: 20px; }
        .panel-header { padding: 16px 20px; border-bottom: 1px solid #ffe0cc; display: flex; justify-content: space-between; align-items: center; }
        .panel-title { font-size: 14px; font-weight: 600; }
        .panel-body { padding: 20px; }

        .amount-display { text-align: center; padding: 24px; background: #fff7f0; border-radius: 10px; margin-bottom: 20px; }
        .amount-label { font-size: 12px; color: #9ca3af; margin-bottom: 6px; }
        .amount-value { font-size: 36px; font-weight: 700; color: #f97316; }

        .info-list { display: flex; flex-direction: column; gap: 0; }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #fff1e6; font-size: 14px; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #9ca3af; }
        .info-value { font-weight: 500; color: #111827; }

        .badge { display: inline-block; font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 500; }
        .badge-pending  { background: #fef3c7; color: #92400e; }
        .badge-approved { background: #d1fae5; color: #065f46; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        .status-form { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn-approve { padding: 10px 24px; background: #d1fae5; color: #059669; border: 1px solid #a7f3d0; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 600; }
        .btn-approve:hover { background: #a7f3d0; }
        .btn-reject { padding: 10px 24px; background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; font-size: 14px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-weight: 600; }
        .btn-reject:hover { background: #fecaca; }

        .status-done { padding: 12px 16px; background: #f3f4f6; border-radius: 8px; font-size: 13px; color: #6b7280; display: flex; align-items: center; gap: 8px; }
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
        <a href="<?= BASE_URL ?>withdrawal" class="nav-item active"><i class="ti ti-cash"></i> Withdrawals</a>
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
            <h1>Detail Withdrawal</h1>
            <p>Informasi lengkap permintaan penarikan dana</p>
        </div>
        <a href="<?= BASE_URL ?>profile" style="text-decoration:none">
            <div class="avatar" title="Profile Admin">A</div>
        </a>
    </div>

    <a href="<?= BASE_URL ?>withdrawal" class="btn-back"><i class="ti ti-arrow-left"></i> Kembali ke Withdrawals</a>

    <div class="detail-wrap">

        <!-- Amount -->
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Jumlah Penarikan</span>
                <span class="badge badge-<?= htmlspecialchars($withdrawal['status']) ?>"><?= ucfirst(htmlspecialchars($withdrawal['status'])) ?></span>
            </div>
            <div class="panel-body">
                <div class="amount-display">
                    <div class="amount-label">Total Withdrawal</div>
                    <div class="amount-value">Rp <?= number_format($withdrawal['amount'] ?? 0, 0, ',', '.') ?></div>
                </div>
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">ID Withdraw</span>
                        <span class="info-value" style="font-family:monospace;font-size:12px"><?= htmlspecialchars($withdrawal['id_withdraw']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">ID User</span>
                        <span class="info-value" style="font-family:monospace;font-size:12px"><?= htmlspecialchars($withdrawal['id_user'] ?? '-') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Bank</span>
                        <span class="info-value"><?= htmlspecialchars(strtoupper($withdrawal['bank_name'] ?? '-')) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No Rekening</span>
                        <span class="info-value"><?= htmlspecialchars($withdrawal['no_rekening'] ?? '-') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tanggal Request</span>
                        <span class="info-value"><?= !empty($withdrawal['created_at']) ? date('d M Y H:i', strtotime($withdrawal['created_at'])) : '-' ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Terakhir Diperbarui</span>
                        <span class="info-value"><?= !empty($withdrawal['updated_at']) ? date('d M Y H:i', strtotime($withdrawal['updated_at'])) : '-' ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Approve / Reject -->
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Tindakan</span>
            </div>
            <div class="panel-body">
                <?php if ($withdrawal['status'] === 'pending'): ?>
                    <form method="POST" action="<?= BASE_URL ?>withdrawal/updatestatus">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($withdrawal['id_withdraw']) ?>">
                        <input type="hidden" name="from" value="<?= htmlspecialchars($withdrawal['id_withdraw']) ?>">
                        <div class="status-form">
                            <button type="submit" name="status" value="approved" class="btn-approve" onclick="return confirm('Approve withdrawal ini? Dana akan dicairkan ke freelancer.')">
                                <i class="ti ti-check"></i> Approve & Cairkan
                            </button>
                            <button type="submit" name="status" value="rejected" class="btn-reject" onclick="return confirm('Reject withdrawal ini?')">
                                <i class="ti ti-x"></i> Reject
                            </button>
                        </div>
                    </form>
                <?php elseif ($withdrawal['status'] === 'approved'): ?>
                    <div class="status-done">
                        <i class="ti ti-circle-check" style="color:#10b981;font-size:20px"></i>
                        Withdrawal ini sudah disetujui dan dana telah dicairkan.
                    </div>
                <?php else: ?>
                    <div class="status-done">
                        <i class="ti ti-circle-x" style="color:#ef4444;font-size:20px"></i>
                        Withdrawal ini sudah ditolak.
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>

</body>
</html>