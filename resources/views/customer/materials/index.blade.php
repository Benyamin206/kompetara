<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">{{ $course->title }}</h1>

@if($materials->isEmpty())
    <p class="mt-4 text-gray-500">Belum ada materi</p>
@else

<div class="mt-4 space-y-4">
@foreach($materials as $material)

@php
    $mp = $progress[$material->id] ?? null;
@endphp

<div class="border p-4">
    <h2 class="font-bold">
        {{ $material->order_number }}. {{ $material->title }}
    </h2>

    @if(!$mp || !$mp->is_completed)
        <a href="{{ route('customer.materials.show', [$course->id, $material->id]) }}"
           class="bg-blue-500 text-white px-2 py-1 mt-2 inline-block">
           Pelajari
        </a>
    @else
        <a href="{{ route('customer.materials.show', [$course->id, $material->id]) }}"
           class="bg-green-500 text-white px-2 py-1 mt-2 inline-block">
           Lihat kembali materi
        </a>
    @endif

</div>

@endforeach
</div>

@endif

</div>
</x-app-layout>