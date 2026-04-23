<x-app-layout>
<div class="p-6">

<x-flash />

<h1 class="text-xl font-bold mb-4">
    Quiz - {{ $course->title }}
</h1>

<div class="space-y-4">

@foreach($quizzes as $quiz)

@php
    // $isDone = \App\Models\QuizProgress::where('enrollment_id', $enrollment->id)
    //     ->where('quiz_id', $quiz->id)
    //     ->where('is_correct', true)
    //     ->exists();
        $isDone = in_array($quiz->id, $progress);
@endphp

<div class="border p-4 rounded">

    <p class="font-semibold mb-2">
        {{ $quiz->question }}
    </p>

    @if($quiz->images->count())
    <div class="flex gap-2 mb-3 flex-wrap">
        @foreach($quiz->images as $img)
            <img src="{{ $img->image_url }}"
                 class="w-32 h-32 object-cover rounded border">
        @endforeach
    </div>
@endif

    @if($isDone)
        <div class="bg-green-100 text-green-700 px-3 py-2 rounded">
            ✅ Sudah dijawab dengan benar
        </div>
    @else
        <form method="POST" action="{{ route('customer.quizzes.answer', $quiz->id) }}">
            @csrf

            <input type="text" name="answer"
                   class="w-full border rounded p-2 mb-2"
                   placeholder="Masukkan jawaban...">

            @error('answer')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                Submit Jawaban
            </button>
        </form>
    @endif

</div>

@endforeach

</div>

</div>
</x-app-layout>