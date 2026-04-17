<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">Edit Materi</h1>

<form method="POST" action="{{ route('owner.materials.update', $material->id) }}" class="mt-4 space-y-4">
@csrf
@method('PUT')

<div>
    <label>Urutan</label>
    <input type="number" name="order_number" value="{{ $material->order_number }}" class="border w-full p-2">
</div>

<div>
    <label>Judul</label>
    <input type="text" name="title" value="{{ $material->title }}" class="border w-full p-2">
</div>

<div>
    <label>Konten</label>
    <textarea name="content" class="border w-full p-2">{{ $material->content }}</textarea>
</div>

<div>
    <label>EXP Reward</label>
    <input type="number" name="exp_reward" value="{{ $material->exp_reward }}" class="border w-full p-2">
</div>

<button class="bg-blue-500 text-white px-3 py-2">
Update
</button>

</form>

</div>
</x-app-layout>