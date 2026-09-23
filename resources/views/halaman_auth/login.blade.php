<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Reece Farm</title>

    <link rel="stylesheet" href="{{ asset('halaman_login/css/Login.css') }}">
    
</head>
<body>

<div class="container">

   
    <div class="left-side">
        <img src="{{ asset('halaman_depan/images/background.jpeg') }}" class="bg-image" alt="">
        <img src="{{ asset('halaman_depan/images/icons/logo_reece.ico') }}" class="logo" alt="">
    </div>

    
    <div class="right-side">

        <h1 class="title">MASUK</h1>

        @if ($errors->any())
            <div class="popup-overlay" id="errorPopup">
                <div class="popup-content">
                    <div class="popup-header">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h3>Login Gagal</h3>
                        <button class="popup-close" onclick="closePopup()">&times;</button>
                    </div>
                    <div class="popup-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="popup-footer">
                        <button class="popup-btn" onclick="closePopup()">OK</button>
                    </div>
                </div>
            </div>
        @endif

       <form action="{{ route('auth.login') }}" method="POST">

    @csrf

    <div class="input-group">
        <input type="text" name="username" value="{{ old('username') }}" placeholder="Nama Pengguna" 
               class="{{ $errors->has('username') ? 'is-invalid' : '' }}" required>
    </div>

    <div class="input-group">
        <input type="password" name="password" placeholder="Kata Sandi" 
               class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required>
    </div>
<div class="btn-wrapper">
    <button type="submit" class="btn-masuk">Masuk</button>

    
</form>


        
        

    </div>

</div>

<script>
function closePopup() {
    const popup = document.getElementById('errorPopup');
    if (popup) {
        popup.style.display = 'none';
    }
}

// Auto close popup 
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('errorPopup');
    if (popup) {
        setTimeout(function() {
            popup.style.display = 'none';
        }, 5000);
    }
});

// Close popup ketika klik di luar popup
document.addEventListener('click', function(event) {
    const popup = document.getElementById('errorPopup');
    const popupContent = document.querySelector('.popup-content');
    
    if (popup && popupContent && !popupContent.contains(event.target)) {
        popup.style.display = 'none';
    }
});
</script>

</body>
</html>
