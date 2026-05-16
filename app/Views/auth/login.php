<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Studlent</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #eef2ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background: #ffffff;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }

        /* ── Logo ── */
        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            margin-bottom: 1rem;
        }

        .logo-icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-icon img {
            width: 200px;
            height: auto;
            object-fit: contain;
        }

        .logo-icon svg {
            width: 36px;
            height: 36px;
        }

        .logo-title {
            font-size: 22px;
            font-weight: 600;
            color: #1e1b4b;
            letter-spacing: -0.3px;
        }

        .logo-sub {
            font-size: 13px;
            color: #6b7280;
            margin-top: -6px;
        }

        /* ── Form ── */
        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #374151;
            margin-bottom: 6px;
            font-weight: 500;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 17px;
            color: #9ca3af;
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            background: #f9fafb;
            color: #111827;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-wrap input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
            background: #fff;
        }

        /* ── Error ── */
        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Button ── */
        .btn-login {
            width: 100%;
            padding: 11px;
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-login:hover { background: #4338ca; }
        .btn-login:active { transform: scale(0.98); }

        /* ── Footer badges ── */
        .footer {
            text-align: center;
            margin-top: 1.4rem;
        }

        .footer p {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 8px;
        }

        .badge-wrap {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .badge {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="card">

        <!-- Logo -->
        <div class="logo-wrap">
            <div class="logo-icon">
                <img src="/STUDLENT-ADMIN/public/images/logoStudlent.png" alt="Studlent Logo">
            </div>

            <div style="text-align:center">
                <div class="logo-sub">Panel Admin</div>
            </div>
        </div>

        <!-- Error -->
        <?php if (isset($error)): ?>
            <div class="error">
                <i class="ti ti-alert-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <i class="ti ti-mail icon"></i>
                    <input type="email" id="email" name="email" placeholder="admin@studlent.id" required>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="ti ti-lock icon"></i>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="ti ti-login"></i>
                Masuk
            </button>
        </form>
    </div>
</body>
</html>