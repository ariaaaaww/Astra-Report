@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pemeriksaan & Review Tugas</h1>
                <p class="text-gray-600 text-sm">Daftar laporan tugas yang dikumpulkan oleh dealer</p>
            </div>
        </div>

        <form method="GET" action="{{ route('task-reviews.index') }}"
            class="mb-6 flex flex-wrap items-end gap-3 border border-[#E5E3DB] bg-white p-5">

            {{-- Input Pencarian Nama Laporan --}}
            <div class="min-w-55 flex-1">
                <label for="search" class="mb-1 block text-[11px] uppercase tracking-[0.15em] text-[#16213A]">Cari</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nama Laporan..."
                    class="w-full border border-[#E5E3DB] px-3 py-2 text-sm focus:border-[#16213A] focus:outline-none">
            </div>

            {{-- Filter Departemen --}}
            <div>
                <label for="department_id"
                    class="mb-1 block text-[11px] uppercase tracking-[0.15em] text-[#16213A]">Departemen</label>
                <select name="department_id" id="department_id"
                    class="border border-[#E5E3DB] px-3 py-2 text-sm focus:border-[#16213A] focus:outline-none">
                    <option value="">Semua Departemen</option>
                    @foreach ($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Area --}}
            <div>
                <label for="area_id" class="mb-1 block text-[11px] uppercase tracking-[0.15em] text-[#16213A]">Area</label>
                <select name="area_id" id="area_id"
                    class="border border-[#E5E3DB] px-3 py-2 text-sm focus:border-[#16213A] focus:outline-none">
                    <option value="">Semua Area</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                class="bg-[#16213A] px-5 py-2 text-sm font-medium text-white transition hover:bg-[#26324f]">
                Terapkan
            </button>

            {{-- Tombol Reset Filter --}}
            @if (request()->anyFilled(['search', 'department_id', 'area_id']))
                <a href="{{ route('task-reviews.index') }}"
                    class="border border-red-500 px-4 py-2 text-sm font-medium text-red-500 hover:bg-red-50">
                    Reset
                </a>
            @endif
        </form>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                            Tugas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dealer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu
                            Kumpul</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($submissions as $submission)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $submission->task->title ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $submission->dealer->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $submission->updated_at ? $submission->updated_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($submission->status === 'DISETUJUI')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">DISETUJUI</span>
                                @elseif($submission->status === 'REVISI')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">REVISI</span>
                                @elseif($submission->status === 'DITOLAK')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">DITOLAK</span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">MENUNGGU</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('task-reviews.show', $submission->id) }}"
                                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-xs transition duration-150">
                                    Periksa / Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada pengumpulan tugas dari
                                dealer.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $submissions->links() }}
        </div>
    </div>
@endsection
