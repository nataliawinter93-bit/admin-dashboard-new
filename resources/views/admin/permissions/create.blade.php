<x-admin-layout title="Create Permission">

    <h1 class="text-2xl font-bold mb-6">Create Permission</h1>

    <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name"
                   class="w-full border border-gray-300 dark:border-gray-600 p-2.5 rounded-md
                          focus:ring focus:ring-blue-200 focus:border-blue-500 dark:bg-gray-800"
                   required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <input type="text" name="description"
                   class="w-full border border-gray-300 dark:border-gray-600 p-2.5 rounded-md
                          focus:ring focus:ring-blue-200 focus:border-blue-500 dark:bg-gray-800">
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Create
        </button>
    </form>

</x-admin-layout>
