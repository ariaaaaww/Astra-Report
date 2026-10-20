@extends('layouts.app')

@yield('title')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Area</h1>

    <div class="space-y-4 mb-6">
        <div>
            <span class="text-gray-500 text-sm block">Kode Area</span>
            <span class="text-lg font-semibold text-gray-800">{{ $area->code }}</span>
        </div>
        <div>
            <span class="text-gray-500 text-sm block">Nama Area</span>
            <span class="text-lg font-semibold text-gray-800">{{ $area->name }}</span>
        </div>
    </div>

    <div class="flex space-x-3">
        <a href="{{ route('area.edit', $area->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-yellow-600">Edit</a>
        <a href="{{ route('area.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-400">Kembali</a>
    </div>
</div>
@endsection