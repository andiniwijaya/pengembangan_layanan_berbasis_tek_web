@extends('layouts.page')

@section('page-title', 'Pusat Bantuan')

@section('page-content')
    <h2 class="text-lg font-semibold">Pertanyaan Umum</h2>
    <ul class="mt-4 list-disc space-y-2 pl-5">
        <li><strong>Bagaimana cara melacak pesanan?</strong> — Buka menu Pesanan Saya atau Dashboard untuk melihat status
            pesanan terbaru.</li>
        <li><strong>Metode pembayaran apa saja yang tersedia?</strong> — Transfer bank, QRIS, dan Bayar di Tempat (COD).
        </li>
        <li><strong>Berapa lama pengiriman?</strong> — Estimasi 2–5 hari kerja untuk area Jabodetabek.</li>
        <li><strong>Bagaimana cara mengembalikan produk?</strong> — Hubungi tim kami melalui halaman Kontak dalam 7 hari
            setelah barang diterima.</li>
    </ul>
    <p class="mt-6">Butuh bantuan lebih lanjut? Kunjungi halaman <a href="{{ route('pages.contact') }}"
            class="font-medium text-accent hover:underline dark:text-primary">Kontak</a>.</p>
@endsection
