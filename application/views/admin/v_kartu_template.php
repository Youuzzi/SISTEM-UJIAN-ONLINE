<!DOCTYPE html>
<html>
<head>
    <title>Cetak Kartu Login</title>
    <style>
        body { font-family: sans-serif; }
        .kartu {
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
            height: 150px; 
            /* Hapus float, width, dan margin dari sini */
        }
        .kop { font-weight: bold; text-align: center; font-size: 14px; }
        .data-siswa { margin-top: 15px; font-size: 12px;}
        .data-siswa td { padding: 3px; }
        h3 { text-align: center; width: 100%; }
    </style>
</head>
<body>
    <h3>KARTU LOGIN SISWA - KELAS <?= $nama_kelas ?></h3>
    <hr>

    <table style="width: 100%; border-spacing: 10px;">
        <?php 
        $i = 0; 
        foreach ($siswa as $s): 
            // Setiap 2 kartu, buat baris baru
            if ($i % 2 == 0) {
                echo '<tr>';
            }
        ?>
            <td style="width: 50%;">
                <div class="kartu">
                    <div class="kop">
                        
                        KARTU AKUN SISWA
                    </div>
                    <div class="data-siswa">
                        <table>
                            <tr>
                                <td width="80px">Nama</td>
                                <td>: <?= $s->nama_siswa ?></td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>: <?= $s->nis ?></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>: <b><?= $s->username ?></b></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>: <b><?= $s->password_plain ?></b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
        <?php 
            // Setiap 2 kartu (atau jika ini kartu terakhir), tutup baris
            if ($i % 2 == 1 || $i == count($siswa) - 1) {
                echo '</tr>';
            }
            $i++;
        endforeach; 
        ?>
    </table>
</body>
</html>