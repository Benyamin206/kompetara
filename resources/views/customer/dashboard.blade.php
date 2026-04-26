<x-app-layout>
<div class="p-6 space-y-6">

    <x-flash />

    {{-- ===========================
         PAGE HEADER
    =========================== --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Customer Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name ?? 'Pengguna' }}!</p>
    </div>

    {{-- ===========================
         STATS CARDS
    =========================== --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Total EXP --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-blue-500 rounded-t-2xl"></div>
            <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-base mb-3">
                ⚡
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total EXP</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">
                {{ number_format($profile->total_exp ?? 0) }}
            </p>
        </div>

        {{-- Level --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-5 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-green-500 rounded-t-2xl"></div>
            <div class="w-9 h-9 bg-green-50 text-green-600 rounded-lg flex items-center justify-center text-base mb-3">
                🎯
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Level</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">
                {{ $profile->level ?? 0 }}
            </p>
        </div>

        {{-- Progress Level --}}
        @php
            $exp = $profile->total_exp ?? 0;
            $currentLevelExp = $exp % 100;
            $remaining = 100 - $currentLevelExp;
        @endphp

        <div class="bg-white border border-gray-200 rounded-2xl p-5 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-purple-500 rounded-t-2xl"></div>
            <div class="w-9 h-9 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-base mb-3">
                📈
            </div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Progress Level</p>
            <p class="text-xl font-bold text-gray-900 mt-1 mb-3">
                {{ $currentLevelExp }} / 100 EXP
            </p>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="bg-purple-500 h-1.5 rounded-full transition-all duration-500"
                     style="width: {{ $currentLevelExp }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-2">
                {{ $remaining }} EXP lagi untuk level berikutnya
            </p>
        </div>

    </div>

    {{-- ===========================
         COURSE LIST
    =========================== --}}
    <div>

        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold text-gray-800">Kursus Tersedia</h2>
            <span class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                {{ $courses->count() }} kursus
            </span>
        </div>

        {{-- Empty State --}}
        @if($courses->isEmpty())
            <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center">
                <div class="text-4xl mb-3">📭</div>
                <p class="text-gray-500 text-sm">Belum ada kursus yang tersedia saat ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                @foreach($courses as $course)

                    @php
                        $enroll = $enrollments->where('course_id', $course->id)->first();
                        $firstQuiz = $course->quizzes->first();
                    @endphp

                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden flex flex-col hover:border-gray-300 transition-colors duration-150">

                        {{-- Course Image --}}
                        @if($course->image_url)
                            <img src="{{ $course->image_url }}"
                                 alt="{{ $course->title }}"
                                 class="w-full h-36 object-cover">
                        @else
                            <div class="w-full h-36 bg-gray-50 flex items-center justify-center text-3xl text-gray-300">
                                📚
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="p-4 flex flex-col gap-2 flex-1">

                            {{-- Status Badge --}}
                            @if(!$enroll)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full w-fit">
                                    Belum Enroll
                                </span>
                            @elseif($enroll->status === 'enrolled')
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-700 px-2.5 py-1 rounded-full w-fit">
                                    ✓ Enrolled
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full w-fit">
                                    {{ ucfirst($enroll->status) }}
                                </span>
                            @endif

                            {{-- Title --}}
                            <h3 class="text-sm font-semibold text-gray-900 leading-snug">
                                {{ $course->title }}
                            </h3>

                            {{-- Description (truncated 2 lines) --}}
                            <p class="text-xs text-gray-400 leading-relaxed line-clamp-2 flex-1">
                                {{ $course->description }}
                            </p>

                            {{-- Progress Bar (only if enrolled) --}}
                            @if($enroll && isset($course->completed_materials_count))
                                @php
                                    $total = $course->materials_count ?? 1;
                                    $done  = $course->completed_materials_count ?? 0;
                                    $pct   = $total > 0 ? round(($done / $total) * 100) : 0;
                                @endphp
                                <div class="mt-1">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Progress materi</span>
                                        <span class="font-medium text-gray-600">{{ $done }}/{{ $total }}</span>
                                    </div>
                                    <div class="h-1 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500 rounded-full"
                                             style="width: {{ $pct }}%"></div>
                                    </div>
                                </div>
                            @endif

                            {{-- Actions --}}
                            <div class="flex flex-col gap-2 mt-2">

                                @if(!$enroll)
                                    {{-- Enroll Button --}}
                                    <form method="POST" action="{{ route('customer.enroll.store', $course->id) }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-center text-xs font-semibold bg-blue-500 hover:bg-blue-600 active:scale-95 text-white px-3 py-2 rounded-lg transition-all duration-150">
                                            Enroll Sekarang
                                        </button>
                                    </form>

                                @elseif($enroll->status === 'enrolled')

                                    {{-- View Materials --}}
                                    <a href="{{ route('customer.materials.index', $course->id) }}"
                                       class="w-full text-center text-xs font-semibold bg-green-50 hover:bg-green-100 text-green-700 px-3 py-2 rounded-lg transition-colors duration-150">
                                        Lanjut Materi
                                    </a>

                                    {{-- Quiz --}}
                                    @if($firstQuiz)
                                        <a href="{{ route('customer.quizzes.show', [$course->id, $firstQuiz->id]) }}"
                                           class="w-full text-center text-xs font-semibold bg-purple-50 hover:bg-purple-100 text-purple-700 px-3 py-2 rounded-lg transition-colors duration-150">
                                            Mulai Quiz
                                        </a>
                                    @else
                                        <div class="w-full text-center text-xs text-gray-400 bg-gray-50 px-3 py-2 rounded-lg">
                                            Belum ada quiz
                                        </div>
                                    @endif

                                @endif

                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        @endif

    </div>

</div>
</x-app-layout>