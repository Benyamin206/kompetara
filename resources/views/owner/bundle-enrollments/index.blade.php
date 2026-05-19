<x-app-layout>

<div class="p-6">

    <x-flash />

    <h1 class="text-2xl font-bold mb-6">
        Bundle Enrollment Approval
    </h1>

    @forelse($bundleEnrollments as $userId => $enrollments)

        <div class="bg-white border rounded-xl p-5 shadow mb-6">

            {{-- USER INFO --}}
            <div class="mb-4">
                <h2 class="text-lg font-semibold">
                    {{ $enrollments->first()->user->name }}
                </h2>

                <p class="text-sm text-gray-500">
                    {{ $enrollments->first()->user->email }}
                </p>
            </div>

            {{-- COURSE LIST --}}
            <div class="mb-4">

                <h3 class="font-medium mb-2">
                    Pending Courses:
                </h3>

                <ul class="list-disc pl-5 text-sm text-gray-700">

                    @foreach($enrollments as $enrollment)

                        <li>
                            {{ $enrollment->course->title }}
                        </li>

                    @endforeach

                </ul>

            </div>

            {{-- APPROVE BUTTON --}}
            <form method="POST"
                  action="{{ route('owner.bundle-enrollments.approve', $userId) }}">

                @csrf

                <button
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm">
                    Approve Bundle Enrollment
                </button>

            </form>

        </div>

    @empty

        <div class="bg-white border rounded-xl p-6 text-gray-500">
            Tidak ada bundle enrollment pending.
        </div>

    @endforelse

</div>

</x-app-layout>