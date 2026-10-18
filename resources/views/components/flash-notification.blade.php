@php
    $hasAlert = session('success') || session('error') || session('warning') || session('info') || session('status') || ($errors->any() && !isset($hideErrors));
@endphp

@if ($hasAlert)
<div id="flash-notification-container" class="space-y-3 mb-6 transition-all duration-300">

    {{-- ── NOTIFIKASI SUKSES ── --}}
    @if (session('success'))
        <div class="flash-alert group relative flex items-start gap-4 rounded-2xl border border-emerald-200 bg-gradient-to-r from-emerald-50 via-[#f0fdf4] to-emerald-50/80 p-4 sm:p-5 text-emerald-950 shadow-sm transition-all duration-300 overflow-hidden"
             role="status"
             data-auto-dismiss="6000">
            {{-- Emoticon Badge --}}
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-100/90 border border-emerald-200 text-2xl shadow-sm transition-transform group-hover:scale-105">
                🎉
            </div>

            {{-- Pesan --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold tracking-wide uppercase text-emerald-800">Berhasil!</h4>
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                </div>
                <p class="mt-1 text-sm font-medium leading-relaxed text-emerald-900">
                    {{ session('success') }}
                </p>
            </div>

            {{-- Tombol Tutup --}}
            <button type="button"
                    onclick="dismissFlashAlert(this)"
                    class="flex-shrink-0 -mr-1 -mt-1 p-2 rounded-xl text-emerald-600/70 hover:text-emerald-900 hover:bg-emerald-100/60 focus:outline-none focus:ring-2 focus:ring-emerald-400 transition-colors"
                    title="Tutup pemberitahuan"
                    aria-label="Tutup notifikasi">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Progress bar auto-dismiss --}}
            <div class="flash-progress-bar absolute bottom-0 left-0 h-1 bg-emerald-400/50 w-full origin-left"></div>
        </div>
    @endif

    {{-- ── NOTIFIKASI ERROR / GAGAL ── --}}
    @if (session('error'))
        <div class="flash-alert group relative flex items-start gap-4 rounded-2xl border border-rose-200 bg-gradient-to-r from-rose-50 via-[#fff1f2] to-rose-50/80 p-4 sm:p-5 text-rose-950 shadow-sm transition-all duration-300 overflow-hidden"
             role="alert"
             data-auto-dismiss="8000">
            {{-- Emoticon Badge --}}
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-rose-100/90 border border-rose-200 text-2xl shadow-sm transition-transform group-hover:scale-105">
                ⚠️
            </div>

            {{-- Pesan --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold tracking-wide uppercase text-rose-800">Terjadi Kendala!</h4>
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                </div>
                <p class="mt-1 text-sm font-medium leading-relaxed text-rose-900">
                    {{ session('error') }}
                </p>
            </div>

            {{-- Tombol Tutup --}}
            <button type="button"
                    onclick="dismissFlashAlert(this)"
                    class="flex-shrink-0 -mr-1 -mt-1 p-2 rounded-xl text-rose-600/70 hover:text-rose-900 hover:bg-rose-100/60 focus:outline-none focus:ring-2 focus:ring-rose-400 transition-colors"
                    title="Tutup pemberitahuan"
                    aria-label="Tutup notifikasi">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Progress bar auto-dismiss --}}
            <div class="flash-progress-bar absolute bottom-0 left-0 h-1 bg-rose-400/50 w-full origin-left"></div>
        </div>
    @endif

    {{-- ── NOTIFIKASI PERINGATAN (WARNING) ── --}}
    @if (session('warning'))
        <div class="flash-alert group relative flex items-start gap-4 rounded-2xl border border-amber-200 bg-gradient-to-r from-amber-50 via-[#fffbeb] to-amber-50/80 p-4 sm:p-5 text-amber-950 shadow-sm transition-all duration-300 overflow-hidden"
             role="alert"
             data-auto-dismiss="7000">
            {{-- Emoticon Badge --}}
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100/90 border border-amber-200 text-2xl shadow-sm transition-transform group-hover:scale-105">
                🔔
            </div>

            {{-- Pesan --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold tracking-wide uppercase text-amber-800">Perhatian</h4>
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                </div>
                <p class="mt-1 text-sm font-medium leading-relaxed text-amber-900">
                    {{ session('warning') }}
                </p>
            </div>

            {{-- Tombol Tutup --}}
            <button type="button"
                    onclick="dismissFlashAlert(this)"
                    class="flex-shrink-0 -mr-1 -mt-1 p-2 rounded-xl text-amber-600/70 hover:text-amber-900 hover:bg-amber-100/60 focus:outline-none focus:ring-2 focus:ring-amber-400 transition-colors"
                    title="Tutup pemberitahuan"
                    aria-label="Tutup notifikasi">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Progress bar auto-dismiss --}}
            <div class="flash-progress-bar absolute bottom-0 left-0 h-1 bg-amber-400/50 w-full origin-left"></div>
        </div>
    @endif

    {{-- ── NOTIFIKASI INFORMASI / STATUS ── --}}
    @if (session('info') || session('status'))
        <div class="flash-alert group relative flex items-start gap-4 rounded-2xl border border-sky-200 bg-gradient-to-r from-sky-50 via-[#f0f9ff] to-sky-50/80 p-4 sm:p-5 text-sky-950 shadow-sm transition-all duration-300 overflow-hidden"
             role="status"
             data-auto-dismiss="6000">
            {{-- Emoticon Badge --}}
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-sky-100/90 border border-sky-200 text-2xl shadow-sm transition-transform group-hover:scale-105">
                💡
            </div>

            {{-- Pesan --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold tracking-wide uppercase text-sky-800">Informasi</h4>
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-sky-500"></span>
                </div>
                <p class="mt-1 text-sm font-medium leading-relaxed text-sky-900">
                    {{ session('info') ?? session('status') }}
                </p>
            </div>

            {{-- Tombol Tutup --}}
            <button type="button"
                    onclick="dismissFlashAlert(this)"
                    class="flex-shrink-0 -mr-1 -mt-1 p-2 rounded-xl text-sky-600/70 hover:text-sky-900 hover:bg-sky-100/60 focus:outline-none focus:ring-2 focus:ring-sky-400 transition-colors"
                    title="Tutup pemberitahuan"
                    aria-label="Tutup notifikasi">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Progress bar auto-dismiss --}}
            <div class="flash-progress-bar absolute bottom-0 left-0 h-1 bg-sky-400/50 w-full origin-left"></div>
        </div>
    @endif

    {{-- ── ERROR VALIDASI FORMULIR ── --}}
    @if ($errors->any() && !isset($hideErrors))
        <div class="flash-alert group relative flex items-start gap-4 rounded-2xl border border-red-200 bg-gradient-to-r from-red-50 via-[#fef2f2] to-red-50/80 p-4 sm:p-5 text-red-950 shadow-sm transition-all duration-300"
             role="alert">
            {{-- Emoticon Badge --}}
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-xl bg-red-100/90 border border-red-200 text-2xl shadow-sm">
                📝
            </div>

            {{-- Daftar Error --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-bold tracking-wide uppercase text-red-800">Mohon Periksa Data Formulir</h4>
                    <span class="inline-block h-1.5 w-1.5 rounded-full bg-red-500"></span>
                </div>
                <ul class="mt-2 space-y-1 text-sm font-medium text-red-900">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Tombol Tutup --}}
            <button type="button"
                    onclick="dismissFlashAlert(this)"
                    class="flex-shrink-0 -mr-1 -mt-1 p-2 rounded-xl text-red-600/70 hover:text-red-900 hover:bg-red-100/60 focus:outline-none focus:ring-2 focus:ring-red-400 transition-colors"
                    title="Tutup pemberitahuan"
                    aria-label="Tutup notifikasi">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

