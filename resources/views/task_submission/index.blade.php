@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Tugas Saya</h1>
                <p class="text-gray-600 text-sm">Kelola dan kumpulkan laporan tugas dealer Anda</p>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                            Laporan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Departemen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas
                            Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tasks as $task)
                        @php
                            $submission = $task->submissions->where('dealer_id', auth()->user()->dealer_id)->first();
                            $status = $submission ? $submission->status : 'BELUM DIKIRIM';
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $task->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $task->department->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($task->due_at)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($status === 'DISETUJUI')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">DISETUJUI</span>
                                @elseif($status === 'REVISI')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">REVISI</span>
                                @elseif($status === 'DITOLAK')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">DITOLAK</span>
                                @elseif($status === 'MENUNGGU')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">MENUNGGU</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">BELUM
                                        DIKIRIM</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                @if ($status === 'DISETUJUI')
                                    <a href="{{ route('task-submissions.show', $submission->id) }}"
                                        class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-3 rounded text-xs transition">
                                        Lihat Status
                                    </a>
                                @elseif($status === 'REVISI')
                                    <a href="{{ route('task-submissions.edit', $submission->id) }}"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded text-xs transition mr-1">
                                        Kirim Revisi
                                    </a>
                                    <a href="{{ route('task-submissions.show', $submission->id) }}"
                                        class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-3 rounded text-xs transition">
                                        Detail
                                    </a>
                                @elseif ($status === 'DITOLAK')
                                    <a href="{{ route('task-submissions.show', $submission->id) }}"
                                        class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-semibold py-1 px-3 rounded text-xs transition">
                                        Lihat Status
                                    </a>
                                @elseif ($status === 'MENUNGGU')
                                    <a href="{{ route('task-submissions.create', ['task' => $task->id]) }}"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-xs transition">
                                        Kumpulkan Tugas
                                    </a>
                                @elseif ($status === 'BELUM DIKIRIM')
                                    <a href="{{ route('task-submissions.create', ['task' => $task->id]) }}"
                                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-xs transition">
                                        Kumpulkan Tugas
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada tugas yang ditugaskan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
