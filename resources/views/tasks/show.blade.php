@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Tugas</h1>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <span class="text-gray-500 text-sm block">Nama Laporan</span>
            <span class="text-lg font-semibold text-gray-800">{{ $task->title }}</span>
        </div>
        <div>
            <span class="text-gray-500 text-sm block">Batas Waktu (Deadline)</span>
            <span class="text-lg font-semibold text-gray-800">{{ \Carbon\Carbon::parse($task->due_at)->format('d F Y') }}</span>
        </div>
        <div>
            <span class="text-gray-500 text-sm block">Departemen</span>
            <span class="text-lg font-semibold text-gray-800">{{ $task->department->name ?? '-' }}</span>
        </div>
        <div>
            <span class="text-gray-500 text-sm block">Area</span>
            <span class="text-lg font-semibold text-gray-800">{{ $task->area->name ?? '-' }}</span>
        </div>
        <div>
            <span class="text-gray-500 text-sm block">Dibuat Oleh</span>
            <span class="text-lg font-semibold text-gray-800">{{ $task->creator->name ?? 'Supervisor' }}</span>
        </div>
    </div>

    <div class="flex space-x-3">
        @if(($task->submissions_count ?? 0) === 0)
            <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-600">Edit</a>
        @endif
        <a href="{{ route('tasks.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400">Kembali</a>
    </div>
</div>
@endsection