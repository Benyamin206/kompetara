<x-app-layout>
<div class="p-4 sm:p-6">

<x-flash />

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <h1 class="text-2xl font-bold text-gray-800">
        Owner Dashboard
    </h1>

    <a href="{{ route('owner.courses.create') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center w-full sm:w-auto">
        + Tambah Course
    </a>
</div>

{{-- COURSE LIST --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

@foreach($courses as $course)

<div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition p-4 flex flex-col">

    {{-- ✅ GAMBAR COURSE --}}
    @if($course->image_url)
        <img src="{{ $course->image_url }}"
             class="w-full h-40 sm:h-44 object-cover rounded-lg mb-3">
    @else
        <div class="w-full h-40 sm:h-44 bg-gray-200 rounded-lg mb-3 flex items-center justify-center text-gray-400 text-sm">
            No Image
        </div>
    @endif

    {{-- TITLE --}}
    <h2 class="font-semibold text-lg text-gray-800 line-clamp-1">
        {{ $course->title }}
    </h2>

    {{-- DESCRIPTION --}}
    <p class="text-sm text-gray-600 mt-1 line-clamp-2">
        {{ $course->description }}
    </p>

    {{-- ACTIONS --}}
    <div class="mt-4 space-y-2">

        <a href="{{ route('owner.courses.edit', $course->id) }}"
           class="block text-center bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-2 rounded-lg text-sm">
           ✏️ Edit Course
        </a>

        <a href="{{ route('owner.materials.index', $course->id) }}"
           class="block text-center bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-sm">
           Course Material
        </a>

        <a href="{{ route('owner.enrollments.index', $course->id) }}"
           class="block text-center bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">
           Enroll Approval
        </a>

        <a href="{{ route('owner.materials.create', $course->id) }}"
           class="block text-center bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg text-sm">
           Tambah Materi
        </a>

        <a href="{{ route('owner.quizzes.index', $course->id) }}"
           class="block text-center bg-purple-500 hover:bg-purple-600 text-white px-3 py-2 rounded-lg text-sm">
           Course Quiz
        </a>

        <a href="{{ route('owner.quizzes.create', $course->id) }}"
           class="block text-center bg-pink-500 hover:bg-pink-600 text-white px-3 py-2 rounded-lg text-sm">
           Tambah Quiz
        </a>

    </div>

</div>

@endforeach

</div>

</div>
</x-app-layout>