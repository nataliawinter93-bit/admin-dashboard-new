<x-admin-layout title="Admin Panel">

    <h1 class="text-3xl font-bold">Admin Panel</h1>

    <p class="mt-4 text-gray-700">
        Welcome, administrator!
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-8">

        <a href="{{ route('admin.users.index') }}"
           class="block p-6 bg-white shadow rounded hover:bg-gray-50 text-center">
            <span class="text-xl font-semibold">Users</span>
        </a>

        <a href="{{ route('admin.roles.index') }}"
           class="block p-6 bg-white shadow rounded hover:bg-gray-50 text-center">
            <span class="text-xl font-semibold">Roles</span>
        </a>

        <a href="{{ route('admin.permissions.index') }}"
           class="block p-6 bg-white shadow rounded hover:bg-gray-50 text-center">
            <span class="text-xl font-semibold">Permissions</span>
        </a>

        <a href="{{ route('admin.logs.index') }}"
           class="block p-6 bg-white shadow rounded hover:bg-gray-50 text-center">
            <span class="text-xl font-semibold">Activity Logs</span>
        </a>

    </div>

    <div class="mt-6 p-4 bg-white shadow rounded">
    <p class="mb-4">Statistics, charts and system management will appear here.</p>

    <a href="{{ route('admin.analytics') }}"
       class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        View Analytics
    </a>
</div>


</x-admin-layout>
