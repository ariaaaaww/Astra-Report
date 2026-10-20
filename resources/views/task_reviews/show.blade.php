@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-4">
            <a href="{{ route('task-reviews.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke Daftar
                Review</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri: Detail Pengumpulan & Form Update Status -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pengumpulan Tugas</h2>

                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                        <div>
                            <span class="text-gray-500 block">Judul Tugas:</span>
                            <strong class="text-gray-800">{{ $submission->task->title ?? '-' }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Nama Dealer:</span>
                            <strong class="text-gray-800">{{ $submission->dealer->name ?? '-' }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Batas Waktu (Due Date):</span>
                            <strong
                                class="text-gray-800">{{ \Carbon\Carbon::parse($submission->task->due_at)->format('d/m/Y') }}</strong>
                        </div>
                        <div>
                            <span class="text-gray-500 block">Status Saat Ini:</span>
                            <span class="font-bold uppercase text-blue-600">{{ $submission->status }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-gray-500 text-sm block mb-1">Link Google Drive Pengumpulan:</span>
                        <a href="{{ $submission->drive_link }}" target="_blank"
                            class="text-blue-600 hover:underline break-all text-sm font-semibold">
                            {{ $submission->drive_link }}
                        </a>
                    </div>

                    <div class="mb-4">
                        <span class="text-gray-500 text-sm block mb-1">Catatan Dealer:</span>
                        <p class="text-gray-800 bg-gray-50 p-3 rounded text-sm border">
                            {{ $submission->notes ?? 'Tidak ada catatan.' }}</p>
                    </div>
                </div>

                <!-- Form Penilaian / Update Status Supervisor -->
                <div class="bg-white rounded-lg shadow p-6 border-t-4 border-blue-600">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Pemeriksaan Supervisor</h3>

                    <form action="{{ route('task-reviews.update', $submission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Pemeriksaan</label>
                            <select name="status"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border"
                                required>
                                <option value="DISETUJUI" {{ $submission->status === 'DISETUJUI' ? 'selected' : '' }}>
                                    DISETUJUI</option>
                                <option value="REVISI" {{ $submission->status === 'REVISI' ? 'selected' : '' }}>REVISI
                                </option>
                                <option value="DITOLAK" {{ $submission->status === 'DITOLAK' ? 'selected' : '' }}>DITOLAK
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Supervisor / Instruksi
                                Revisi</label>
                            <textarea name="notes" rows="3"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border"
                                placeholder="Tulis catatan atau instruksi jika perlu revisi..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
                            Simpan Hasil Pemeriksaan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Kolom Kanan: Riwayat Aktivitas (Task Logs) -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat / Task Logs</h3>

                    <ul class="space-y-4">
                        @forelse($submission->logs as $log)
                            <li class="border-l-2 border-blue-500 pl-4 py-1">
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/y H:i') }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $log->activity }}</p>
                                @if ($log->notes)
                                    <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded mt-1">"{{ $log->notes }}"</p>
                                @endif
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Belum ada riwayat aktivitas.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
