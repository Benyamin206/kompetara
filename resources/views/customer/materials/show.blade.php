<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">{{ $material->title }}</h1>

<div class="mt-4">
    {!! nl2br(e($material->content)) !!}
</div>

<div class="mt-6">

@if(!$progress || !$progress->is_completed)

    <form method="POST" action="{{ route('customer.materials.complete', [$course->id, $material->id]) }}">
        @csrf
        <button class="bg-green-500 text-white px-3 py-1">
            Selesai
        </button>
    </form>

    <a href="{{ route('customer.materials.index', $course->id) }}"
       class="block mt-2 text-blue-500">
       Kembali
    </a>

@else

    <p class="text-green-600">Anda telah menyelesaikan materi ini</p>

    <a href="{{ route('customer.materials.index', $course->id) }}"
       class="block mt-2 text-blue-500">
       Kembali
    </a>

@endif

</div>

</div>
</x-app-layout>