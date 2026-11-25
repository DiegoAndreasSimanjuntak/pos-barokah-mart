<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Tambah Kasir - POS Barokah Mart</title>
</head>

<body>
    <h2>Tambah Akun Kasir</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <p>Nama<br><input type="text" name="name" value="{{ old('name') }}"></p>
        <p>Email<br><input type="email" name="email" value="{{ old('email') }}"></p>
        <p>Password<br><input type="password" name="password"></p>
        <p>Konfirmasi Password<br><input type="password" name="password_confirmation"></p>
        @if ($errors->any())
            <p style="color: red">{{ $errors->first() }}</p>
        @endif
        <button type="submit">Simpan</button>
    </form>
</body>

</html>