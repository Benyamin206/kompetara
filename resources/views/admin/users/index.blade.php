<h1>Daftar Pemilik Course</h1>

<a href="/admin/users/create">Tambah</a>

@foreach($users as $user)
<div>
    {{ $user->name }} - {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
    <a href="/admin/users/{{ $user->id }}/toggle">Toggle</a>
</div>
@endforeach