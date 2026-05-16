<x-app-layout>
<div class="p-4 sm:p-6">

    <x-flash />

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">
            Admin Dashboard
        </h1>

        <a href="/admin/users"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center w-full sm:w-auto">
            Kelola Pemilik Course
        </a>
    </div>

    {{-- MENU / FITUR --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">

        {{-- CARD USER --}}
        <div class="bg-white border rounded-xl shadow-sm hover:shadow-md transition p-5 flex flex-col">

            <div class="mb-3">
                <h2 class="font-semibold text-lg text-gray-800">
                    👥 Manajemen Pemilik Course
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola pemilik course dan akun lainnya
                </p>
            </div>

            <a href="/admin/users"
               class="mt-auto block text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
                Buka Menu
            </a>
        </div>

        {{-- CARD FUTURE --}}
        <div class="bg-white border rounded-xl shadow-sm p-5 flex flex-col opacity-70">

            <div class="mb-3">
                <h2 class="font-semibold text-lg text-gray-800">
                    📊 Statistik
                </h2>
                <p class="text-sm text-gray-500">
                    Insight data platform (coming soon)
                </p>
            </div>

            <button class="mt-auto bg-gray-300 text-gray-600 px-3 py-2 rounded-lg text-sm cursor-not-allowed">
                Segera Hadir
            </button>
        </div>

    </div>

</div>
</x-app-layout>