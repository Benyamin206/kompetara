<form method="POST" action="/admin/users">
    @csrf
    <input name="name" placeholder="Nama">
    <input name="email" placeholder="Email">
    <input name="password" type="password" placeholder="Password">
    <button type="submit">Simpan</button>
</form>