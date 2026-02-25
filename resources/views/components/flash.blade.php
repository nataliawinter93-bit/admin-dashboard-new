@if (session('success'))
    <div style="
        padding: 10px;
        background: #d1fae5;
        border: 1px solid #10b981;
        color: #065f46;
        border-radius: 5px;
        margin-bottom: 15px;
    ">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="
        padding: 10px;
        background: #fee2e2;
        border: 1px solid #ef4444;
        color: #991b1b;
        border-radius: 5px;
        margin-bottom: 15px;
    ">
        {{ session('error') }}
    </div>
@endif
