@props(['title' => 'Admin Panel'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen overflow-y-auto">

    <div class="flex">

        <!-- ЛЕВОЕ МЕНЮ -->
<aside class="w-64 bg-white shadow p-5 overflow-y-auto min-h-screen">

    <h2 class="text-xl font-bold mb-6">Admin Panel</h2>

    <ul class="flex flex-col gap-3">

        <li><a href="{{ route('admin.analytics') }}" class="text-blue-600">Analytics</a></li>

        @can('viewAny', App\Models\User::class)
            <li><a href="{{ route('admin.users.index') }}" class="text-blue-600">User</a></li>
        @endcan

        @can('viewAny', App\Models\Role::class)
            <li><a href="{{ route('admin.roles.index') }}" class="text-blue-600">Role</a></li>
        @endcan

        @can('viewAny', App\Models\Permission::class)
            <li><a href="{{ route('admin.permissions.index') }}" class="text-blue-600">Permissions</a></li>
        @endcan

        <li><a href="{{ route('admin.logs.index') }}" class="text-blue-600">Logs</a></li>

    </ul>

</aside>


        <!-- ОСНОВНОЙ КОНТЕНТ -->
        <main class="flex-1 p-10">
            <x-flash />
            {{ $slot }}
        </main>

    </div>
    @stack('scripts')

</body>
</html>
