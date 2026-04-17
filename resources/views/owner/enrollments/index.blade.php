<x-app-layout>
<div class="p-6">

<h1 class="text-xl font-bold">Enroll Approval</h1>

<table class="w-full mt-4 border">
<tr>
<th>Nama</th>
<th>Email</th>
<th>Status</th>
<th>Aksi</th>
</tr>

@foreach($enrollments as $e)
<tr class="border">
<td>{{ $e->user->name }}</td>
<td>{{ $e->user->email }}</td>
<td>{{ $e->status }}</td>
<td>
@if($e->status === 'pending')
<form method="POST" action="{{ route('owner.enrollments.approve', $e->id) }}">
@csrf
<button class="bg-green-500 text-white px-2">Approve</button>
</form>
@endif
</td>
</tr>
@endforeach

</table>

</div>
</x-app-layout>