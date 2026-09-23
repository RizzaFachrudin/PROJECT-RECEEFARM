
<div class="topbar">
    <div class="topbar-left">
        <button class="mobile-menu-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        
    </div>

    <div class="topbar-right">
        <a href="{{ route('profile.index') }}" class="icon-btn" title="Profile Settings">
            <i class="fa-solid fa-gear"></i>
        </a>

        <div class="user-info">
            <img src="{{ Auth::user()->photo 
                ? asset('storage/' . Auth::user()->photo) 
                : asset('img/default-user.png') }}" 
                 alt="{{ Auth::user()->name }}">

            <div class="user-details">
                <span class="name">
                    {{ Auth::user()->name }}
                </span>
                <span class="role">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.mobile-menu-toggle');
    
    if (window.innerWidth <= 768 && 
        !sidebar.contains(event.target) && 
        !toggle.contains(event.target) &&
        sidebar.classList.contains('active')) {
        sidebar.classList.remove('active');
    }
});
</script>
