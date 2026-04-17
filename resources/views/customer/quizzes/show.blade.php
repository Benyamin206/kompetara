<x-app-layout>
<div class="p-6 grid grid-cols-4 gap-6">

{{-- 🔥 FLASH MESSAGE --}}
<div class="col-span-4">
    <x-flash />
</div>

{{-- 🔢 NAVIGASI SOAL --}}
<div class="col-span-1 border rounded p-4 h-fit">
    <h2 class="font-bold mb-3">Daftar Soal</h2>

    <div class="grid grid-cols-4 gap-2">
        @foreach($quizzes as $index => $q)

            @php
                $isDone = isset($progress[$q->id]) && $progress[$q->id]->is_correct;
            @endphp

            <a href="{{ route('customer.quizzes.show', [$course->id, $q->id]) }}"
               class="text-center px-2 py-1 rounded
               {{ $q->id == $quiz->id ? 'bg-blue-500 text-white' : '' }}
               {{ $isDone ? 'bg-green-500 text-white' : 'bg-gray-200' }}">

               {{ $index + 1 }}
            </a>

        @endforeach
    </div>
</div>

{{-- 📖 SOAL --}}
<div class="col-span-3 border rounded p-6">

    <h1 class="text-xl font-bold mb-4">
        {{ $course->title }}
    </h1>

    <p class="mb-4 text-lg font-semibold">
        {{ $quiz->question }}
    </p>

    @php
        $isDone = isset($progress[$quiz->id]) && $progress[$quiz->id]->is_correct;
    @endphp

    @if($isDone)
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
            ✅ Sudah dijawab dengan benar
        </div>
    @else
        <form method="POST" action="{{ route('customer.quizzes.answer', $quiz->id) }}">
            @csrf

            <input type="text" name="answer"
                   class="w-full border rounded p-2 mb-3"
                   placeholder="Masukkan jawaban...">

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Submit Jawaban
            </button>
        </form>
    @endif

</div>

</div>
</x-app-layout>