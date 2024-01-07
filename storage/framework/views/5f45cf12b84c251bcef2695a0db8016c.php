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

    <h2>Buku List</h2>

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
            <?php $__currentLoopData = $buku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($book->judul_buku); ?></td>
                    <td><?php echo e($book->kategori_buku); ?></td>
                    <td><?php echo e($book->jumlah); ?></td>
                    <td><?php echo e($book->deskripsi); ?></td>
                    <td><a href="<?php echo e(asset('file_buku/' . $book->file_buku)); ?>" target="_blank"><?php echo e(url('/public/file_buku/' . $book->file_buku)); ?></a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

</body>

</html>
<?php /**PATH D:\ProjectKevin\Digital_Perpustakaan\resources\views/exports/buku_pdf.blade.php ENDPATH**/ ?>