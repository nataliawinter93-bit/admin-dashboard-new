<x-admin-layout title="Users">

    <h1 class="text-2xl font-bold mb-6">Users</h1>
     <x-flash /> 

    {{-- Filters --}}
<form method="GET" class="mb-6 flex gap-4">

    {{-- Search --}}
    <input
        type="text"
        name="search"
        placeholder="Search..."
        value="{{ request('search') }}"
        class="border rounded p-2"
    >

    {{-- Role --}}
    <select name="role_id" class="border rounded p-2">
        <option value="">All roles</option>
        @foreach ($roles as $role)
            <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                {{ $role->name }}
            </option>
        @endforeach
    </select>

    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Apply filters
    </button>
</form>


    {{-- Кнопка создания пользователя --}}
    <a href="{{ route('admin.users.create') }}"
       class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        + Create User
    </a>

    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
<th class="p-3 text-left text-gray-600 font-semibold">
    <a href="{{ route('admin.users.index', [
        'sort' => 'id',
        'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
        'search' => request('search'),
        'role_id' => request('role_id'),
    ]) }}" class="hover:underline">
        ID
        @if(request('sort') === 'id')
            {{ request('direction') === 'asc' ? '↑' : '↓' }}
        @endif
    </a>
</th>
<th class="p-3 text-left text-gray-600 font-semibold">
    <a href="{{ route('admin.users.index', [
        'sort' => 'name',
        'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
        'search' => request('search'),
        'role_id' => request('role_id'),
    ]) }}" class="hover:underline">
        Name
        @if(request('sort') === 'name')
            {{ request('direction') === 'asc' ? '↑' : '↓' }}
        @endif
    </a>
</th>
<th class="p-3 text-left text-gray-600 font-semibold">
    <a href="{{ route('admin.users.index', [
        'sort' => 'email',
        'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
        'search' => request('search'),
        'role_id' => request('role_id'),
    ]) }}" class="hover:underline">
        Email
        @if(request('sort') === 'email')
            {{ request('direction') === 'asc' ? '↑' : '↓' }}
        @endif
    </a>
</th>
                    <th class="p-3 text-left text-gray-600 font-semibold">Role</th>
                    <th class="p-3 text-left text-gray-600 font-semibold w-48">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3">{{ $user->id }}</td>
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">{{ $user->role?->name ?? '—' }}</td>

                        <td class="p-3 flex gap-2">

                            {{-- Кнопка редактирования --}}
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                Edit
                            </a>

                            {{-- Кнопка удаления --}}
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}"
                                      method="POST"
                                      onsubmit="return confirm('Удалить пользователя?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-400 text-sm italic">
                                    You cannot delete yourself  
                                </span>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>
