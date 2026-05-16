<script>
function addImageInput() {

    let wrapper = document.getElementById('image-wrapper');

    wrapper.innerHTML += `
        <div class="border p-3 rounded">
            <input type="file" name="images[]" class="border w-full p-2">

            <input type="text"
                   name="image_names[]"
                   placeholder="Nama gambar"
                   class="border w-full p-2 mt-2">
        </div>
    `;
}
</script>

<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">Tambah Materi</h1>

<form method="POST" enctype="multipart/form-data" action="{{ route('owner.materials.store', $course->id) }}" class="mt-4 space-y-4">
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

<div>
    <label>Gambar Materi</label>

    <div id="image-wrapper" class="space-y-3 mt-2">

        <div class="border p-3 rounded">
            <input type="file" name="images[]" class="border w-full p-2">

            <input type="text"
                   name="image_names[]"
                   placeholder="Nama gambar"
                   class="border w-full p-2 mt-2">
        </div>

    </div>

    <button type="button"
            onclick="addImageInput()"
            class="bg-gray-500 text-white px-3 py-1 rounded mt-2">
        + Tambah Input Gambar
    </button>
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