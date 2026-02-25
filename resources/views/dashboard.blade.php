<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-10 text-gray-900 dark:text-gray-100 text-center">
    <div class="text-2xl font-semibold mb-8">
        You're logged in!
    </div>

    @if(auth()->user()->role?->slug === 'admin')
        <a href="/admin"
           class="block p-6 border border-gray-300 dark:border-gray-600 rounded-lg 
                  bg-white dark:bg-gray-800 shadow hover:shadow-lg 
                  text-gray-800 dark:text-gray-200 transition mx-auto max-w-md">
            <div class="font-semibold text-xl">Admin Panel</div>
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Manage users, roles and permissions
            </div>
        </a>
    @endif
</div>


            </div>
        </div>
    </div>
</x-app-layout>
