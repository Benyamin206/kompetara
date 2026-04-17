@if(session('success'))
<div class="bg-green-500 text-white p-2 mb-3 rounded">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-500 text-white p-2 mb-3 rounded">
    {{ session('error') }}
</div>
@endif