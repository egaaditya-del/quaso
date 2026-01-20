@extends('layouts.app')

@section('title', 'Daftar Keluarga')

@section('content')
<div class="mb-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Daftar Anggota Keluarga</h1>
    <p class="text-gray-600">Kelola data anggota keluarga Anda dengan mudah</p>
</div>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Total Anggota: {{ $families->total() }}</h2>
        <a href="{{ route('families.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-plus"></i> Tambah Anggota
        </a>
    </div>

    @if($families->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tanggal Lahir</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($families as $family)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            <a href="{{ route('families.show', $family) }}" class="text-purple-600 hover:underline">
                                {{ $family->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($family->gender)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $family->gender === 'Laki-laki' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    @if($family->gender === 'Laki-laki')
                                        <i class="fas fa-mars mr-1"></i>
                                    @else
                                        <i class="fas fa-venus mr-1"></i>
                                    @endif
                                    {{ $family->gender }}
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @if($family->birth_date)
                                {{ $family->birth_date->format('d M Y') }} ({{ $family->age }} tahun)
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $family->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $family->status === 'Hidup' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $family->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('families.show', $family) }}" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('families.edit', $family) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('families.destroy', $family) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $families->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
            <p class="text-gray-600 mb-4">Belum ada data anggota keluarga</p>
            <a href="{{ route('families.create') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-plus"></i> Tambah Anggota Pertama
            </a>
        </div>
    @endif
</div>
@endsection
