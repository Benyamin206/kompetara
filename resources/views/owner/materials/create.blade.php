<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">Tambah Materi</h1>

<form method="POST" action="{{ route('owner.materials.store', $course->id) }}" class="mt-4 space-y-4">
@csrf

<div>
    <label>Urutan Materi</label>
    <input type="number" name="order_number" class="border w-full p-2" required>
</div>

<div>
    <label>Judul</label>
    <input type="text" name="title" class="border w-full p-2" required>
</div>

<div>
    <label>Konten</label>
    <textarea name="content" class="border w-full p-2" rows="5" required></textarea>
</div>

<div>
    <label>EXP Reward</label>
    <input type="number" name="exp_reward" class="border w-full p-2" required>
</div>

<button class="bg-blue-500 text-white px-3 py-2 rounded">
    Tambah
</button>

<a href="{{ route('owner.dashboard') }}" class="ml-2 text-gray-600">
    Batal
</a>

</form>

</div>
</x-app-layout>