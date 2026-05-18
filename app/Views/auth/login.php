<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Studlent</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --orange-50:  #fff7ed;
            --orange-100: #ffedd5;
            --orange-200: #fed7aa;
            --orange-400: #fb923c;
            --orange-500: #f97316;
            --orange-600: #ea6c0d;
            --orange-700: #c2570a;
            --white: #ffffff;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-900: #111827;
            --red-100: #fee2e2;
            --red-600: #dc2626;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--orange-50);
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ── Left decorative panel ── */
        .left-panel {
            flex: 0 0 45%;
            background: linear-gradient(145deg, var(--orange-500) 0%, #f84f00 60%, #c2400a 100%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Decorative circles */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            border: 80px solid rgba(255,255,255,0.07);
            top: -160px;
            left: -160px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            border: 60px solid rgba(255,255,255,0.06);
            bottom: -100px;
            right: -100px;
        }

        .left-circle-mid {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            bottom: 120px;
            left: 40px;
        }

        .left-content {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 40px;
            color: white;
        }

        .left-content .brand-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.15);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .left-content .brand-icon svg {
            width: 44px;
            height: 44px;
        }

        .left-content h2 {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .left-content p {
            font-size: 14px;
            opacity: 0.8;
            line-height: 1.6;
            max-width: 260px;
            margin: 0 auto 32px;
        }

        .feature-list {
            list-style: none;
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            opacity: 0.9;
        }

        .feature-list li .fi {
            width: 30px;
            height: 30px;
            background: rgba(255,255,255,0.18);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        /* ── Right: form area ── */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            position: relative;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: var(--orange-100);
            opacity: 0.5;
            top: -80px;
            right: -80px;
            pointer-events: none;
        }

        .form-card {
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Header ── */
        .form-header {
            margin-bottom: 32px;
        }

        .form-header .welcome {
            font-size: 13px;
            font-weight: 600;
            color: var(--orange-500);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 6px;
        }

        .form-header h1 {
            font-size: 28px;
            font-weight: 800;
            color: var(--gray-900);
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        /* ── Form groups ── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: var(--gray-700);
            margin-bottom: 7px;
            font-weight: 600;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: var(--gray-400);
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid var(--orange-200);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--gray-900);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-wrap input::placeholder {
            color: #c4b5aa;
        }

        .input-wrap input:focus {
            border-color: var(--orange-500);
            box-shadow: 0 0 0 4px rgba(249,115,22,0.12);
        }

        .input-wrap input:focus + .icon,
        .input-wrap:focus-within .icon {
            color: var(--orange-500);
        }

        /* ── Error ── */
        .error-box {
            background: var(--red-100);
            color: var(--red-600);
            padding: 11px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-left: 3px solid var(--red-600);
            animation: fadeUp 0.3s ease both;
        }

        /* ── Button ── */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--orange-500), #f84f00);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            margin-top: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(249,115,22,0.35);
            letter-spacing: 0.2px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, var(--orange-600), #d94400);
            box-shadow: 0 6px 18px rgba(249,115,22,0.45);
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0) scale(0.98);
            box-shadow: 0 2px 8px rgba(249,115,22,0.3);
        }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 22px 0 20px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--orange-100);
        }

        .divider span {
            font-size: 12px;
            color: var(--gray-400);
        }

        /* ── Footer ── */
        .form-footer {
            text-align: center;
            margin-top: 24px;
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .badge {
            font-size: 11px;
            padding: 4px 12px;
            border-radius: 20px;
            background: var(--orange-50);
            color: var(--orange-700);
            border: 1px solid var(--orange-200);
            font-weight: 500;
        }

        .version-tag {
            text-align: center;
            margin-top: 12px;
            font-size: 11px;
            color: var(--gray-400);
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 32px 20px; }
        }
    </style>
</head>
<body>

    <!-- Left decorative panel -->
    <div class="left-panel">
        <div class="left-circle-mid"></div>
        <div class="left-content">
            <div class="brand-icon">
                <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 10C6 8.34 7.34 7 9 7H27C28.66 7 30 8.34 30 10V22C30 23.66 28.66 25 27 25H20L18 29L16 25H9C7.34 25 6 23.66 6 22V10Z" fill="white" opacity="0.95"/>
                    <rect x="10" y="12" width="6" height="2" rx="1" fill="#f97316"/>
                    <rect x="10" y="16" width="10" height="2" rx="1" fill="#f97316"/>
                    <rect x="10" y="20" width="7" height="2" rx="1" fill="#f97316"/>
                    <circle cx="26" cy="12" r="2.5" fill="#fdba74"/>
                </svg>
            </div>
            <h2>Studlent Admin</h2>
            <p>Platform manajemen freelance pelajar yang mudah dan efisien.</p>
            <ul class="feature-list">
                <li>
                    <span class="fi"><i class="ti ti-users"></i></span>
                    Kelola pengguna &amp; freelancer
                </li>
                <li>
                    <span class="fi"><i class="ti ti-safe"></i></span>
                    Pantau escrow &amp; pembayaran
                </li>
                <li>
                    <span class="fi"><i class="ti ti-chart-bar"></i></span>
                    Laporan &amp; analitik real-time
                </li>
                <li>
                    <span class="fi"><i class="ti ti-shield-check"></i></span>
                    Akses aman &amp; terenkripsi
                </li>
            </ul>
        </div>
    </div>

    <!-- Right: form -->
    <div class="right-panel">
        <div class="form-card">

            <div class="form-header">
                <div class="welcome">Selamat Datang</div>
                <h1>Masuk ke Panel Admin</h1>
                <p>Gunakan akun admin Studlent Anda untuk melanjutkan.</p>
            </div>

            <!-- Error -->
            <?php if (isset($error)): ?>
                <div class="error-box">
                    <i class="ti ti-alert-circle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST">
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <i class="ti ti-mail icon"></i>
                        <input type="email" id="email" name="email"
                               placeholder="admin@studlent.id" required
                               autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="ti ti-lock icon"></i>
                        <input type="password" id="password" name="password"
                               placeholder="••••••••" required
                               autocomplete="current-password">
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="ti ti-login"></i>
                    Masuk Sekarang
                </button>
            </form>

            <div class="version-tag">© 2025 Studlent · All rights reserved</div>

        </div>
    </div>

</body>
</html>