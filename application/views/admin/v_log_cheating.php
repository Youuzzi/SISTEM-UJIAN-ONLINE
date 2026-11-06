<?php
$this->load->view('admin/head');
$this->load->view('admin/topbar');
$this->load->view('admin/sidebar');
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Log Pelanggaran Ujian</h3>
                </div>
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Waktu</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Ujian Mata Pelajaran</th>
                                <th>Jenis Pelanggaran</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($logs as $log) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($log->waktu)); ?></td>
                                    <td><?= $log->nama_siswa; ?></td>
                                    <td><?= $log->nis; ?></td>
                                    <td><?= $log->nama_matapelajaran; ?></td>
                                    <td><span class="label label-warning"><?= $log->jenis_pelanggaran; ?></span></td>
                                    <td><?= $log->detail; ?></td>
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
$this->load->view('admin/js');
?>
<script>
$(document).ready(function() {
    $('#data').DataTable({
        "order": [[ 0, "desc" ]], // Opsi yang sudah ada
        // Tambahkan koma, lalu opsi yang baru
        "lengthMenu": [ [10, 20, 25, 30, 40, 50, 100], [10, 20, 25, 30, 40, 50, 100] ]
    });
});
</script>
<?php
$this->load->view('admin/foot');
?>