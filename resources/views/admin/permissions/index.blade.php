<x-admin-layout title="Permissions">

    <h1 class="text-2xl font-bold mb-6">Permissions</h1>

    <a href="{{ route('admin.permissions.create') }}"
       class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
        + Create Permission
    </a>

    <!-- White container like in Users -->
    <div class="bg-white shadow rounded overflow-hidden dark:white-800">

        <table class="w-full">
            <thead class="bg-gray-100 dark:bg-gray-700 border-b dark:border-gray-600">
    <tr>

        {{-- ID --}}
        <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">
            <a href="{{ route('admin.permissions.index', [
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
        <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">
            <a href="{{ route('admin.permissions.index', [
                'sort' => 'name',
                'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
            ]) }}" class="hover:underline">
                Name
                @if(request('sort') === 'name')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                @endif
            </a>
        </th>

        {{-- Description --}}
        <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold">
            <a href="{{ route('admin.permissions.index', [
                'sort' => 'description',
                'direction' => request('direction') === 'asc' ? 'desc' : 'asc',
            ]) }}" class="hover:underline">
                Description
                @if(request('sort') === 'description')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                @endif
            </a>
        </th>

        <th class="p-3 text-left text-gray-600 dark:text-gray-300 font-semibold w-48">
            Actions
        </th>

    </tr>
</thead>


            <tbody>
                @foreach ($permissions as $permission)
                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        <td class="p-3">{{ $permission->id }}</td>
                        <td class="p-3">{{ $permission->name }}</td>
                        <td class="p-3">{{ $permission->description }}</td>

                        <td class="p-3 flex items-center gap-3">
                            <a href="{{ route('admin.permissions.edit', $permission) }}"
   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
    Edit
</a>


                            <form action="{{ route('admin.permissions.destroy', $permission) }}"
      method="POST" class="inline-block"
      onsubmit="return confirm('Delete this permission?')">
    @csrf
    @method('DELETE')

    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
        Delete
    </button>
</form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</x-admin-layout>
