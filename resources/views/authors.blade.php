<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors</title>
</head>
<body>
    <h1>Daftar Penulis Buku</h1>

    @foreach ($authors as $item)
        <ul>
            <li><strong>Nama:</strong> {{ $item['name'] }}</li>
            <li><strong>Foto:</strong> {{ $item['photo'] }}</li>
            <li><strong>Bio:</strong> {{ $item['bio'] }}</li>
        </ul>
    @endforeach
</body>
</html>
