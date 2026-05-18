<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #fff7f0;
            color: #1a1a1a;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 240px;
            height: 100vh;
            background: #ffffff;
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
            width: 40px; height: 40px;
            background: #f97316;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }

        .logo-box svg { width: 22px; height: 22px; }

        .logo-text { font-size: 18px; font-weight: 600; color: #f97316; }
        .logo-sub  { font-size: 11px; color: #9ca3af; margin-top: -2px; }

        .sidebar-nav { flex: 1; padding: 16px 12px; }

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

        .nav-item:hover  { background: #fff1e6; color: #f97316; }
        .nav-item.active { background: #fff1e6; color: #f97316; font-weight: 600; }
        .nav-item i { font-size: 18px; }
        .sidebar-footer { padding: 16px 12px; border-top: 1px solid #ffe0cc; }

        /* ── Main ── */
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

        .topbar h1 { font-size: 22px; font-weight: 600; color: #1a1a1a; }
        .topbar p  { font-size: 13px; color: #9ca3af; margin-top: 2px; }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #f97316;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 14px;
        }

        /* ── Stat Cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #ffe0cc;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: #f97316;
        }

        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: #fff1e6;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 14px;
            font-size: 20px;
            color: #f97316;
        }

        .stat-label { font-size: 12px; color: #9ca3af; margin-bottom: 4px; }
        .stat-value { font-size: 26px; font-weight: 700; color: #1a1a1a; }

        /* ── Grid bawah ── */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .panel {
            background: #ffffff;
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

        .panel-title { font-size: 14px; font-weight: 600; color: #1a1a1a; }

        table { width: 100%; border-collapse: collapse; }
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
        }
        tr:hover td { background: #fff7f0; }

        /* Status badges */
        .badge {
            display: inline-block;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
        }
        .badge-pending   { background: #fef3c7; color: #92400e; }
        .badge-active    { background: #d1fae5; color: #065f46; }
        .badge-completed { background: #dbeafe; color: #1e40af; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Order status summary */
        .status-list { padding: 16px 20px; }
        .status-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #fff1e6;
        }
        .status-row:last-child { border-bottom: none; }

        .status-left {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #374151;
        }

        .status-dot {
            width: 10px; height: 10px;
            border-radius: 50%;
        }

        .dot-pending   { background: #f59e0b; }
        .dot-active    { background: #10b981; }
        .dot-completed { background: #3b82f6; }
        .dot-cancelled { background: #ef4444; }

        .status-count { font-size: 16px; font-weight: 700; color: #1a1a1a; }

        /* Bar */
        .bar-wrap { height: 6px; background: #fff1e6; border-radius: 3px; margin-top: 4px; }
        .bar-fill  { height: 6px; border-radius: 3px; background: #f97316; }

        .logout-btn { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; font-size: 14px; color: #ef4444; text-decoration: none; transition: all 0.15s; width: 100%; background: none; border: none; cursor: pointer; }
        .logout-btn:hover { background: #fee2e2; }
        .logout-btn i { font-size: 18px; }
    </style>
</head>
<body>

<!-- Sidebar -->
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
        <a href="<?= BASE_URL ?>dashboard" class="nav-item active"><i class="ti ti-layout-dashboard"></i> Dashboard</a>
        <a href="<?= BASE_URL ?>user" class="nav-item"><i class="ti ti-users"></i> Users</a>
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

<!-- Main Content -->
<main class="main">

    <!-- Topbar -->
    <div class="topbar">
        <div>
            <h1>Overview</h1>
            <p>Selamat datang kembali, Admin 👋</p>
        </div>
        <a href="<?= BASE_URL ?>profile" style="text-decoration:none">
            <div class="avatar" title="Profile Admin">A</div>
        </a>
    </div>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-users"></i></div>
            <div class="stat-label">Total Users</div>
            <div class="stat-value"><?= number_format($totalUsers) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-tool"></i></div>
            <div class="stat-label">Freelancer</div>
            <div class="stat-value"><?= number_format($totalFreelancers) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-shopping-cart"></i></div>
            <div class="stat-label">Total Orders</div>
            <div class="stat-value"><?= number_format($totalOrders) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-briefcase"></i></div>
            <div class="stat-label">Total Services</div>
            <div class="stat-value"><?= number_format($totalServices) ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-credit-card"></i></div>
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="ti ti-clock"></i></div>
            <div class="stat-label">Pending Withdrawal</div>
            <div class="stat-value"><?= number_format($pendingWithdrawals) ?></div>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="bottom-grid">

        <!-- Recent Orders -->
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Order Terbaru</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentOrders)): ?>
                        <?php foreach ($recentOrders as $order): ?>
                        <tr>
                            <td>#<?= htmlspecialchars(substr($order['id_orders'], 0, 8)) ?></td>
                            <td>
                                <span class="badge badge-<?= htmlspecialchars($order['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($order['status'])) ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;color:#9ca3af">Belum ada order</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Order by Status -->
        <div class="panel">
            <div class="panel-header">
                <span class="panel-title">Status Order</span>
            </div>
            <div class="status-list">
                <?php
                $total = array_sum($ordersByStatus);
                $statusLabels = [
                    'pending'   => ['label' => 'Pending',   'dot' => 'dot-pending'],
                    'active'    => ['label' => 'Active',    'dot' => 'dot-active'],
                    'completed' => ['label' => 'Completed', 'dot' => 'dot-completed'],
                    'cancelled' => ['label' => 'Cancelled', 'dot' => 'dot-cancelled'],
                ];
                foreach ($statusLabels as $key => $info):
                    $count = $ordersByStatus[$key] ?? 0;
                    $pct   = $total > 0 ? round($count / $total * 100) : 0;
                ?>
                <div class="status-row">
                    <div class="status-left">
                        <span class="status-dot <?= $info['dot'] ?>"></span>
                        <?= $info['label'] ?>
                    </div>
                    <span class="status-count"><?= $count ?></span>
                </div>
                <div class="bar-wrap">
                    <div class="bar-fill" style="width:<?= $pct ?>%"></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="panel" style="grid-column: span 2">
            <div class="panel-header">
                <span class="panel-title">User Terbaru</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentUsers)): ?>
                        <?php foreach ($recentUsers as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['full_name'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($user['email'] ?? '-') ?></td>
                            <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="3" style="text-align:center;color:#9ca3af">Belum ada user</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</main>

</body>
</html>