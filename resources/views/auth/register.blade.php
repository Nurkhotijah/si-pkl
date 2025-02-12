<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | SI-PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
    <style>
        body {
            background-color: #c7d9f2;
            font-family: 'Poppins', sans-serif;
        }

        .input-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        .input-container i {
            position: absolute;
            right: 12px;
            cursor: pointer;
            color: #6b7280; /* Tailwind's text-gray-500 */
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">

    <div class="w-full mx-4 max-w-lg p-4 bg-white rounded-xl shadow-xl border border-gray-200">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-16">
        </div>
    
        <!-- Teks Masuk -->
        <h2 class="text-2xl font-semibold mb-4 text-center">Daftar</h2>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
        
            <div class="grid grid-cols-1 gap-4 text-sm">
                <!-- Nama Sekolah -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-600 mb-1">Nama Sekolah</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-3 py-2 rounded-lg border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 
                        border-gray-300 @error('name') border-red-500 @enderror"
                        placeholder="Masukkan Nama Sekolah" value="{{ old('name') }}"
                        oninput="removeError('name')">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1 error-message" id="name-error">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <input type="text" id="email" name="email"
                        class="w-full px-3 py-2 rounded-lg border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 
                        border-gray-300 @error('email') border-red-500 @enderror"
                        placeholder="you@gmail.com" value="{{ old('email') }}"
                        oninput="removeError('email')">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1 error-message" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        
            <div class="grid grid-cols-1 gap-4">
                <!-- Alamat -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
                    <input type="text" id="alamat" name="alamat"
                        class="w-full px-3 py-2 rounded-lg border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 
                        border-gray-300 @error('alamat') border-red-500 @enderror"
                        placeholder="Masukkan Alamat Lengkap" value="{{ old('alamat') }}"
                        oninput="removeError('alamat')">
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1 error-message" id="alamat-error">{{ $message }}</p>
                    @enderror
                </div>
        
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Kata Sandi</label>
                    <div class="input-container">
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 rounded-lg border shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 
                            border-gray-300 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan Kata Sandi"
                            oninput="removeError('password')">
                        <i id="togglePassword" class="fas fa-eye"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1 error-message" id="password-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        
            <!-- Checkbox Persetujuan -->
            <div class="mb-4 flex items-center">
                <input type="checkbox" id="agreement" name="agreement"
                    class="h-4 w-4 text-blue-500 border-gray-300 rounded @error('agreement') border-red-500 @enderror"
                    onchange="removeError('agreement')">
                <label for="agreement" class="ml-2 text-sm text-gray-600">Saya setuju dengan <a href="#" class="text-blue-500 hover:text-blue-600 transition duration-300">kebijakan privasi</a> dan ketentuan penggunaan.</label>
            </div>
            @error('agreement')
                <p class="text-red-500 text-sm mt-1 error-message" id="agreement-error">{{ $message }}</p>
            @enderror
        
            <!-- Tombol Daftar -->
            <button type="submit"
                class="w-full py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-300 font-semibold">
                Daftar
            </button>
        </form>
        
        <!-- Login Link -->
        <p class="mt-4 text-center text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:text-blue-600 transition duration-300">Masuk disini</a>
        </p>
    </div>
</div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the icon class
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        function removeError(field) {
        // Hapus border merah
        document.getElementById(field).classList.remove('border-red-500');

        // Hapus pesan error jika ada
        let errorMessage = document.getElementById(field + '-error');
        if (errorMessage) {
            errorMessage.remove();
        }
    }
    </script>
</body>

</html>
