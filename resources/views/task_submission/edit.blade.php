@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('task-submissions.show', $submission->id) }}" class="text-blue-600 hover:underline text-sm">&larr; Batal & Kembali ke Detail</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Pengumpulan Ulang / Revisi Tugas</h2>

        <!-- Informasi Catatan/Alasan Revisi Terakhir dari Supervisor -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r">
            <div class="flex">
                <div>
                    <p class="text-sm text-yellow-700 font-bold">Instruksi Revisi dari Supervisor:</p>
                    <p class="text-sm text-yellow-700 italic mt-1">
                        "{{ $submission->logs()->where('activity', 'LIKE', '%revisi%')->latest()->first()->notes ?? 'Silakan periksa kembali berkas tugas Anda.' }}"
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('task-submissions.update', $submission->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Link Google Drive Baru <span class="text-red-500">*</span></label>
                <input type="url" name="drive_link" value="{{ old('drive_link', $submission->drive_link) }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border @error('drive_link') border-red-500 @enderror" required>
                @error('drive_link')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Perubahan (Opsional)</label>
                <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" placeholder="Jelaskan perbaikan yang sudah Anda lakukan...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow transition">
                Kirim Ulang Revisi
            </button>
        </form>
    </div>
</div>
@endsection