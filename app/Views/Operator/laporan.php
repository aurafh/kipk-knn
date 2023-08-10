<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data KIP-Kuliah</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            padding: 5px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            text-align: center;
        }

        th,
        td {
            padding: 5px;
        }

        p {
            text-align: center;
            margin-top: 2px;
            font-size: medium;
            font-weight: bold;
        }
    </style>
</head>
<?php
$session = session();
$periode = $session->get('selectedPeriode'); ?>

<body>
    <div class="container mt-3">
        <div class="text-center">
            <p>DATA PENDAFTAR KIP-KULIAH ITG</p>
            <!-- <p>INSTITUT TEKNOLOGI GARUT</p> -->
            <P>PERIODE <?= $periode; ?></P>
            <hr>
        </div>
        <table class="table table-bordered">
            <thead>
                <th>Nomor</th>
                <th>Nomor Pendaftaran</th>
                <th>Nama Lengkap</th>
                <th>Asal Sekolah</th>
                <th>Program Studi</th>
                <th>Kelayakan</th>
                <th>Ranking</th>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($dataPDF as $data) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['no_pendaftaran'] ?></td>
                        <td><?= $data['nama_siswa'] ?></td>
                        <td><?= $data['nama_sekolah'] ?></td>
                        <td><?= $data['nama_prodi'] ?></td>
                        <td><?= $data['label'] ?> Diterima</td>
                        <td><?= $data['ranking'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>