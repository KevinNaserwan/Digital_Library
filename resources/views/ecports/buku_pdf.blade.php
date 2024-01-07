<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku PDF Export</title>
    <style>
        /* Add your custom styles here */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>Data Buku</h2>

    <table>
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Kategori Buku</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
                <th>Link Buku</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buku as $book)
                <tr>
                    <td>{{ $book->judul_buku }}</td>
                    <td>{{ $book->kategori_buku }}</td>
                    <td>{{ $book->jumlah }}</td>
                    <td>{{ $book->deskripsi }}</td>
                    <td><a href="{{ asset('file_buku/' . $book->file_buku) }}" target="_blank">{{ url('/public/file_buku/' . $book->file_buku) }}</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
