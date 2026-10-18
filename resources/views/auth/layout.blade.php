<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'RuangSenja — Platform donasi untuk panti jompo. Kepedulian yang Menghadirkan Kehangatan.')">
    <title>@yield('title', 'RuangSenja') — Kepedulian yang Menghadirkan Kehangatan</title>

    <!-- Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ===== DESIGN TOKENS (StyleGuide RuangSenja) ===== */
        :root {
            --color-primary-dark:   #0A4F52;
            --color-primary:        #0F6B6F;
            --color-primary-light:  #4F9A9D;
            --color-primary-pale:   #CFE8E6;
            --color-secondary:      #F47C4C;
            --color-secondary-light:#F9A06B;
            --color-secondary-pale: #FFD2B2;
            --color-background:     #FFF8F1;
            --color-surface-soft:   #F6EBDD;
            --color-card:           #E8D9C8;
            --color-border:         #D9C4B3;
            --color-text-primary:   #4A403A;
            --color-text-secondary: #7A6E66;
            --color-text-muted:     #B5A79C;
            --color-success:        #6FA77B;
            --color-warning:        #E8A33B;
            --color-danger:         #D96C6C;
            --color-info:           #5E9CA0;
            --radius-sm:  8px;
            --radius-md:  12px;
            --radius-lg:  16px;
            --radius-xl:  24px;
            --space-1:  4px;  --space-2:  8px;  --space-3: 12px;
            --space-4: 16px;  --space-5: 20px;  --space-6: 24px;
            --space-8: 32px;  --space-10:40px;  --space-12:48px;
            --space-16:64px;
            --container-max: 1200px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--color-background);
            color: var(--color-text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ===== AUTH LAYOUT ===== */
        .auth-wrapper {
            width: 100%;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* Panel kiri — branding */
        .auth-brand {
            background: var(--color-primary-dark);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: var(--space-16) var(--space-12);
            position: relative;
            overflow: hidden;
        }

        .auth-brand::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 320px; height: 320px;
            background: var(--color-primary);
            border-radius: 50%;
            opacity: 0.4;
        }

        .auth-brand::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 240px; height: 240px;
            background: var(--color-secondary);
            border-radius: 50%;
            opacity: 0.15;
        }

        .auth-brand-inner { position: relative; z-index: 1; }

        .auth-logo {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-12);
        }

        .auth-logo-icon {
            width: 48px; height: 48px;
            background: var(--color-secondary);
            border-radius: var(--radius-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }

        .auth-logo-text {
            font-size: 26px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .auth-brand-eyebrow {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-secondary-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: var(--space-3);
        }

        .auth-brand-heading {
            font-size: 36px;
            font-weight: 700;
            color: #fff;
            line-height: 1.25;
            margin-bottom: var(--space-5);
        }

        .auth-brand-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.7);
            line-height: 1.65;
            max-width: 380px;
        }

        .auth-brand-stats {
            display: flex;
            gap: var(--space-8);
            margin-top: var(--space-12);
        }

        .auth-stat { text-align: left; }

        .auth-stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-secondary-light);
        }

        .auth-stat-label {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-top: 2px;
        }

        /* Panel kanan — form */
        .auth-form-panel {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: var(--space-12) var(--space-10);
            background: var(--color-background);
            overflow-y: auto;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
        }

        .auth-form-header { margin-bottom: var(--space-8); }

        .auth-form-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-primary-dark);
            margin-bottom: var(--space-2);
        }

        .auth-form-subtitle {
            font-size: 15px;
            color: var(--color-text-secondary);
        }

        /* ===== FORM ELEMENTS ===== */
        .form-group { margin-bottom: var(--space-5); }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: var(--space-2);
        }

        .form-input {
            width: 100%;
            height: 46px;
            padding: 0 var(--space-4);
            background: #fff;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 15px;
            color: var(--color-text-primary);
            transition: border-color 150ms, box-shadow 150ms;
            outline: none;
        }

        .form-input::placeholder { color: var(--color-text-muted); }

        .form-input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px var(--color-primary-pale);
        }

        .form-input.is-invalid { border-color: var(--color-danger); }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(217,108,108,0.15);
        }

        .form-textarea {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            background: #fff;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 15px;
            color: var(--color-text-primary);
            resize: vertical;
            min-height: 80px;
            transition: border-color 150ms, box-shadow 150ms;
            outline: none;
        }

        .form-textarea:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px var(--color-primary-pale);
        }

        .form-error {
            font-size: 13px;
            color: var(--color-danger);
            margin-top: var(--space-1);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint {
            font-size: 12px;
            color: var(--color-text-muted);
            margin-top: var(--space-1);
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            height: 46px;
            padding: 0 var(--space-6);
            border: none;
            border-radius: var(--radius-md);
            font-family: inherit;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 150ms, transform 100ms, box-shadow 150ms;
            text-decoration: none;
        }

        .btn:active { transform: scale(0.98); }

        .btn-primary {
            background: var(--color-primary);
            color: #fff;
            width: 100%;
        }

        .btn-primary:hover { background: var(--color-primary-dark); box-shadow: 0 4px 12px rgba(15,107,111,0.25); }

        /* ===== ALERT ===== */
        .alert {
            padding: var(--space-3) var(--space-4);
            border-radius: var(--radius-md);
            font-size: 14px;
            margin-bottom: var(--space-5);
            display: flex;
            align-items: flex-start;
            gap: var(--space-2);
        }

        .alert-danger {
            background: rgba(217,108,108,0.1);
            border: 1px solid rgba(217,108,108,0.3);
            color: #a03535;
        }

        .alert-success {
            background: rgba(111,167,123,0.1);
            border: 1px solid rgba(111,167,123,0.3);
            color: #3a6b42;
        }

        /* ===== DIVIDER ===== */
        .auth-divider {
            text-align: center;
            margin: var(--space-6) 0;
            position: relative;
            color: var(--color-text-muted);
            font-size: 13px;
        }

        .auth-divider::before, .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 30px);
            height: 1px;
            background: var(--color-border);
        }

        .auth-divider::before { left: 0; }
        .auth-divider::after  { right: 0; }

        /* ===== LINK ===== */
        .auth-link {
            color: var(--color-primary);
            font-weight: 600;
            text-decoration: none;
        }
        .auth-link:hover { color: var(--color-primary-dark); text-decoration: underline; }

        .auth-footer-text {
            text-align: center;
            font-size: 14px;
            color: var(--color-text-secondary);
            margin-top: var(--space-6);
        }

        /* ===== FLASH ALERT / NOTIFIKASI ===== */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius-md);
            margin-bottom: var(--space-5);
            font-size: 14px;
            line-height: 1.5;
            animation: alertFadeIn 0.35s ease;
        }

        @keyframes alertFadeIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-icon {
            font-size: 20px;
            line-height: 1;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert-success {
            background-color: #ECFDF5;
            border: 1px solid #A7F3D0;
            color: #065F46;
        }

        .alert-danger {
            background-color: #FEF2F2;
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .auth-wrapper { grid-template-columns: 1fr; }
            .auth-brand { display: none; }
            .auth-form-panel { padding: var(--space-8) var(--space-5); min-height: 100vh; }
        }

        /* ===== CHECKBOX ===== */
        .form-check {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .form-check-input {
            width: 18px; height: 18px;
            border: 1.5px solid var(--color-border);
            border-radius: 4px;
            cursor: pointer;
            accent-color: var(--color-primary);
        }

        .form-check-label {
            font-size: 14px;
            color: var(--color-text-secondary);
            cursor: pointer;
        }

        /* Password toggle */
        .input-wrapper { position: relative; }

        .input-wrapper .form-input { padding-right: 46px; }

        .btn-toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--color-text-muted);
            font-size: 18px;
            padding: 0;
            display: flex;
            align-items: center;
        }

        .btn-toggle-password:hover { color: var(--color-primary); }

        /* Input row (2 kolom) */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: var(--space-4);
        }

        @media (max-width: 480px) {
            .form-row { grid-template-columns: 1fr; }
        }
    </style>

    @stack('styles')
</head>
<body>
    @yield('content')

    @stack('scripts')
    <script>
        // Toggle password visibility
        function togglePassword(id) {
            const input = document.getElementById(id);
            const btn   = input.closest('.input-wrapper').querySelector('.btn-toggle-password');
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = '&#128065;&#65039;';
                btn.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                input.type = 'password';
                btn.innerHTML = '&#128065;';
                btn.setAttribute('aria-label', 'Tampilkan password');
            }
        }
    </script>
</body>
</html>
