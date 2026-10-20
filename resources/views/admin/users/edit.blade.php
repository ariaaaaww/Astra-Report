@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-lg">
        <div class="mb-4">
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke Daftar
                Pengguna</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Edit Data Pengguna</h2>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Pengguna (Username)</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border p-2 rounded text-sm focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border p-2 rounded text-sm focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror"
                        required>
                    @error('email')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Role Akun</label>
                    <select name="role"
                        class="w-full border p-2 rounded text-sm focus:outline-none focus:border-blue-500 @error('role') border-red-500 @enderror"
                        required>
                        <option value="Dealer" {{ old('role', $user->role) === 'Dealer' ? 'selected' : '' }}>Dealer</option>
                        <option value="Supervisor" {{ old('role', $user->role) === 'Supervisor' ? 'selected' : '' }}>
                            Supervisor</option>
                        <option value="Admin" {{ old('role', $user->role) === 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
@endsection
