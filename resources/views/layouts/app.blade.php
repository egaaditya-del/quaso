<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Pohon Keluarga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        .tree-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('families.index') }}" class="flex items-center text-2xl font-bold text-purple-600">
                        <i class="fas fa-tree mr-3"></i>
                        Pohon Keluarga
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('families.index') }}" class="text-gray-700 hover:text-purple-600 transition">
                        <i class="fas fa-list"></i> Daftar
                    </a>
                    <a href="{{ route('families.tree') }}" class="text-gray-700 hover:text-purple-600 transition">
                        <i class="fas fa-sitemap"></i> Pohon
                    </a>
                    <a href="{{ route('families.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if ($message = Session::get('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ $message }}</span>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if ($message = Session::get('warning'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ $message }}</span>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <span>&times;</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center text-gray-600">
            <p>&copy; 2026 Aplikasi Pohon Keluarga. Dibuat dengan <i class="fas fa-heart text-red-500"></i></p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
