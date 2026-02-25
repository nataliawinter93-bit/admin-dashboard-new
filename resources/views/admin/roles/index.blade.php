<x-admin-layout title="Roles">

    <h1 class="text-2xl font-bold mb-6">Roles</h1>
<x-flash />

    @can('create', App\Models\Role::class)
        <a href="{{ route('admin.roles.create') }}"
           class="inline-block mb-4 px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
            + Create Role
        </a>
    @endcan

    <div class="bg-white shadow rounded overflow-hidden dark:bwhite">
        <table class="w-full">
            <thead>
    <tr class="border-b bg-gray-50 dark:bg-gray-700">

        {{-- ID --}}
        <th class="p-3 text-left text-gray-700 dark:text-gray-300 font-semibold">
            <a href="{{ route('admin.roles.index', [
                'sort' => 'id',
                'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
            ]) }}" class="hover:underline">
                ID
                @if(request('sort') === 'id')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                @endif
            </a>
        </th>

        {{-- Name --}}
        <th class="p-3 text-left text-gray-700 dark:text-gray-300 font-semibold">
            <a href="{{ route('admin.roles.index', [
                'sort' => 'name',
                'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
            ]) }}" class="hover:underline">
                Name
                @if(request('sort') === 'name')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                @endif
            </a>
        </th>

        {{-- Slug --}}
        <th class="p-3 text-left text-gray-700 dark:text-gray-300 font-semibold">
            <a href="{{ route('admin.roles.index', [
                'sort' => 'slug',
                'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
            ]) }}" class="hover:underline">
                Slug
                @if(request('sort') === 'slug')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                @endif
            </a>
        </th>

        <th class="p-3 text-left text-gray-700 dark:text-gray-300 font-semibold">Actions</th>
    </tr>
</thead>


            <tbody>
                @foreach ($roles as $role)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="p-3">{{ $role->id }}</td>
                        <td class="p-3">{{ $role->name }}</td>
                        <td class="p-3">{{ $role->slug }}</td>

                        <td class="p-3 flex gap-3">

                            @can('update', $role)
                                <a href="{{ route('admin.roles.edit', $role) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $role)
                                @if ($role->slug !== 'admin')
                                    <form action="{{ route('admin.roles.destroy', $role) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this role?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm italic">Cannot delete</span>
                                @endif
                            @endcan

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>
