<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Akun Kasir - POS Barokah Mart</title>
</head>

<body>
    <h2>Akun Kasir</h2>
    <a href="{{ route('users.create') }}">+ Tambah Kasir</a>

    <table border="1" cellpadding="6" style="margin-top: 10px">
        <tr>
            <th>Nama</th>
            <th>Email</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>