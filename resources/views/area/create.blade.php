@extends('layouts.app')

@yield('title')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Area Baru</h1>

        <form action="{{ route('area.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Kode Area</label>
                <input type="text" name="code" value="{{ old('code') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('code')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nama Area</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex space-x-3">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700">Simpan</button>
                <a href="{{ route('area.index') }}"
                    class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400">Batal</a>
            </div>
        </form>
    </div>
@endsection
