<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin') RuangSenja</title>
    <meta name="description" content="Panel Administrator RuangSenja">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: {
                            dark:  '#0A4F52',
                            DEFAULT: '#0F6B6F',
                            light: '#4F9A9D',
                            pale:  '#CFE8E6',
                        },
                        secondary: {
                            DEFAULT: '#F47C4C',
                            light:   '#F9A06B',
                            pale:    '#FFD2B2',
                        },
                        neutral: {
                            bg:     '#FFF8F1',
                            soft:   '#F6EBDD',
                            card:   '#E8D9C8',
                            border: '#D9C4B3',
                        },
                        ink: {
                            primary:   '#4A403A',
                            secondary: '#7A6E66',
                            muted:     '#B5A79C',
                        },
                        status: {
                            success: '#6FA77B',
                            warning: '#E8A33B',
                            danger:  '#D96C6C',
                            info:    '#5E9CA0',
                        },
                    },
                }
            }
        }
    </script>
</head>

<body class="min-h-screen bg-[#FFF8F1] text-[#4A403A]"
      style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="flex min-h-screen">

        {{-- ── Sidebar ─────────────────────────────────────────── --}}
        @include('components.sidebar-admin')

        {{-- ── Area konten utama ──────────────────────────────── --}}
        <div class="flex flex-1 flex-col min-w-0">

            {{-- Header mobile --}}
            @include('components.topbar-admin')

            {{-- Flash messages --}}
            <div class="mx-auto w-full max-w-7xl px-6 pt-4">
                @include('components.flash-notification')
            </div>

            {{-- Konten halaman --}}
            <main class="mx-auto w-full max-w-7xl flex-1 px-6 pb-10 pt-2 lg:px-8">
                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>