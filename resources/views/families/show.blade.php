@extends('layouts.app')

@section('title', 'Detail Anggota Keluarga')

@section('styles')
<style>
    .relationship-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="mb-6">
    <a href="{{ route('families.index') }}" class="text-purple-600 hover:text-purple-800 mb-4 inline-block">
        <i class="fas fa-arrow-left mr-2"></i>Kembali
    </a>
    <h1 class="text-4xl font-bold text-gray-800">{{ $family->name }}</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Main Information -->
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-user-circle text-purple-600 mr-3"></i>Informasi Pribadi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Jenis Kelamin</p>
                    <p class="text-lg text-gray-800 mt-1">
                        @if($family->gender)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $family->gender === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                @if($family->gender === 'Laki-laki')
                                    <i class="fas fa-mars mr-2"></i>
                                @else
                                    <i class="fas fa-venus mr-2"></i>
                                @endif
                                {{ $family->gender }}
                            </span>
                        @else
                            <span class="text-gray-400">Tidak ditentukan</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Status</p>
                    <p class="text-lg text-gray-800 mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $family->status === 'Hidup' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $family->status }}
                        </span>
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Tanggal Lahir</p>
                    <p class="text-lg text-gray-800 mt-1">
                        @if($family->birth_date)
                            {{ $family->birth_date->format('d M Y') }} ({{ $family->age }} tahun)
                        @else
                            <span class="text-gray-400">Tidak ditentukan</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Email</p>
                    <p class="text-lg text-gray-800 mt-1">
                        @if($family->email)
                            <a href="mailto:{{ $family->email }}" class="text-purple-600 hover:underline">
                                {{ $family->email }}
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ditentukan</span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase">Telepon</p>
                    <p class="text-lg text-gray-800 mt-1">
                        @if($family->phone)
                            <a href="tel:{{ $family->phone }}" class="text-purple-600 hover:underline">
                                {{ $family->phone }}
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ditentukan</span>
                        @endif
                    </p>
                </div>
            </div>

            @if($family->address)
                <div class="mt-6 pt-6 border-t">
                    <p class="text-sm font-semibold text-gray-500 uppercase">Alamat</p>
                    <p class="text-gray-800 mt-2">{{ $family->address }}</p>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="mt-8 pt-6 border-t flex gap-4">
                <a href="{{ route('families.edit', $family) }}" class="bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition">
                    <i class="fas fa-edit mr-2"></i>Edit Data
                </a>
                <form method="POST" action="{{ route('families.destroy', $family) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini? Semua hubungan keluarga akan dihapus.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Hapus Data
                    </button>
                </form>
            </div>
        </div>

        <!-- Family Relationships -->
        @if($family->parents->count() > 0 || $family->children->count() > 0)
            <div class="bg-white rounded-lg shadow-lg p-8 mt-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-people-lines text-purple-600 mr-3"></i>Hubungan Keluarga
                </h2>

                @if($family->parents->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">
                            <i class="fas fa-arrow-up text-purple-600 mr-2"></i>Orang Tua
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($family->parents as $parent)
                                <div class="relationship-card rounded-lg p-4 shadow">
                                    <a href="{{ route('families.show', $parent) }}" class="font-semibold hover:underline flex items-center">
                                        <i class="fas fa-user-circle mr-2"></i>{{ $parent->name }}
                                    </a>
                                    <p class="text-sm opacity-90 mt-2">
                                        {{ $parent->pivot->relationship_type }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($family->children->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">
                            <i class="fas fa-arrow-down text-purple-600 mr-2"></i>Anak-Anak
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($family->children as $child)
                                <div class="relationship-card rounded-lg p-4 shadow">
                                    <a href="{{ route('families.show', $child) }}" class="font-semibold hover:underline flex items-center">
                                        <i class="fas fa-user-circle mr-2"></i>{{ $child->name }}
                                    </a>
                                    <p class="text-sm opacity-90 mt-2">
                                        {{ $child->pivot->relationship_type }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div>
        <!-- Quick Stats -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Statistik</h3>
            <div class="space-y-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Orang Tua</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $family->parents->count() }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Anak-Anak</p>
                    <p class="text-2xl font-bold text-green-600">{{ $family->children->count() }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-sm text-gray-600">Total Relasi</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $family->parents->count() + $family->children->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
            <div class="space-y-2">
                <a href="{{ route('families.create') }}" class="block bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Anggota
                </a>
                <a href="{{ route('families.tree') }}" class="block bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-sitemap mr-2"></i>Lihat Pohon
                </a>
                <a href="{{ route('families.index') }}" class="block bg-gray-600 text-white text-center px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-list mr-2"></i>Daftar Lengkap
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
