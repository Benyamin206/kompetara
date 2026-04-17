<x-app-layout>
<div class="p-6">

<x-flash />

<h1 class="text-xl font-bold">Owner Dashboard</h1>

<a href="{{ route('owner.courses.create') }}"
   class="bg-blue-500 text-white px-3 py-2 rounded inline-block mt-3">
   + Tambah Course
</a>

<div class="grid grid-cols-3 gap-4 mt-6">

@foreach($courses as $course)
<div class="border p-4 rounded">

<h2 class="font-bold">{{ $course->title }}</h2>
<p>{{ $course->description }}</p>

<div class="mt-3 space-y-2">

<a href="{{ route('owner.materials.index', $course->id) }}"
   class="block bg-green-500 text-white px-2 py-1 rounded">
   Course Material
</a>

<a href="{{ route('owner.enrollments.index', $course->id) }}"
   class="block bg-yellow-500 text-white px-2 py-1 rounded">
   Enroll Approval
</a>

<a href="{{ route('owner.materials.create', $course->id) }}"
   class="block bg-gray-500 text-white px-2 py-1 rounded">
   Tambah Materi
</a>

</div>

</div>
@endforeach

</div>
</div>
</x-app-layout>