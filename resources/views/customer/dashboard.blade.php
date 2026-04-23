<x-app-layout>
<div class="p-6 space-y-6">

<x-flash />

<h1 class="text-2xl font-bold text-gray-800">
    Customer Dashboard
</h1>

{{-- 🔥 STATS CARD --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white p-5 rounded-xl shadow">
        <p class="text-sm opacity-80">Total EXP</p>
        <p class="text-3xl font-bold">
            {{ $profile->total_exp ?? 0 }}
        </p>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-5 rounded-xl shadow">
        <p class="text-sm opacity-80">Level</p>
        <p class="text-3xl font-bold">
            {{ $profile->level ?? 0 }}
        </p>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-700 text-white p-5 rounded-xl shadow">
        <p class="text-sm opacity-80">Progress Level</p>

        @php
            $exp = $profile->total_exp ?? 0;
            $currentLevelExp = $exp % 100;
        @endphp

        <p class="text-lg font-bold">
            {{ $currentLevelExp }} / 100 EXP
        </p>

        <div class="w-full bg-white/30 rounded-full h-2 mt-2">
            <div class="bg-white h-2 rounded-full"
                 style="width: {{ $currentLevelExp }}%"></div>
        </div>
    </div>

</div>

{{-- 🔥 COURSE LIST --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">

@foreach($courses as $course)

<div class="border rounded-xl p-4 shadow-sm bg-white">

    {{-- ✅ GAMBAR COURSE --}}
    @if($course->image_url)
        <img src="{{ $course->image_url }}"
             class="w-full h-40 object-cover rounded-lg mb-3">
    @endif

    <h2 class="font-bold text-lg text-gray-800">
        {{ $course->title }}
    </h2>

    <p class="text-gray-500 text-sm mt-1">
        {{ $course->description }}
    </p>

    @php
        $enroll = $enrollments->where('course_id', $course->id)->first();
    @endphp

    <div class="mt-3">

        @if(!$enroll)
            <form method="POST" action="{{ route('customer.enroll.store', $course->id) }}">
                @csrf
                <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded w-full">
                    Enroll
                </button>
            </form>
        @else
            
            <p class="text-sm text-gray-600">
                Status:
                <span class="font-semibold">{{ $enroll->status }}</span>
            </p>

            @if($enroll->status === 'enrolled')

                <a href="{{ route('customer.materials.index', $course->id) }}"
                   class="mt-2 block bg-green-500 hover:bg-green-600 text-white text-center px-3 py-2 rounded">
                    Lihat Materi
                </a>

                @php
                    $firstQuiz = $course->quizzes->first();
                @endphp

                @if($firstQuiz)
                    <a href="{{ route('customer.quizzes.show', [$course->id, $firstQuiz->id]) }}"
                       class="mt-2 block bg-purple-500 hover:bg-purple-600 text-white text-center px-3 py-2 rounded">
                        Quiz
                    </a>
                @else
                    <p class="text-sm text-gray-400 mt-2">
                        Belum ada quiz
                    </p>
                @endif

            @endif

        @endif

    </div>

</div>

@endforeach

</div>

</div>
</x-app-layout>