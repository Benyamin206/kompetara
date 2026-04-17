<x-app-layout>
<div class="p-6">

<h1 class="font-bold text-xl">{{ $course->title }}</h1>

{{-- LIST MATERIAL (DRAG & DROP AREA) --}}
<div id="materials-list" class="mt-4">

@foreach($materials as $material)
<div class="border p-3 mb-2 bg-white" data-id="{{ $material->id }}">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <p class="font-bold">
                {{ $material->order_number }}. {{ $material->title }}
            </p>

            <p class="text-sm text-gray-600">
                EXP: {{ $material->exp_reward }}
            </p>
        </div>

        {{-- ACTION BUTTONS --}}
        <div class="space-x-1">

            {{-- PREVIEW --}}
            <a href="{{ route('owner.materials.preview', $material->id) }}"
               class="bg-blue-500 text-white px-2 py-1 text-sm">
                Preview
            </a>

            {{-- EDIT --}}
            <a href="{{ route('owner.materials.edit', $material->id) }}"
               class="bg-yellow-500 text-white px-2 py-1 text-sm">
                Edit
            </a>

            {{-- DELETE --}}
            <form method="POST"
                  action="{{ route('owner.materials.destroy', $material->id) }}"
                  class="inline">
                @csrf
                @method('DELETE')

                <button class="bg-red-500 text-white px-2 py-1 text-sm"
                        onclick="return confirm('Hapus materi ini?')">
                    Hapus
                </button>
            </form>

        </div>
    </div>

</div>
@endforeach

</div>

</div>

{{-- SORTABLE JS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
let el = document.getElementById('materials-list');

new Sortable(el, {
    animation: 150,
    onEnd: function () {
        let order = [];

        document.querySelectorAll('#materials-list > div').forEach((item, index) => {
            order.push({
                id: item.dataset.id,
                order_number: index + 1
            });
        });

        fetch("{{ route('owner.materials.reorder') }}", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order })
        });
    }
});
</script>

</x-app-layout>