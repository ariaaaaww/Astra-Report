{{-- Header Start --}}
<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <div class="flex items-center space-x-8">
            <a href="#" class="font-bold text-xl text-blue-600">ASTRA LMS</a>
            <nav class="hidden md:flex space-x-4">
                @if (auth()->user()->role === 'Supervisor')
                    <a href="{{ route('dealer.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Dealer</a>
                    <a href="{{ route('department.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Department</a>
                    <a href="{{ route('area.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Area</a>
                    <a href="{{ route('tasks.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Tugas</a>
                    <a href="{{ route('task-reviews.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Pemeriksaan</a>
                @elseif (auth()->user()->role === 'Dealer')
                    <a href="{{ route('task-submissions.index') }}" <a href="{{ route('task-submissions.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Pengumpulkan Tugas</a>
                @elseif (auth()->user()->role === 'Admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="text-gray-600 hover:text-blue-600 px-3 py-2 text-sm font-medium">Admin</a>
                @endif
            </nav>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700 font-medium">{{ auth()->user()->name ?? 'User' }}
                ({{ auth()->user()->role ?? 'Role' }})</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
            </form>
        </div>
    </div>
</header>
{{-- Header End --}}
