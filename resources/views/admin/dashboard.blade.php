<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — RuangSenja</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary-dark: #0A4F52;
            --color-primary: #0F6B6F;
            --color-primary-pale: #CFE8E6;
            --color-background: #FFF8F1;
            --color-surface-soft: #F6EBDD;
            --color-border: #D9C4B3;
            --color-text-primary: #4A403A;
            --color-text-secondary: #7A6E66;
            --color-danger: #D96C6C;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--color-background); color: var(--color-text-primary); display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px; min-height: 100vh;
            background: var(--color-primary-dark);
            padding: 32px 20px;
            display: flex; flex-direction: column;
            flex-shrink: 0;
        }
        .sidebar-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 40px; }
        .sidebar-logo-icon { width: 36px; height: 36px; background: #F47C4C; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .sidebar-logo-text { font-size: 18px; font-weight: 700; color: #fff; }
        .sidebar-label { font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .sidebar-nav { list-style: none; display: flex; flex-direction: column; gap: 4px; flex: 1; }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; color: rgba(255,255,255,0.75); font-size: 14px; font-weight: 500; text-decoration: none; transition: background 150ms, color 150ms; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: var(--color-primary); color: #fff; }
        .sidebar-logout { margin-top: auto; }
        .sidebar-logout form button { width: 100%; display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 10px; color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 500; background: none; border: none; cursor: pointer; transition: background 150ms, color 150ms; font-family: inherit; }
        .sidebar-logout form button:hover { background: rgba(217,108,108,0.2); color: #D96C6C; }

        .main { flex: 1; padding: 40px 48px; }
        .page-header { margin-bottom: 32px; }
        .page-title { font-size: 28px; font-weight: 700; color: var(--color-primary-dark); }
        .page-subtitle { font-size: 15px; color: var(--color-text-secondary); margin-top: 4px; }

        .coming-soon {
            background: var(--color-surface-soft);
            border: 1.5px dashed var(--color-border);
            border-radius: 16px;
            padding: 60px 40px;
            text-align: center;
            color: var(--color-text-secondary);
        }
        .coming-soon h3 { font-size: 20px; font-weight: 600; color: var(--color-primary-dark); margin-top: 16px; }
        .coming-soon p { font-size: 14px; margin-top: 8px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sidebar-logo-icon">RS</div>
            <span class="sidebar-logo-text">RuangSenja</span>
        </div>

        <p class="sidebar-label">Menu Admin</p>
        <ul class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('admin.lansia.index') }}">Data Lansia</a></li>
            <li><a href="{{ route('admin.kebutuhan.index') }}">Kebutuhan Panti</a></li>
            <li><a href="{{ route('admin.donasi.index') }}">Pengajuan Donasi</a></li>
        </ul>

        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Keluar</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="page-header">
            <h1 class="page-title">Dashboard Admin</h1>
            <p class="page-subtitle">Selamat datang, <strong>{{ auth()->user()->nama }}</strong> 👋</p>
        </div>

        <div class="coming-soon">
            <div style="font-size: 48px;">🏗️</div>
            <h3>Fitur Sedang Dikembangkan</h3>
            <p>Halaman dashboard admin lengkap akan segera tersedia. Autentikasi berhasil!</p>
        </div>
    </main>
</body>
</html>
