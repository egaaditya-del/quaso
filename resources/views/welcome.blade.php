<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aplikasi Pohon Keluarga</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
        <style>
            .hero-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative w-full min-h-screen hero-gradient flex items-center justify-center">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white opacity-10 rounded-full"></div>
            </div>

            <div class="relative z-10 text-center px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <i class="fas fa-tree text-white text-7xl mb-4"></i>
                </div>

                <h1 class="text-5xl sm:text-6xl font-bold text-white mb-6">
                    Aplikasi Pohon Keluarga
                </h1>

                <p class="text-xl sm:text-2xl text-white opacity-90 mb-8 max-w-2xl mx-auto">
                    Kelola dan visualisasikan struktur keluarga Anda dengan mudah dan elegan
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="{{ route('families.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-purple-600 font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                        <i class="fas fa-list mr-3"></i>
                        Mulai Sekarang
                    </a>

                    <a href="{{ route('families.tree') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white bg-opacity-20 text-white font-bold rounded-lg hover:bg-opacity-30 transition transform hover:scale-105 border-2 border-white">
                        <i class="fas fa-sitemap mr-3"></i>
                        Lihat Pohon Keluarga
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 max-w-3xl mx-auto">
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-6 text-white">
                        <i class="fas fa-users text-3xl mb-3"></i>
                        <h3 class="text-lg font-semibold">Kelola Data</h3>
                        <p class="text-sm opacity-80 mt-2">Tambah, edit, dan hapus anggota keluarga dengan mudah</p>
                    </div>

                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-6 text-white">
                        <i class="fas fa-sitemap text-3xl mb-3"></i>
                        <h3 class="text-lg font-semibold">Visualisasi</h3>
                        <p class="text-sm opacity-80 mt-2">Lihat struktur keluarga dalam bentuk pohon interaktif</p>
                    </div>

                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-lg p-6 text-white">
                        <i class="fas fa-mobile-alt text-3xl mb-3"></i>
                        <h3 class="text-lg font-semibold">Responsive</h3>
                        <p class="text-sm opacity-80 mt-2">Akses dari desktop, tablet, atau smartphone</p>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-white border-opacity-20">
                    <p class="text-white opacity-75 text-sm">
                        Aplikasi Pohon Keluarga v1.0 • Dibuat dengan <i class="fas fa-heart text-red-400"></i> untuk memudahkan mengelola keluarga Anda
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
