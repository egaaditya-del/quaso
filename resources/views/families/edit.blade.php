@extends('layouts.app')

@section('title', 'Edit Anggota Keluarga')

@section('content')
<div class="mb-6">
    <h1 class="text-4xl font-bold text-gray-800 mb-2">Edit Anggota Keluarga</h1>
    <p class="text-gray-600">Perbarui informasi anggota keluarga</p>
</div>

<div class="bg-white rounded-lg shadow-lg p-8">
    <form method="POST" action="{{ route('families.update', $family) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $family->name) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $family->email) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="email@example.com">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">
                    Jenis Kelamin
                </label>
                <select name="gender" id="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki-laki" {{ old('gender', $family->gender) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender', $family->gender) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Birth Date -->
            <div>
                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    Tanggal Lahir
                </label>
                <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $family->birth_date ? $family->birth_date->format('Y-m-d') : '') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                @error('birth_date')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Telepon
                </label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $family->phone) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="08123456789">
                @error('phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    <option value="Hidup" {{ old('status', $family->status) === 'Hidup' ? 'selected' : '' }}>Hidup</option>
                    <option value="Meninggal" {{ old('status', $family->status) === 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
                @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                    Alamat
                </label>
                <textarea name="address" id="address" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    placeholder="Masukkan alamat lengkap">{{ old('address', $family->address) }}</textarea>
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4 mt-8 pt-6 border-t">
            <button type="submit" class="bg-purple-600 text-white px-8 py-2 rounded-lg hover:bg-purple-700 transition font-semibold">
                <i class="fas fa-save mr-2"></i>Perbarui Data
            </button>
            <a href="{{ route('families.index') }}" class="bg-gray-300 text-gray-800 px-8 py-2 rounded-lg hover:bg-gray-400 transition font-semibold">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
        </div>
    </form>
</div>
@endsection
