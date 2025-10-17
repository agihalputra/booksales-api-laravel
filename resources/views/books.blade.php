<!DOCTYPE html>
<html>
<head>
    <title>Books List</title>
</head>
<body>
    <h1>Daftar Buku</h1>
    <table border="1" cellpadding="8">
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Genre</th>
            <th>Author</th>
        </tr>
        @foreach ($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->description }}</td>
            <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>
            <td>{{ $book->stock }}</td>
            <td>{{ $book->genre->name }}</td>
            <td>{{ $book->author->name }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
