<!DOCTYPE html>
<html>
<head>
    <title>Cetak Hasil Ujian</title>
</head>
<body>
    <div class="container">
        <div class="content-wrapper">
            <table style="width: 100%;">
                <tr>
                    <td width="15%" align="center">
                        <?php if (!empty($logo)) : ?>
                            <img src="<?= $logo ?>" style="width: 80px;">
                        <?php endif; ?>
                    </td>
                    <td width="70%" align="center">
                        <div style="line-height: 1.5;">
                            <span style="font-size: 17px;">SISTEM UJIAN ONLINE</span><br>
                            <span style="font-size: 16px;"><strong></strong></span><br>
                            <span style="font-size: 15px;">
                                
                            </span>
                        </div>
                    </td>
                    <td width="15%"></td>
                </tr>
            </table>
            <hr style="border: 1px solid black; margin-top: 10px;">

            <h3 align="center" style="margin-top: 20px;">Laporan Hasil Ujian</h3>

            <section class="content">
                <table border="1" cellpadding="5" cellspacing="0" style="font-size:11px;" width="100%">
                    <thead align="center" style="background-color:#D3D3D3">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>NIS</th>
                            <th>Mata Pelajaran</th>
                            <th>Waktu Ujian</th>
                            <th>Jenis Ujian</th>
                            <th>Benar</th>
                            <th>Salah</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody style="font-size:9px;">
                        <?php $no = 1; foreach ($cetak as $d): ?>
                            <tr align="center">
                                <td><?= $no++; ?></td>
                                <td><?= $d->nama_siswa; ?></td>
                                <td><?= $d->nis; ?></td>
                                <td><?= $d->nama_matapelajaran; ?></td>
                                <td><?= date('d-m-Y', strtotime($d->tanggal_ujian)); ?> | <?= date('H:i:s', strtotime($d->jam_ujian)); ?></td>
                                <td><?= $d->jenis_ujian; ?></td>
                                <td><?= $d->benar == '' ? "Belum Ujian" : $d->benar; ?></td>
                                <td><?= $d->salah == '' ? "Belum Ujian" : $d->salah; ?></td>
                                <td><?= $d->nilai == '' ? "Belum Ujian" : $d->nilai; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section><br><br><br>

            <div align="center">
                <?php 
                    $date = date("d/m/Y");
                    $jam = date("H:i:s");
                    echo "Laporan dicetak pada tanggal $date Jam $jam"; 
                ?>
            </div>
        </div>
    </div>
</body>
</html>
