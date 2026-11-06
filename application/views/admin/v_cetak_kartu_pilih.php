<?php $this->load->view('admin/head'); ?>
<?php $this->load->view('admin/topbar'); ?>
<?php $this->load->view('admin/sidebar'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cetak Kartu Login Peserta</h3>
                </div>
                <form class="form-horizontal" action="<?= base_url('cetak_kartu'); ?>" method="get">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pilih Kelas</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" name="id_kelas" required>
                                    <option value="" selected disabled>- Pilih Kelas -</option>
                                    <?php foreach($kelas as $k) { ?>
                                        <option value="<?= $k->id_kelas ?>" <?= ($this->input->get('id_kelas') == $k->id_kelas) ? 'selected' : ''; ?>>
                                            <?= $k->nama_kelas; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat">Tampilkan Siswa</button>
                    </div>
                </form>
            </div>

            <?php if ($siswa_list !== null): ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Siswa di Kelas Terpilih</h3>
                </div>
                <form action="<?= base_url('cetak_kartu/proses_cetak'); ?>" method="post" target="_blank">
                    <div class="box-body">
                        <input type="hidden" name="id_kelas" value="<?= $this->input->get('id_kelas'); ?>">
                        <p>Berikut adalah daftar siswa yang kartunya akan dicetak. Klik tombol di bawah untuk melanjutkan.</p>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr><th>No</th><th>NIS</th><th>Nama Siswa</th><th>Username</th></tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($siswa_list as $s): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $s->nis; ?></td>
                                    <td><?= $s->nama_siswa; ?></td>
                                    <td><?= $s->username; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger btn-flat"><i class="fa fa-print"></i> Cetak Kartu untuk Kelas Ini</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $this->load->view('admin/js'); ?>
<script>
$(document).ready(function() {
    $('.select2').select2();
});
</script>
<?php $this->load->view('admin/foot'); ?>