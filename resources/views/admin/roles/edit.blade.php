<x-admin-layout title="Edit Role">

    <h1 class="text-2xl font-bold mb-6">Edit Role: {{ $role->name }}</h1>
    <x-flash />

    <form action="{{ route('admin.roles.update', $role) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Role Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded"
                   value="{{ $role->name }}" required>
        </div>
<div>
    <label class="block mb-1 font-medium">Slug</label>
    <input type="text" name="slug" class="w-full border p-2 rounded"
           value="{{ $role->slug }}" required>
</div>

        <div>
            <label class="block mb-1 font-medium">Permissions</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($permissions as $permission)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="permissions[]"
                               value="{{ $permission->id }}"
                               @checked($role->permissions->contains($permission->id))>
                        <span>{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Update
        </button>
    </form>

</x-admin-layout>
