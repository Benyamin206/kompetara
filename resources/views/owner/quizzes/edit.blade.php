<x-app-layout>
<div class="p-6 max-w-3xl">

<h1 class="text-2xl font-bold mb-6">
    Edit Quiz
</h1>

<form method="POST"
      enctype="multipart/form-data"
      action="{{ route('owner.quizzes.update', $quiz->id) }}">

    @csrf
    @method('PUT')

    {{-- TYPE --}}
    <div class="mb-4">
        <label class="block font-semibold mb-2">
            Tipe Quiz
        </label>

        <select name="type"
                id="quizType"
                class="w-full border rounded p-2">

            <option value="essay"
                {{ old('type', $quiz->type) == 'essay' ? 'selected' : '' }}>
                Essay
            </option>

            <option value="multiple_choice"
                {{ old('type', $quiz->type) == 'multiple_choice' ? 'selected' : '' }}>
                Multiple Choice
            </option>

        </select>
    </div>

    {{-- QUESTION --}}
    <div class="mb-4">
        <label class="block font-semibold mb-2">
            Pertanyaan
        </label>

        <textarea name="question"
                  class="w-full border rounded p-2"
                  rows="4">{{ old('question', $quiz->question) }}</textarea>

        @error('question')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    {{-- ESSAY --}}
    <div id="essaySection"
         class="{{ old('type', $quiz->type) == 'essay' ? '' : 'hidden' }}">

        <div class="mb-4">
            <label class="block font-semibold mb-2">
                Jawaban Benar
            </label>

            <input type="text"
                   name="correct_answer"
                   value="{{ old('correct_answer', $quiz->correct_answer) }}"
                   class="w-full border rounded p-2">

            @error('correct_answer')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- MULTIPLE CHOICE --}}
    <div id="multipleChoiceSection"
         class="{{ old('type', $quiz->type) == 'multiple_choice' ? '' : 'hidden' }}">

        <label class="block font-semibold mb-3">
            Pilihan Jawaban
        </label>

        @foreach($quiz->type === 'multiple_choice'
            ? $quiz->options
            : range(0,3) as $index => $option)

            <div class="flex items-center gap-3 mb-3">

                <input type="radio"
                       name="correct_option"
                       value="{{ $index }}"
                       {{ isset($option->is_correct) && $option->is_correct ? 'checked' : '' }}>

                <input type="text"
                       name="options[{{ $index }}][text]"
                       value="{{ old('options.'.$index.'.text', $option->option_text ?? '') }}"
                       class="flex-1 border rounded p-2"
                       placeholder="Pilihan {{ $index + 1 }}">

            </div>

        @endforeach

        @error('options')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

    </div>

    {{-- EXP --}}
    <div class="mb-4">
        <label class="block font-semibold mb-2">
            EXP Reward
        </label>

        <input type="number"
               name="exp_reward"
               value="{{ old('exp_reward', $quiz->exp_reward) }}"
               class="w-full border rounded p-2">

        @error('exp_reward')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    {{-- ADD IMAGE --}}
    <div class="mb-6">
        <label class="block font-semibold mb-2">
            Tambah Gambar Baru
        </label>

        <input type="file"
               name="images[]"
               multiple
               class="w-full border rounded p-2">
    </div>

    {{-- CURRENT IMAGE --}}
    @if($quiz->images->count())

        <div class="mb-6">

            <label class="block font-semibold mb-3">
                Gambar Saat Ini
            </label>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                @foreach($quiz->images as $img)

                    <div class="border rounded p-2">

                        <img src="{{ $img->image_url }}"
                             class="w-full h-40 object-contain rounded bg-gray-100">

                        <label class="flex items-center gap-2 mt-2 text-red-500 text-sm">

                            <input type="checkbox"
                                   name="delete_images[]"
                                   value="{{ $img->id }}">

                            Hapus gambar

                        </label>

                    </div>

                @endforeach

            </div>

        </div>

    @endif

    <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded">
        Update Quiz
    </button>

</form>

</div>

<script>

const quizType = document.getElementById('quizType');

const essaySection = document.getElementById('essaySection');

const multipleChoiceSection = document.getElementById('multipleChoiceSection');

quizType.addEventListener('change', function() {

    if (this.value === 'essay') {

        essaySection.classList.remove('hidden');
        multipleChoiceSection.classList.add('hidden');

    } else {

        essaySection.classList.add('hidden');
        multipleChoiceSection.classList.remove('hidden');
    }
});

</script>

</x-app-layout>