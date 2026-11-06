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
                    <h3 class="box-title">Filter Siswa Berdasarkan Kelas</h3>
                </div>
                <form class="form-horizontal" action="<?= base_url('peserta_tambah'); ?>" method="get">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Pilih Kelas</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" name="kelas" required="">
                                    <option value="" selected disabled>- Pilih Kelas -</option>
                                    <?php foreach($kelas as $k) { ?>
                                        <option value="<?= $k->id_kelas ?>" <?= ($this->input->get('kelas') == $k->id_kelas) ? 'selected' : ''; ?>>
                                            <?= $k->nama_kelas; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary btn-flat">Tampilkan Siswa</button>
                                <a href="<?= base_url('peserta_tambah'); ?>" class="btn btn-default btn-flat">Reset Filter</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box box-success">
                <form class="form-horizontal" action="<?= base_url('peserta_tambah/insert_'); ?>" method="post">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Peserta & Jadwal Ujian</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mata Pelajaran</label>
                            <div class="col-sm-10">
                                <select class="select2 form-control" name="mapel" required>
                                    <option value="" selected disabled>- Pilih Mata Pelajaran -</option>
                                    <?php foreach($mapel as $m) { ?>
                                        <option value="<?= $m->id_matapelajaran ?>"><?= $m->kode_matapelajaran; ?> | <?= $m->nama_matapelajaran; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tanggal Ujian</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="date" name="tanggal" placeholder="YYYY-MM-DD" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jam Ujian</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="time" name="jam" placeholder="HH:MM" autocomplete="off" required>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Ujian</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="jenis_ujian" required>
                                    <option value="" selected disabled>- Pilih Jenis Ujian -</option>
                                    <?php foreach ($jenis_ujian as $j) { ?>
                                        <option value="<?= $j->id_jenis_ujian ?>"><?= $j->jenis_ujian; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Durasi Ujian (Menit)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="durasi_ujian" placeholder="Contoh: 120" required>
                            </div>
                        </div>

                        <hr>
                        <p class="text-center"><b>Pilih Siswa yang Akan Mengikuti Ujian</b></p>
                        <table id="data" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th>Nama siswa</th>
                                    <th>NIS</th>
                                    <th>Kelas</th>
                                    <th width="13%">
                                        <input type="checkbox" id="cek-semua"/> Pilih Semua
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($siswa as $s) { ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $s->nama_siswa; ?></td>
                                        <td><?= $s->nis; ?></td>
                                        <td><?= $s->nama_kelas; ?></td>
                                        <td>
                                            <input type="checkbox" name="id[]" value="<?= $s->id_siswa; ?>"/>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <a href="<?= base_url('peserta') ?>" class="btn btn-default btn-flat">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-flat pull-right">Simpan Jadwal Ujian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('admin/js'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data').dataTable();

        $('#cek-semua').click(function(){
            $('input:checkbox').prop('checked', this.checked);
        });

        $('#date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
        $('#time').timepicker({
            showInputs: false,
            showMeridian: false,
            minuteStep: 5
        });

        $('.select2').select2();
        $('.alert-message').alert().delay(3000).slideUp('slow');
    });
</script>
<?php $this->load->view('admin/foot'); ?>