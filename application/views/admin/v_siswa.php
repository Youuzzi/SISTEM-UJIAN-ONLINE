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

            <!-- PENAMBAHAN: FORM UNTUK FILTER KELAS -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Filter Siswa</h3>
                </div>
                <form class="form-horizontal" action="<?= base_url('siswa'); ?>" method="get">
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
                                <button type="submit" class="btn btn-primary btn-flat">Tampilkan</button>
                                <a href="<?= base_url('siswa'); ?>" class="btn btn-default btn-flat">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="box box-success" style="overflow-x: scroll;">
                <div class="box-header">
                    <h4 class="box-title" style="margin-left: 10px;">Data Siswa</h4>
                    <?php echo '<button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-data" onclick="$(\'#modal-data-body\').load(\'' . base_url('siswa/create') . '\')"><span class="fa fa-plus"></span> Tambah</button>' ?>
                    <a href="<?php echo base_url('kelas'); ?>"><button type="button" class="btn btn-primary btn-flat"><span></span>Data Kelas</button></a>
                </div>
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Username</th>
                                <th width="12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($siswa as $m) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $m->nis; ?></td>
                                    <td><?php echo $m->nama_siswa; ?></td>
                                    <td><?php echo $m->nama_kelas; ?></td>
                                    <td><?php echo $m->username; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('siswa/edit/') . $m->id_siswa; ?>" class="btn btn-warning btn-flat btn-xs">Edit</a>
                                            <a href="<?= base_url('siswa/hapus/') . $m->id_siswa; ?>" onclick="return confirm('Apakah yakin data ini akan dihapus?')" class="btn btn-danger btn-flat btn-xs">Hapus</a>
                                        </div>
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

<div class="modal fade" id="modal-data">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <center><h4 class="modal-title">Tambah Data siswa</h4></center>
            </div>
            <div class="modal-body">
                <div id="modal-data-body">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->load->view('admin/js');
?>
<script type="text/javascript">
    $(document).ready(function() {
        // Inisialisasi DataTable dengan lengthMenu kustom
        $('#data').dataTable({
            "lengthMenu": [ [10, 20, 25, 30, 40, 50, 100], [10, 20, 25, 30, 40, 50, 100] ]
        });

        // Inisialisasi Select2 untuk dropdown filter
        $('.select2').select2();

        // Notifikasi flashdata
        $('.alert-message').alert().delay(3000).slideUp('slow');

        // Kode untuk menangani pengiriman form yang ada di dalam modal
        $(document).on('submit', '#form-siswa', function(e) {
            e.preventDefault();
            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: form.serialize(),
                success: function(response) {
                    if (response === 'SUCCESS') {
                        window.location.reload();
                    } else {
                        $('#modal-data-body').html(response);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan, tidak bisa terhubung ke server.');
                }
            });
        });
    });
</script>

<?php
$this->load->view('admin/foot');
?>