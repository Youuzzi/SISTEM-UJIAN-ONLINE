<?php
$this->load->view('admin/head');
?>
<?php
$this->load->view('admin/topbar');
$this->load->view('admin/sidebar');
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->session->flashdata('message'); ?>

            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Filter Hasil Ujian</h3>
                </div>
                <form class="form-horizontal" action="<?= base_url('hasil_ujian'); ?>" method="get">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mata Pelajaran</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" name="id">
                                    <option value="">- Tampilkan Semua -</option>
                                    <?php foreach($mapel_list as $mapel) { ?>
                                        <option value="<?= $mapel->id_matapelajaran ?>" <?= ($this->input->get('id') == $mapel->id_matapelajaran) ? 'selected' : ''; ?>>
                                            <?= $mapel->nama_matapelajaran; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary btn-flat">Filter</button>
                                <a href="<?= base_url('hasil_ujian'); ?>" class="btn btn-default btn-flat">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Data Hasil Ujian</h3>
                    <a href="<?= base_url('hasil_ujian/print_all') . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : ''); ?>" class="btn btn-danger btn-flat pull-right" target="_blank"><span class="fa fa-print"></span> Cetak Laporan</a>
                </div>
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Benar</th>
                                <th>Salah</th>
                                <th>Nilai</th>
                                <th>Cetak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($hasil as $h) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $h->nama_siswa; ?></td>
                                    <td><?= $h->nama_kelas; ?></td>
                                    <td><?= $h->nama_matapelajaran; ?></td>
                                    <td><?= $h->benar; ?></td>
                                    <td><?= $h->salah; ?></td>
                                    <td><?= round($h->nilai); ?></td>
                                    <td>
                                        <a href="<?= base_url('hasil_ujian/cetak/' . $h->id_peserta); ?>" class="btn btn-xs btn-success" target="_blank"><span class="fa fa-print"></span></a>
                                    </td>
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
<script type="text/javascript">
$(document).ready(function() {
    // Tambahkan opsi lengthMenu di sini
    $('#data').dataTable({
        "lengthMenu": [ [10, 20, 25, 30, 40, 50, 100], [10, 20, 25, 30, 40, 50, 100] ]
    });

    // Kode Anda yang lain tetap sama
    $('.select2').select2();
    $('.alert-message').alert().delay(3000).slideUp('slow');
});
</script>
<?php
$this->load->view('admin/foot');
?>