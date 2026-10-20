@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Tugas</h1>
        <a href="{{ route('tasks.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700">+ Buat Tugas Baru</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="p-4 font-semibold text-gray-600">Nama Laporan</th>
                    <th class="p-4 font-semibold text-gray-600">Departemen</th>
                    <th class="p-4 font-semibold text-gray-600">Area</th>
                    <th class="p-4 font-semibold text-gray-600">Batas Waktu</th>
                    <th class="p-4 font-semibold text-gray-600 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-medium">{{ $task->title }}</td>
                        <td class="p-4">{{ $task->department->name ?? '-' }}</td>
                        <td class="p-4">{{ $task->area->name ?? '-' }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($task->due_at)->format('d/m/Y') }}</td>
                        <td class="p-4 text-center space-x-2">
                            @if ($task->submissions_count > 0)
                                <span class="text-xs text-gray-400 italic">Terkunci (Sudah dikumpulkan)</span>
                            @else
                                <a href="{{ route('tasks.show', $task->id) }}"
                                    class="text-green-600 hover:underline font-medium">Lihat</a>
                                <a href="{{ route('tasks.edit', $task->id) }}"
                                    class="text-yellow-600 hover:underline font-medium">Edit</a>
                                <form action="{{ route('tasks.delete', $task->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin hapus?')"
                                        class="text-red-600 hover:underline font-medium">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada tugas dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
