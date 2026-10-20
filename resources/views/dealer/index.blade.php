@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Dealer</h1>
    <a href="{{ route('dealer.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700">+ Tambah Dealer</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="p-4 font-semibold text-gray-600">Kode Dealer</th>
                <th class="p-4 font-semibold text-gray-600">Nama Dealer</th>
                <th class="p-4 font-semibold text-gray-600 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dealers as $dealer)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4">{{ $dealer->code }}</td>
                <td class="p-4">{{ $dealer->name }}</td>
                <td class="p-4 text-center space-x-2">
                    <a href="{{ route('dealer.show', $dealer->id) }}" class="text-green-600 hover:underline font-medium">Lihat</a>
                    <a href="{{ route('dealer.edit', $dealer->id) }}" class="text-yellow-600 hover:underline font-medium">Edit</a>
                    <form action="{{ route('dealer.delete', $dealer->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:underline font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-500">Belum ada data.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection