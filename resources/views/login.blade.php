<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SI-PKL</title>
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

<body class="bg-blue-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full mx-4 max-w-sm">
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-16">
        </div>
    
        <!-- Teks Masuk -->
        <h2 class="text-2xl font-semibold mb-6 text-center">Masuk</h2>
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action={{ route('login') }}>
            <!-- CSRF Token -->
            @csrf
            <div class="text-sm">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="you@gmail.com">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-2">Kata Sandi</label>
                <div class="input-container">
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukkan Kata Sandi">
                    <i id="togglePassword" class="fas fa-eye"></i>
                </div>
            </div>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <input type="checkbox" id="remember_me" name="remember" class="mr-2">
                    <label for="remember" class="text-gray-700">Ingat Saya</label>
                </div>
            </div>
            <button
                class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Masuk</button>
        </form>
        <p class="mt-6 text-center text-gray-700">Belum punya akun? <a href="{{ route('register') }}"
                class="text-blue-500">Daftar sekarang</a></p>
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
    </script>
</body>

</html>
