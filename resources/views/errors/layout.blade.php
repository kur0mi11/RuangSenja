<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | RuangSenja</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            padding: 24px; background: #FFF8F1; color: #4A403A;
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
        }
        .card {
            width: 100%; max-width: 520px; text-align: center; padding: 48px 32px;
            background: #FFFDF9; border: 1px solid #E8D9C8; border-radius: 24px;
            box-shadow: 0 10px 30px rgba(15, 107, 111, .08);
        }
        .brand { font-size: 22px; font-weight: 800; color: #0F6B6F; margin-bottom: 24px; }
        .brand span { color: #F47C4C; }
        .code { font-size: 84px; font-weight: 800; line-height: 1; color: #F47C4C; }
        h1 { margin-top: 12px; font-size: 24px; font-weight: 800; color: #0A4F52; }
        p { margin-top: 12px; font-size: 15px; line-height: 1.6; color: #7A6E66; }
        .actions { margin-top: 28px; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .btn {
            display: inline-block; padding: 12px 22px; border-radius: 12px; font-size: 14px;
            font-weight: 700; text-decoration: none; cursor: pointer; border: 1px solid #0F6B6F;
            font-family: inherit;
        }
        .btn-primary { background: #0F6B6F; color: #fff; }
        .btn-primary:hover { background: #0A4F52; }
        .btn-outline { background: transparent; color: #0F6B6F; }
        .btn-outline:hover { background: #F6EBDD; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">Ruang<span>Senja</span></div>
        <div class="code">@yield('code')</div>
        <h1>@yield('heading')</h1>
        <p>@yield('message')</p>
        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">Ke Beranda</a>
            <button type="button" class="btn btn-outline" onclick="history.length > 1 ? history.back() : (window.location = '{{ url('/') }}')">Kembali</button>
        </div>
    </div>
</body>
</html>