</div>

{{-- Script & Style Notifikasi --}}
<style>
    @keyframes flashSlideDown {
        from {
            opacity: 0;
            transform: translateY(-12px) scale(0.99);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes flashProgressLinear {
        from { width: 100%; }
        to { width: 0%; }
    }

    .flash-alert {
        animation: flashSlideDown 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .flash-progress-bar {
        animation: flashProgressLinear var(--dismiss-duration, 6000ms) linear forwards;
    }

    .flash-alert:hover .flash-progress-bar {
        animation-play-state: paused;
    }
</style>

<script>
    function dismissFlashAlert(target) {
        const alert = target.closest('.flash-alert');
        if (!alert) return;

        alert.style.transition = 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px) scale(0.97)';
        alert.style.maxHeight = alert.scrollHeight + 'px';

        requestAnimationFrame(() => {
            alert.style.maxHeight = '0px';
            alert.style.marginTop = '0px';
            alert.style.marginBottom = '0px';
            alert.style.paddingTop = '0px';
            alert.style.paddingBottom = '0px';
            alert.style.borderWidth = '0px';
        });

        setTimeout(() => {
            alert.remove();
            const container = document.getElementById('flash-notification-container');
            if (container && container.children.length === 0) {
                container.remove();
            }
        }, 350);
    }

    function initFlashAlerts() {
        const autoDismissAlerts = document.querySelectorAll('.flash-alert[data-auto-dismiss]');

        autoDismissAlerts.forEach(function (alert) {
            const duration = parseInt(alert.getAttribute('data-auto-dismiss'), 10) || 6000;
            const progressBar = alert.querySelector('.flash-progress-bar');
            if (progressBar) {
                progressBar.style.setProperty('--dismiss-duration', duration + 'ms');
            }

            let timeoutId;
            let remaining = duration;
            let startTime = Date.now();

            function startTimer() {
                startTime = Date.now();
                timeoutId = setTimeout(function () {
                    dismissFlashAlert(alert);
                }, remaining);
            }

            function pauseTimer() {
                clearTimeout(timeoutId);
                remaining -= Date.now() - startTime;
            }

            // Hover pause
            alert.addEventListener('mouseenter', pauseTimer);
            alert.addEventListener('mouseleave', function () {
                if (remaining > 0) {
                    startTimer();
                }
            });

            startTimer();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFlashAlerts);
    } else {
        initFlashAlerts();
    }
</script>
@endif
