<x-app-layout>
<div class="p-6 max-w-lg">

<h1 class="text-xl font-bold mb-4">
    Tambah Quiz - {{ $course->title }}
</h1>

{{-- 🔥 GLOBAL ERROR --}}
@if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" enctype="multipart/form-data"
      action="{{ route('owner.quizzes.store', $course->id) }}">
@csrf

{{-- TYPE --}}
<div class="mb-3">
    <label>Tipe Quiz</label>
    <select name="type" id="type" class="w-full border p-2">
        <option value="essay" {{ old('type') == 'essay' ? 'selected' : '' }}>Essay</option>
        <option value="multiple_choice" {{ old('type') == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
    </select>

    @error('type')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

{{-- QUESTION --}}
<div class="mb-3">
    <label>Pertanyaan</label>
    <textarea name="question" class="w-full border p-2">{{ old('question') }}</textarea>

    @error('question')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

{{-- IMAGE --}}
<div class="mb-3">
    <label>Gambar</label>
    <input type="file" name="images[]" multiple class="w-full border p-2">

    @error('images')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

{{-- ESSAY --}}
<div id="essay-box">
    <label>Jawaban Benar</label>
    <input type="text" name="correct_answer"
           value="{{ old('correct_answer') }}"
           class="w-full border p-2">

    @error('correct_answer')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

{{-- MULTIPLE CHOICE --}}
<div id="mc-box" class="hidden mt-3">

    <label>Pilihan Jawaban</label>

    @error('options')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    @for($i=0; $i<4; $i++)
    <div class="flex gap-2 mb-2">
        <input type="radio" name="correct_option" value="{{ $i }}"
            {{ old('correct_option') == $i ? 'checked' : '' }}>

        <input type="text"
               name="options[{{ $i }}][text]"
               value="{{ old("options.$i.text") }}"
               placeholder="Option {{ $i+1 }}"
               class="w-full border p-2">
    </div>
    @endfor

    @error('correct_option')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

</div>

{{-- EXP --}}
<div class="mb-3 mt-3">
    <label>EXP Reward</label>
    <input type="number" name="exp_reward"
           value="{{ old('exp_reward') }}"
           class="w-full border p-2">

    @error('exp_reward')
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

<button class="bg-green-500 text-white px-4 py-2">
    Simpan
</button>

</form>

</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    const isMC = this.value === 'multiple_choice';

    document.getElementById('mc-box').classList.toggle('hidden', !isMC);
    document.getElementById('essay-box').classList.toggle('hidden', isMC);
});
</script>

</x-app-layout>