<x-admin-layout title="Create Role">

    <h1 class="text-2xl font-bold mb-6">Create Role</h1>

    <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Slug</label>
            <input type="text" name="slug" class="w-full border p-2 rounded" required>
        </div>

        <button class="px-4 py-2 bg-black text-white rounded hover:bg-gray-800">
            Create
        </button>
    </form>

</x-admin-layout>
