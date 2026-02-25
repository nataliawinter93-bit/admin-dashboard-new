<x-admin-layout title="Activity Logs">

   

    <h1 class="text-2xl font-bold mb-6">Activity Logs</h1>

    {{-- Filters --}}
    <form method="GET" class="mb-6 grid grid-cols-3 gap-4 bg-white p-4 rounded shadow">

        {{-- User --}}
        <div>
            <label class="block text-sm font-medium mb-1">User</label>
            <select name="user_id" class="w-full border-gray-300 rounded">
                <option value="">All</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Action --}}
        <div>
            <label class="block text-sm font-medium mb-1">Action</label>
            <select name="action" class="w-full border-gray-300 rounded">
                <option value="">All</option>
                <option value="create" @selected(request('action') == 'create')>Create</option>
                <option value="update" @selected(request('action') == 'update')>Update</option>
                <option value="delete" @selected(request('action') == 'delete')>Delete</option>
            </select>
        </div>

        {{-- Model --}}
        <div>
            <label class="block text-sm font-medium mb-1">Model</label>
            <select name="model" class="w-full border-gray-300 rounded">
                <option value="">All</option>
                @foreach ($models as $model)
                    <option value="{{ $model }}" @selected(request('model') == $model)>
                        {{ $model }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- Date From --}}
<div>
    <label class="block text-sm font-medium mb-1">From date</label>
    <input type="date" name="from_date" value="{{ request('from_date') }}"
           class="w-full border-gray-300 rounded">
</div>

{{-- Date To --}}
<div>
    <label class="block text-sm font-medium mb-1">To date</label>
    <input type="date" name="to_date" value="{{ request('to_date') }}"
           class="w-full border-gray-300 rounded">
</div>

{{-- Search --}}
<div class="col-span-3">
    <label class="block text-sm font-medium mb-1">Search</label>
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search in URL, User Agent, IP, Model..."
           class="w-full border-gray-300 rounded">
</div>

        <div class="col-span-3">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Apply Filters
            </button>
        </div>
    </form>
<div class="flex justify-end mb-4">
    <button
        onclick="window.location='{{ route('admin.logs.export') }}'"
        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
    >
        Export CSV
    </button>
</div>



    {{-- Logs Table --}}
    <div class="bg-white rounded shadow overflow-hidden overflow-x-auto">
    <table class="w-full text-left min-w-max">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">User</th>
                    <th class="p-3">Action</th>
                    <th class="p-3">Model</th>
                    <th class="p-3">Model ID</th>
                    <th class="p-3">IP</th>
                    <th class="p-3">URL</th>
                    <th class="p-3">Method</th>
                    <th class="p-3">User Agent</th>

                    {{-- SORTABLE DATE --}}
                    <th class="p-3">
                        <a href="{{ route('admin.logs.index', [
                            'direction' => request('direction') === 'asc' ? 'desc' : 'asc'
                        ] + request()->except('direction')) }}">
                            Date
                            @if(request('direction') === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        </a>
                    </th>

                    <th class="p-3">Details</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($logs as $log)
                    <tr class="border-b">
                        <td class="p-3">{{ $log->id }}</td>
                        <td class="p-3">{{ $log->user->name ?? 'System' }}</td>
                        <td class="p-3">{{ $log->action }}</td>
                        <td class="p-3">{{ $log->model }}</td>
                        <td class="p-3">{{ $log->model_id }}</td>

                        <td class="p-3">{{ $log->ip_address }}</td>
                        <td class="p-3 text-blue-600 underline break-all">{{ $log->url }}</td>
                        <td class="p-3">{{ $log->method }}</td>
                        <td class="p-3">{{ Str::limit($log->user_agent, 30) }}</td>

                        <td class="p-3">{{ $log->created_at }}</td>

                        <td class="p-3">
                            <button 
    data-id="{{ $log->id }}"
    onclick="openLogModal(this.dataset.id)"
    class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">
    Details
</button>
<button 
    data-id="{{ $log->id }}"
    onclick="openDiffModal(this.dataset.id)"
    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
>
    Show changes
</button>





                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>

    {{-- MODAL --}}
    <div id="logModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow w-1/2 z-50">
            <h2 class="text-xl font-bold mb-4">Log Details</h2>
<div id="logContent" class="bg-gray-100 p-4 rounded font-sans text-sm whitespace-normal break-words"></div>
            <button onclick="closeLogModal()" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                Close
            </button>
        </div>
    </div>

    @push('scripts')
<script>
    function openLogModal(id) {
    fetch(`/admin/logs/${id}`)
        .then(res => res.json())
        .then(data => {
            let html = '';

            if (data.diff && Object.keys(data.diff).length > 0) {
                for (const [field, values] of Object.entries(data.diff)) {
                    html += `
                        <div class="mb-4">
                            <div class="font-bold text-gray-700 mb-1">${field}</div>
                            <div class="p-2 bg-red-100 rounded mb-1"><strong>Old:</strong> ${values.old ?? '—'}</div>
                            <div class="p-2 bg-green-100 rounded"><strong>New:</strong> ${values.new ?? '—'}</div>
                        </div>
                    `;
                }
            } else {
                html = 'No changes';
            }

            document.getElementById('logContent').innerHTML = html;
            document.getElementById('logModal').classList.remove('hidden');
        });
}


    function openDiffModal(id) {
    fetch(`/admin/logs/${id}`)
        .then(res => res.json())
        .then(data => {
            let html = '';

            if (data.diff && Object.keys(data.diff).length > 0) {
                for (const [field, values] of Object.entries(data.diff)) {
                    html += `
                        <div class="mb-4">
                            <div class="font-bold text-gray-700 mb-1">${field}</div>
                            <div class="p-2 bg-red-100 rounded mb-1"><strong>Old:</strong> ${values.old ?? '—'}</div>
                            <div class="p-2 bg-green-100 rounded"><strong>New:</strong> ${values.new ?? '—'}</div>
                        </div>
                    `;
                }
            } else {
                html = 'No changes';
            }

            document.getElementById('logContent').innerHTML = html;
            document.getElementById('logModal').classList.remove('hidden');
        });
}
function closeLogModal() {
    document.getElementById('logModal').classList.add('hidden');
}

    
</script>
@endpush




</x-admin-layout>
