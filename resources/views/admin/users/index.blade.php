@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
                <p class="text-gray-600 text-sm">Kelola akun, role, dan hak akses sistem</p>
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

        <form method="GET" action="{{ route('admin.users.index') }}"
            class="mb-6 flex gap-3 bg-white p-4 border rounded shadow-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                class="flex-1 border px-3 py-2 text-sm rounded focus:outline-none focus:border-blue-500">
            <button type="submit"
                class="bg-[#16213A] text-white px-5 py-2 text-sm font-medium rounded hover:bg-[#26324f]">Cari</button>
        </form>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $user->role === 'Admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'Supervisor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-1 px-3 rounded text-xs mr-1">Edit</a>

                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded text-xs">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Data pengguna tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-6 py-4 bg-gray-50 border-t">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
