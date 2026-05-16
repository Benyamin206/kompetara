<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">{{ $material->title }}</h1>



<div class="mt-4 border p-4">
    {!! nl2br(e($material->content)) !!}
</div>

@if($material->images->count())

<div class="mt-4 grid grid-cols-2 gap-4">

    @foreach($material->images as $img)

    <div class="border p-2 rounded">

        <img src="{{ $img->image_url }}"
             class="w-full h-48 object-cover rounded">

        <p class="mt-2 text-center font-semibold">
            {{ $img->name }}
        </p>

    </div>

    @endforeach

</div>

@endif


<p class="mt-2 text-gray-500">
EXP Reward: {{ $material->exp_reward }}
</p>

<a href="{{ route('owner.dashboard') }}" class="text-blue-500 mt-4 block">
Kembali
</a>

</div>
</x-app-layout>