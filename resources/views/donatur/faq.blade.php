@extends('donatur.layout')

@section('title', 'FAQ & Panduan')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-[#0A4F52]">FAQ &amp; Panduan Donasi</h1>
        <p class="mt-2 text-[#7A6E66]">Jawaban untuk pertanyaan yang sering diajukan donatur.</p>
    </div>

    <div class="mx-auto max-w-3xl space-y-3">
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Bagaimana cara mengajukan donasi?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Buka menu <strong>Ajukan Donasi</strong>, pilih jenis donasi (barang atau uang), isi rincian dan metode donasi, lalu kirim. Pengajuan baru otomatis berstatus <em>Menunggu</em> sampai diperiksa admin panti.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Apa bedanya donasi barang dan donasi uang?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Donasi barang dipilih dari daftar <strong>Kebutuhan Panti</strong> yang aktif, lengkap dengan jumlah dan satuannya. Donasi uang dicatat sebagai nominal rupiah dan dapat dilengkapi bukti transfer.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Apa arti status Menunggu, Diterima, dan Ditolak?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]"><strong>Menunggu</strong>: pengajuan belum diperiksa admin. <strong>Diterima</strong>: admin sudah mengonfirmasi donasi Anda. <strong>Ditolak</strong>: pengajuan tidak dapat diproses, dan alasannya ditampilkan di halaman detail donasi.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Apakah pengajuan donasi bisa diubah atau dihapus?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Bisa, selama statusnya masih <em>Menunggu</em>. Setelah diterima atau ditolak, pengajuan tersimpan sebagai riwayat dan tidak dapat diubah atau dihapus.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Bagaimana cara mengunggah bukti transfer?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Pada donasi uang dengan metode transfer, Anda dapat mengunggah bukti berformat JPG, PNG, atau PDF dengan ukuran maksimal 5 MB. Bukti dapat diganti selama donasi masih berstatus Menunggu.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Di mana saya bisa melihat riwayat donasi?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Buka menu <strong>Riwayat Donasi</strong>. Anda bisa menyaring daftar berdasarkan status dan membuka detail setiap pengajuan.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Mengapa donasi saya ditolak?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Admin menuliskan alasan penolakan di halaman detail donasi. Anda dapat mengajukan donasi baru setelah menyesuaikan dengan alasan tersebut.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Bagaimana cara mengubah data diri atau password?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Buka menu <strong>Profil</strong>. Di sana Anda dapat memperbarui nama, email, nomor HP, alamat, dan mengganti password.</p>
        </details>
        <details class="group rounded-2xl border border-[#E8D9C8] bg-[#FFFDF9] p-5 open:border-[#4F9A9D]">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-[#0A4F52]">
                Apakah data lansia bisa saya lihat?
                <span class="text-xl text-[#F47C4C] transition group-open:rotate-45">+</span>
            </summary>
            <p class="mt-3 text-sm leading-relaxed text-[#7A6E66]">Tidak. Data lansia hanya dikelola oleh admin panti untuk menjaga privasi para penghuni.</p>
        </details>
    </div>

    <div class="mx-auto mt-8 max-w-3xl rounded-2xl bg-[#CFE8E6] p-6 text-center">
        <p class="font-semibold text-[#0A4F52]">Siap berdonasi?</p>
        <a href="{{ route('donatur.donasi.create') }}" class="mt-3 inline-block rounded-xl bg-[#0F6B6F] px-6 py-3 text-sm font-bold text-white hover:bg-[#0A4F52]">Ajukan Donasi</a>
    </div>
@endsection
