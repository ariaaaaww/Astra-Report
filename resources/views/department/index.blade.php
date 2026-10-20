@extends('layouts.app')

@yield('title')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Departemen</h1>
        <a href="{{ route('department.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700">+ Tambah Departemen</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 font-semibold text-gray-600">Kode Departemen</th>
                    <th class="p-4 font-semibold text-gray-600">Nama Departemen</th>
                    <th class="p-4 font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">{{ $department->code }}</td>
                        <td class="p-4">{{ $department->name }}</td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('department.show', $department->id) }}"
                                class="text-blue-600 hover:underline font-medium">Detail</a>
                            <a href="{{ route('department.edit', $department->id) }}"
                                class="text-yellow-600 hover:underline font-medium">Edit</a>
                            <form action="{{ route('department.delete', $department->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus?')"
                                    class="text-red-600 hover:underline font-medium">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">Belum ada data departemen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
