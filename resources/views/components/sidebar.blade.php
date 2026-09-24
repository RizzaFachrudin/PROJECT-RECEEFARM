<aside class="sidebar"
     style="background-image: url('{{ url('/halaman_depan/images/background.jpeg') }}')">

    <div class="sidebar-header">
        <img src="{{ asset('halaman_depan/images/icons/logo_reece.ico') }}"
             class="logo"
             alt="Logo Reece Farms">
        <span class="brand-text">Reece Farms</span>
    </div>

    @if(auth()->user()->role === 'admin')
        <nav class="menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}" 
                   class="{{ request()->routeIs('penjualan.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Penjualan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manajemen_akun.index') }}" 
                   class="{{ request()->routeIs('manajemen_akun.*') ? 'active' : '' }}">
                    <i class="fas fa-users-cog"></i>
                    <span>Kelola Akun Pegawai</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penggajian.index') }}" 
                   class="{{ request()->routeIs('penggajian.*') ? 'active' : '' }}">
                    <i class="fas fa-wallet"></i>
                    <span>Penggajian</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pengadaan_bibit.index') }}" 
                   class="{{ request()->routeIs('pengadaan_bibit.*') ? 'active' : '' }}">
                    <i class="fas fa-seedling"></i>
                    <span>Pengadaan Bibit</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penanaman.index') }}" 
                   class="{{ request()->routeIs('penanaman.*') ? 'active' : '' }}">
                    <i class="fas fa-leaf"></i>
                    <span>Penanaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perawatan.index') }}" 
                   class="{{ request()->routeIs('perawatan.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-water"></i>
                    <span>Perawatan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemanenan.index') }}" 
                   class="{{ request()->routeIs('pemanenan.*') ? 'active' : '' }}">
                    <i class="fas fa-cut"></i>
                    <span>Pemanenan</span>
                </a>
            </li>
        </nav>
    @endif

    @if(auth()->user()->role === 'user')
        <nav class="menu">
            <li>
                <a href="{{ route('user.dashboard') }}" 
                   class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penanaman.index') }}" 
                   class="{{ request()->routeIs('penanaman.*') ? 'active' : '' }}">
                    <i class="fas fa-leaf"></i>
                    <span>Penanaman</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemanenan.index') }}" 
                   class="{{ request()->routeIs('pemanenan.*') ? 'active' : '' }}">
                    <i class="fas fa-cut"></i>
                    <span>Pemanenan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('perawatan.index') }}" 
                   class="{{ request()->routeIs('perawatan.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-water"></i>
                    <span>Perawatan</span>
                </a>
            </li>
        </nav>
    @endif

    <form action="{{ route('logout') }}" method="POST" id="logoutForm" onsubmit="return confirmLogout(event)">
        @csrf
        <div class="logout">
            <button type="submit">
                <i class="fas fa-sign-out-alt"></i>
                Keluar
            </button>
        </div>
    </form>

    <!-- Confirmation Modal -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-question-circle"></i>
                <h3>Konfirmasi Keluar</h3>
                <button class="modal-close" onclick="closeLogoutModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin keluar dari sistem?</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn btn-cancel" onclick="closeLogoutModal()">
                    <i class="fas fa-times"></i>
                    Batal
                </button>
                <button type="submit" form="logoutForm" class="modal-btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

</aside>

<script>
function confirmLogout(event) {
    event.preventDefault();
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('logoutModal');
    const modalContent = document.querySelector('.modal-content');
    
    if (modal && modalContent && !modalContent.contains(event.target)) {
        modal.style.display = 'none';
    }
});

// Submit form when confirm button clicked
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.querySelector('.btn-logout');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('logoutForm').submit();
        });
    }
});
</script>
