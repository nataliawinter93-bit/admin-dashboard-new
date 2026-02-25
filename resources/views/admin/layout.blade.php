<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $title ?? 'Admin Panel' }}
            </h2>

            @unless(request()->routeIs('admin.dashboard'))
    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
        ← Back to admin panel
    </a>
@endunless

        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </div>
    @stack('scripts')
</x-app-layout>
