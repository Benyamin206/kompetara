<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold mb-4">
    Quiz - {{ $course->title }}
</h1>

<a href="{{ route('owner.quizzes.create', $course->id) }}"
   class="bg-blue-500 text-white px-3 py-2 rounded">
   + Tambah Quiz
</a>

<div class="mt-4 space-y-3">
@foreach($quizzes as $quiz)
<div class="border p-3 rounded">
    <p class="font-semibold">{{ $quiz->question }}</p>
    <p class="text-sm text-gray-600">Jawaban: {{ $quiz->correct_answer }}</p>
    <p class="text-sm">EXP: {{ $quiz->exp_reward }}</p>
        <div class="mt-2 flex gap-2">
        <a href="{{ route('owner.quizzes.edit', $quiz->id) }}"
           class="bg-yellow-500 text-white px-2 py-1 rounded">
           Edit
        </a>

        <form action="{{ route('owner.quizzes.destroy', $quiz->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button onclick="return confirm('Yakin hapus quiz?')"
                class="bg-red-500 text-white px-2 py-1 rounded">
                Hapus
            </button>
        </form>
    </div>
</div>

@endforeach
</div>

</div>
</x-app-layout>