<?php
$this->load->view('siswa/head');
?>
<?php
$this->load->view('siswa/topbar');
$this->load->view('siswa/sidebar');
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Riwayat & Hasil Ujian Anda</h3>
                </div>
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Mata Pelajaran</th>
                                <th>Jenis Ujian</th>
                                <th>Tanggal Ujian</th>
                                <th>Benar</th>
                                <th>Salah</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (!empty($hasil)) {
                                foreach ($hasil as $h) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $h->nama_matapelajaran; ?></td>
                                        <td><?= $h->jenis_ujian; ?></td>
                                        <td><?= date('d-m-Y', strtotime($h->tanggal_ujian)); ?></td>
                                        <td><span class="label label-success"><?= $h->benar; ?></span></td>
                                        <td><span class="label label-danger"><?= $h->salah; ?></span></td>
                                        <td><span class="label label-primary"><?= round($h->nilai); ?></span></td>
                                    </tr>
                            <?php 
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">Anda belum memiliki riwayat ujian.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$this->load->view('siswa/js');
?>
<script>
$(document).ready(function() {
    $('#data').DataTable();
});
</script>
<?php
$this->load->view('siswa/foot');
?>