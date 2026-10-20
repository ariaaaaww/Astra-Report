@extends('layouts.app')

@yield('title')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-2xl">
        <div class="mb-4">
            <a href="{{ route('task-submissions.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke
                Daftar Tugas</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Form Pengumpulan Tugas</h2>

            <!-- Detail Informasi Tugas -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6 border text-sm space-y-2">
                <div>
                    <span class="text-gray-500 block">Nama Laporan:</span>
                    <strong class="text-gray-800 text-base">{{ $task->title }}</strong>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div>
                        <span class="text-gray-500 block">Departemen:</span>
                        <strong class="text-gray-800">{{ $task->department->name ?? '-' }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Area:</span>
                        <strong class="text-gray-800">{{ $task->area->name ?? '-' }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Batas Waktu (Deadline):</span>
                        <strong class="text-red-600">{{ \Carbon\Carbon::parse($task->due_at)->format('d F Y') }}</strong>
                    </div>
                </div>
            </div>

            <form action="{{ route('task-submissions.store', $task->id) }}" method="POST">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Link Google Drive Bukti Pengerjaan <span
                            class="text-red-500">*</span></label>
                    <input type="url" name="drive_link" value="{{ old('drive_link') }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border @error('drive_link') border-red-500 @enderror"
                        placeholder="https://drive.google.com/..." required>
                    @error('drive_link')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan / Pesan (Opsional)</label>
                    <textarea name="notes" rows="3"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border"
                        placeholder="Tambahkan catatan untuk supervisor jika ada...">{{ old('notes') }}</textarea>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    Kirim Pengumpulan
                </button>
            </form>
        </div>
    </div>
@endsection
