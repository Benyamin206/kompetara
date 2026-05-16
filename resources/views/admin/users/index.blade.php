<x-app-layout>
<div class="p-4 sm:p-6">

    <x-flash />

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-2xl font-bold text-gray-800">
            Daftar Pemilik Course
        </h1>

        <a href="/admin/users/create"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-center w-full sm:w-auto">
            + Tambah Pemilik Course
        </a>
    </div>

    {{-- TABLE --}}
    <div class="mt-6 bg-white shadow-sm rounded-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                
                {{-- HEAD --}}
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y">

                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">

                        {{-- NAME --}}
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $user->name }}
                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-4">
                            @if($user->is_active)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td class="px-6 py-4 text-right">
                            <a href="{{ url('/admin/users/'.$user->id.'/toggle') }}"
                               class="inline-block px-3 py-1 text-xs rounded-lg
                               {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}
                               text-white transition">
                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center px-6 py-6 text-gray-500">
                            Belum ada user
                        </td>
                    </tr>
                @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>
</x-app-layout>