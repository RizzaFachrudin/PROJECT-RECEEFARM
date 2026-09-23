@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Selamat Datang di Dashboard Reece Farms</h1>
        <p>Monitor dan kelola operasional pertanian Anda</p>
    </div>

    <div class="dashboard-stats">
        <x-dashboard-card 
            icon="fas fa-seedling"
            title="Total Tanaman"
            value="{{ number_format($stats['total_tanaman']) }}"
            trend="Aktif"
        />

        <x-dashboard-card 
            icon="fas fa-hand-holding-water"
            title="Data Perawatan"
            value="{{ $stats['total_perawatan'] }}"
            trend="Record"
        />

        <x-dashboard-card 
            icon="fas fa-wheat"
            title="Data Pemanenan"
            value="{{ $stats['total_pemanenan'] }}"
            trend="Panen"
        />

        <x-dashboard-card 
            icon="fas fa-shopping-cart"
            title="Data Penjualan"
            value="{{ $stats['total_penjualan'] }}"
            trend="Transaksi"
        />

        <x-dashboard-card 
            icon="fas fa-boxes"
            title="Total Pengadaan Bibit"
            value="{{ number_format($stats['total_pengadaan']) }}"
            trend="Tersedia"
        />

        <x-dashboard-card 
            icon="fas fa-leaf"
            title="Stok Bibit Tersedia"
            value="{{ number_format($stats['stok_bibit']) }}"
            trend="Tersedia"
        />

        <x-dashboard-card 
            icon="fas fa-basket-shopping"
            title="Stok Panen Tersedia"
            value="{{ number_format($stats['stok_panen']) }}"
            trend="Tersedia"
        />

        <div class="dashboard-card" style="flex: 1 1 100%; padding: 1rem;">
            <div class="card-icon">
                <i class="fas fa-money-check-alt"></i>
            </div>
            <div class="card-content">
                <h3 class="card-title">Ringkasan Keuangan</h3>
                <p class="card-value" style="font-size: 14px; line-height: 1.5; text-align: left;">
                    Total Pengeluaran: <strong>Rp {{ number_format($financial['pengeluaran'], 0, ',', '.') }}</strong><br>
                    Total Pemasukan: <strong>Rp {{ number_format($financial['pemasukan'], 0, ',', '.') }}</strong><br>
                    Keuntungan: <strong>Rp {{ number_format($financial['keuntungan'], 0, ',', '.') }}</strong>
                </p>
            </div>
            <div class="card-footer">
                <span class="card-trend">{{ $financial['keuntungan'] >= 0 ? 'Profit' : 'Loss' }}</span>
            </div>
        </div>
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
            <a href="{{ route('penjualan.create') }}" class="quick-action-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Penjualan</span>
            </a>
            <a href="{{ route('penggajian.index') }}" class="quick-action-btn">
                <i class="fas fa-money-check"></i>
                <span>Kelola Penggajian</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateDashboardStats() {
    fetch('{{ route("admin.stats") }}')
        .then(response => response.json())
        .then(data => {
            const cards = document.querySelectorAll('.dashboard-card');
            const values = [
                data.total_tanaman,
                data.total_perawatan,
                data.total_pemanenan,
                data.total_penjualan,
                data.total_pengadaan,
                data.stok_bibit,
                data.stok_panen,
                'Rp ' + number_format(data.pengeluaran, 0, ',', '.'),
                'Rp ' + number_format(data.pemasukan, 0, ',', '.'),
                'Rp ' + number_format(data.keuntungan, 0, ',', '.')
            ];
            
            const labels = ['Total Tanaman', 'Data Perawatan', 'Data Pemanenan', 'Data Penjualan', 'Total Pengadaan Bibit', 'Stok Bibit Tersedia', 'Stok Panen Tersedia', 'Total Pengeluaran', 'Total Pemasukan', 'Keuntungan'];
            
            cards.forEach((card, index) => {
                const valueElement = card.querySelector('.card-value');
                if (valueElement && values[index] !== undefined) {
                    const oldValue = valueElement.textContent.replace(/\./g, '');
                    const newValue = values[index].toString();
                    
                    if (oldValue !== newValue) {
                        // Tampilkan notifikasi perubahan
                        const changeType = getChangeType(oldValue, newValue, labels[index]);
                        if (changeType) {
                            showNotification(changeType.message, changeType.type, 6000);
                        }
                        
                        // Animasi perubahan nilai
                        valueElement.style.transition = 'all 0.5s';
                        valueElement.style.color = '#10b981';
                        valueElement.style.transform = 'scale(1.1)';
                        valueElement.textContent = number_format(values[index], 0, ',', '.');
                        
                        setTimeout(() => {
                            valueElement.style.color = '';
                            valueElement.style.transform = 'scale(1)';
                        }, 1000);
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error updating dashboard:', error);
            showNotification('❌ Gagal memperbarui dashboard', 'error', 5000);
        });
}

function getChangeType(oldValue, newValue, label) {
    const oldVal = parseInt(oldValue) || 0; 
    const newVal = parseInt(newValue) || 0;
    
    if (newVal > oldVal) {
        return {
            message: `📈 ${label} bertambah: ${oldVal} → ${newVal}`,
            type: 'success'
        };
    } else if (newVal < oldVal) {
        return {
            message: `📉 ${label} berkurang: ${oldVal} → ${newVal}`,
            type: 'info'
        };
    }
    
    // Notifikasi khusus untuk stok rendah
    if (label.includes('Stok') && newVal < 10) {
        return {
            message: `⚠️ ${label} menipis: tersisa ${newVal}`,
            type: 'stok-warning'
        };
    }
    
    // Notifikasi khusus untuk stok bibit tersedia yang sedikit
    if (label.includes('Stok Bibit Tersedia') && newVal < 100) {
        return {
            message: `⚠️ Stok bibit menipis: tersisa ${newVal}`,
            type: 'stok-warning'
        };
    }
    
    return null;
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+-Ee.]/g, '');
    const n = !isFinite(+number) ? 0 : +number;
    const prec = !isFinite(+decimals) ? 0 : Math.abs(decimals);
    const sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    const dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
    let s = '';
    const toFixedFix = function (n, prec) {
        const k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (sep) {
        const re = /(-?\d+)(\d{3})/;
        while (re.test(s[0])) {
            s[0] = s[0].replace(re, '$1' + sep + '$2');
        }
    }
    if ((dec_point || '') && s[1] !== undefined) {
        s[1] = s[1] || '';
    }
    return s.join(dec);
}

setInterval(updateDashboardStats, 30000);

document.addEventListener('DOMContentLoaded', function() {
    updateDashboardStats();
});
</script>
@endpush
@endsection