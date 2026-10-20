@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-4">
            <a href="{{ route('task-submissions.index') }}" class="text-blue-600 hover:underline text-sm">&larr; Kembali ke
                Daftar Tugas</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Detail Status & Pengumpulan -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start mb-4 border-b pb-3">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">{{ $submission->task->title }}</h2>
                            <p class="text-gray-500 text-sm">Dikumpulkan pada
                                {{ \Carbon\Carbon::parse($submission->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            @if ($submission->status === 'DISETUJUI')
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">DISETUJUI</span>
                            @elseif($submission->status === 'REVISI')
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">REVISI</span>
                            @elseif($submission->status === 'DITOLAK')
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">DITOLAK</span>
                            @else
                                <span
                                    class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">MENUNGGU</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div>
                            <span class="text-gray-500 block">Link Google Drive Pengumpulan:</span>
                            <a href="{{ $submission->drive_link }}" target="_blank"
                                class="text-blue-600 hover:underline font-semibold break-all">
                                {{ $submission->drive_link }}
                            </a>
                        </div>

                        <div>
                            <span class="text-gray-500 block">Catatan Terakhir dari Anda:</span>
                            <p class="bg-gray-50 p-3 rounded border text-gray-700 mt-1">
                                {{ $submission->notes ?? 'Tidak ada catatan.' }}</p>
                        </div>

                        @if ($submission->status === 'REVISI')
                            <div class="pt-2">
                                <a href="{{ route('task-submissions.edit', $submission->id) }}"
                                    class="inline-block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow transition">
                                    Klik di Sini untuk Mengirimkan Revisi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Kolom Riwayat Log Catatan Supervisor -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Riwayat & Catatan Supervisor</h3>

                    <ul class="space-y-4">
                        @forelse($submission->logs as $log)
                            <li class="border-l-2 border-blue-500 pl-4 py-1">
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/y H:i') }}</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $log->activity }}</p>
                                @if ($log->notes)
                                    <p class="text-xs text-gray-600 bg-gray-50 p-2 rounded mt-1 border">
                                        "{{ $log->notes }}"</p>
                                @endif
                            </li>
                        @empty
                            <li class="text-sm text-gray-500">Belum ada catatan riwayat.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
