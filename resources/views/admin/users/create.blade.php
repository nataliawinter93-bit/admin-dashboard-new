<x-admin-layout title="Create User">

    <h1 class="text-2xl font-bold mb-6">Create User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST"
          class="space-y-4 bg-white p-6 rounded shadow max-w-xl">
        @csrf

        {{-- Name --}}
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name"
                   class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email"
                   class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role_id"
                    class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                    required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 transition">
                Cancel
            </a>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Create
            </button>
        </div>

    </form>

</x-admin-layout>
