<x-admin-layout title="Edit User">

    <h1 class="text-2xl font-bold mb-6">Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name"
                   class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                   value="{{ $user->name }}" required>
        </div>

        {{-- Email --}}
        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email"
                   class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500"
                   value="{{ $user->email }}" required>
        </div>

        {{-- Password --}}
        <div>
            <label class="block mb-1 font-medium">Password (optional)</label>
            <input type="password" name="password"
                   class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Role --}}
        <div>
            <label class="block mb-1 font-medium">Role</label>
            <select name="role_id"
                    class="w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring-blue-500">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" @selected($user->role_id == $role->id)>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Buttons --}}
        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Update
        </button>
    </form>

</x-admin-layout>
