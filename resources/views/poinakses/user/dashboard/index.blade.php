@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p>Kelola aktivitas pertanian harian Anda</p>
    </div>

    <div class="dashboard-stats">
        <x-dashboard-card 
            icon="fas fa-seedling"
            title="Total Tanaman"
            value="{{ number_format(\App\Models\Penanaman::sum('jumlah_tanaman')) }}"
            trend="Ditanam"
        />

        <x-dashboard-card 
            icon="fas fa-hand-holding-water"
            title="Data Perawatan"
            value="{{ \App\Models\Perawatan::count() }}"
            trend="Dilakukan"
        />

        <x-dashboard-card 
            icon="fas fa-wheat"
            title="Data Pemanenan"
            value="{{ \App\Models\Pemanenan::count() }}"
            trend="Dipanen"
        />
    </div>

    <div class="dashboard-quick-actions">
        <h2>Aksi Cepat</h2>
        <div class="quick-actions-grid">
            <a href="{{ route('penanaman.create') }}" class="quick-action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Penanaman</span>
            </a>
            <a href="{{ route('perawatan.create') }}" class="quick-action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Perawatan</span>
            </a>
            <a href="{{ route('pemanenan.create') }}" class="quick-action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Pemanenan</span>
            </a>
        </div>
    </div>
</div>
@endsection
