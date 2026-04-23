<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">Tambah Course</h1>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('owner.courses.store') }}" class="mt-4">
@csrf

<input name="title"
       value="{{ old('title') }}"
       class="border p-2 w-full"
       placeholder="Judul">

<textarea name="description"
          class="border p-2 w-full mt-2"
          placeholder="Deskripsi">{{ old('description') }}</textarea>

          <input type="file" name="image" class="border p-2 w-full mt-2">

<button class="bg-blue-500 text-white px-4 py-2 mt-3">
Simpan
</button>

</form>

</div>
</x-app-layout>