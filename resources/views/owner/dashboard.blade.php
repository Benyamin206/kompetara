<x-app-layout>
<div class="p-4 sm:p-6">

<x-flash />

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <h1 class="text-2xl font-bold text-gray-800">
        Owner Dashboard
    </h1>

    <div class="flex flex-col sm:flex-row gap-2">
        <a href="{{ route('owner.courses.create') }}"
           class="bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
            + Tambah Course
        </a>

        <a href="{{ route('owner.bundle-enrollments.index') }}"
           class="border border-slate-300 hover:bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
            Approve Bundle Enrollment
        </a>
    </div>
</div>

{{-- COURSE LIST --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

@foreach($courses as $course)

<div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow p-4 flex flex-col">

    {{-- GAMBAR COURSE --}}
    @if($course->image_url)
        <img src="{{ $course->image_url }}"
             class="w-full h-40 sm:h-44 object-cover rounded-lg mb-3">
    @else
        <div class="w-full h-40 sm:h-44 bg-gray-100 rounded-lg mb-3 flex items-center justify-center text-gray-400 text-sm">
            No Image
        </div>
    @endif

    {{-- TITLE --}}
    <h2 class="font-semibold text-base text-gray-800 line-clamp-1">
        {{ $course->title }}
    </h2>

    {{-- DESCRIPTION --}}
    <p class="text-sm text-gray-500 mt-1 line-clamp-2">
        {{ $course->description }}
    </p>

    {{-- ACTIONS --}}
    <div class="mt-4 space-y-2">

        {{-- Primary action: Edit --}}
        <a href="{{ route('owner.courses.edit', $course->id) }}"
           class="flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
           ✏️ Edit Course
        </a>

        {{-- Secondary actions: outlined style --}}
        <div class="grid grid-cols-2 gap-2">
            <a href="{{ route('owner.materials.index', $course->id) }}"
               class="flex items-center justify-center gap-1 border border-slate-300 hover:bg-slate-50 text-slate-700 px-2 py-2 rounded-lg text-xs font-medium transition-colors text-center">
                Materi
            </a>

            <a href="{{ route('owner.enrollments.index', $course->id) }}"
               class="flex items-center justify-center gap-1 border border-slate-300 hover:bg-slate-50 text-slate-700 px-2 py-2 rounded-lg text-xs font-medium transition-colors text-center">
                Enroll
            </a>

            <a href="{{ route('owner.materials.create', $course->id) }}"
               class="flex items-center justify-center gap-1 border border-slate-300 hover:bg-slate-50 text-slate-700 px-2 py-2 rounded-lg text-xs font-medium transition-colors text-center">
                Tambah Materi
            </a>

            <a href="{{ route('owner.quizzes.index', $course->id) }}"
               class="flex items-center justify-center gap-1 border border-slate-300 hover:bg-slate-50 text-slate-700 px-2 py-2 rounded-lg text-xs font-medium transition-colors text-center">
                Quiz
            </a>
        </div>

        <a href="{{ route('owner.quizzes.create', $course->id) }}"
           class="flex items-center justify-center gap-2 border border-slate-300 hover:bg-slate-50 text-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
           ➕ Tambah Quiz
        </a>

    </div>

</div>

@endforeach

</div>

</div>
</x-app-layout>