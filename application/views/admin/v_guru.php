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
            <div class="box box-success" style="overflow-x: scroll;">
                <div class="box-header">
                    <h4 class="box-title" style="margin-left:10px;">Data Guru</h4>
                    <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-default"> <span class="fa fa-plus"></span> Tambah</button>
                </div>
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>NIP</th>
                                <th>Nama Guru</th>
                                <th>Username</th>
                                <th width="12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($guru as $m) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $m->nip; ?></td>
                                    <td><?php echo $m->nama_guru; ?></td>
                                    <td><?php echo $m->username; ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('guru/edit/') . $m->id_guru; ?>" class="btn btn-warning btn-flat btn-xs">Edit</a>
                                            <a href="<?= base_url('guru/hapus/') . $m->id_guru; ?>" onclick="return confirm('Apakah yakin data ini akan dihapus?')" class="btn btn-danger btn-flat btn-xs">Hapus</a>
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
</section><div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <center><h4 class="modal-title">Tambah Data Guru</h4></center>
            </div>
            <form method="post" action="<?php echo base_url('guru/guru_aksi'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Guru</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Guru" required="">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">NIP (Nomor Induk Pegawai)</label>
                        <input type="number" class="form-control" name="nip" placeholder="Masukkan NIP Guru" required="">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required="">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-flat">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
$this->load->view('admin/js');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data').dataTable({
            "lengthMenu": [ [10, 20, 25, 30, 40, 50, 100], [10, 20, 25, 30, 40, 50, 100] ]
        });

        
        $('.alert-message').alert().delay(3000).slideUp('slow');
    });
</script>

<?php
$this->load->view('admin/foot');
?>