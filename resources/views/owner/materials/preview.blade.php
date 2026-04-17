<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">{{ $material->title }}</h1>

<div class="mt-4 border p-4">
    {!! nl2br(e($material->content)) !!}
</div>

<p class="mt-2 text-gray-500">
EXP Reward: {{ $material->exp_reward }}
</p>

<a href="{{ route('owner.dashboard') }}" class="text-blue-500 mt-4 block">
Kembali
</a>

</div>
</x-app-layout>