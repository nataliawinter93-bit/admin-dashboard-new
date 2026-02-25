@if (session('success'))
    <div class="mb-4 p-4 bg-green-600 text-black rounded shadow">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-600 text-black rounded shadow">
        {{ session('error') }}
    </div>
@endif
