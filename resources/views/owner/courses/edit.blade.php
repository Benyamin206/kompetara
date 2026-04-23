<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">Edit Course</h1>

<form method="POST" enctype="multipart/form-data"
      action="{{ route('owner.courses.update', $course->id) }}" class="mt-4">
    @csrf
    @method('PUT')

    <input name="title"
           value="{{ old('title', $course->title) }}"
           class="border p-2 w-full">

    <textarea name="description"
              class="border p-2 w-full mt-2">{{ old('description', $course->description) }}</textarea>

    <div class="mt-3">
        <label>Gambar Saat Ini</label><br>
        @if($course->image_url)
            <img src="{{ $course->image_url }}" class="w-40 rounded mt-2">
        @endif
    </div>

    <input type="file" name="image" class="border p-2 w-full mt-3">

    <button class="bg-green-500 text-white px-4 py-2 mt-3">
        Update
    </button>

</form>

</div>
</x-app-layout>