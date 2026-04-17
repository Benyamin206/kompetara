<x-app-layout>
<div class="p-6 max-w-lg">

<h1 class="text-xl font-bold mb-4">
    Edit Quiz
</h1>

<form method="POST" action="{{ route('owner.quizzes.update', $quiz->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="block">Pertanyaan</label>
        <textarea name="question" class="w-full border rounded p-2">{{ old('question', $quiz->question) }}</textarea>
        @error('question') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
        <label class="block">Jawaban Benar</label>
        <input type="text" name="correct_answer"
               value="{{ old('correct_answer', $quiz->correct_answer) }}"
               class="w-full border rounded p-2">
        @error('correct_answer') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="mb-3">
        <label class="block">EXP Reward</label>
        <input type="number" name="exp_reward"
               value="{{ old('exp_reward', $quiz->exp_reward) }}"
               class="w-full border rounded p-2">
        @error('exp_reward') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Update Quiz
    </button>
</form>

</div>
</x-app-layout>