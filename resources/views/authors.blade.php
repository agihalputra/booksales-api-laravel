<!DOCTYPE html>
<html>
<head>
    <title>Authors List</title>
</head>
<body>
    <h1>Daftar Penulis</h1>
    <ul>
        @foreach ($authors as $author)
            <li>
                <strong>{{ $author->name }}</strong><br>
                <em>{{ $author->bio }}</em>
            </li>
        @endforeach
    </ul>
</body>
</html>
