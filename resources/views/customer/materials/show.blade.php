<x-app-layout>

<div class="max-w-4xl mx-auto p-6">

    {{-- HEADER --}}
    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            {{ $material->title }}
        </h1>

        <p class="text-sm text-gray-500 mt-2">
            EXP Reward:
            <span class="font-semibold text-yellow-600">
                +{{ $material->exp_reward }} EXP
            </span>
        </p>

    </div>

    {{-- CONTENT --}}
    <div class="prose max-w-none bg-white p-6 rounded-xl shadow">

        {!! nl2br(e($material->content)) !!}

    </div>

    {{-- IMAGE GALLERY --}}
    @if($material->images->count())

    <div class="mt-8">

        <h2 class="text-xl font-semibold mb-4">
            Gambar Materi
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            @foreach($material->images as $img)

            <div class="bg-white rounded-xl shadow overflow-hidden">

                <img
                    src="{{ $img->image_url }}"
                    alt="{{ $img->name }}"
                    class="w-full h-56 object-cover hover:scale-105 transition duration-300"
                >

                <div class="p-3">

                    <p class="text-sm font-medium text-gray-700">
                        {{ $img->name }}
                    </p>

                </div>

            </div>

            @endforeach

        </div>

    </div>

    @endif

    {{-- ACTION --}}
    <div class="mt-10">

        @if(!$progress || !$progress->is_completed)

        <form method="POST"
              action="{{ route('customer.materials.complete', [$course->id, $material->id]) }}">

            @csrf

            <button
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">

                Selesaikan Materi

            </button>

        </form>

        @else

        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg">

            Anda telah menyelesaikan materi ini 🎉

        </div>

        @endif

        <a href="{{ route('customer.materials.index', $course->id) }}"
           class="inline-block mt-4 text-blue-600 hover:underline">

            ← Kembali ke daftar materi

        </a>

    </div>

</div>

</x-app-layout>