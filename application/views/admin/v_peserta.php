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
                    <center><h4 class="box-title">Daftar Peserta Ujian</h4></center>
                    <a href="<?php echo base_url('peserta_tambah'); ?>" class="btn btn-primary btn-flat"><span class="fa fa-plus"></span> Tambah </a>
                    <a href="<?php echo base_url('jenis_ujian'); ?>" class="btn btn-primary btn-flat"><span></span>Data Jenis Ujian</a>
                </div>
                <div class="box-body">
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Nama Mata Pelajaran</th>
                                <th>Jenis Ujian</th>
                                <th>Waktu Ujian</th>
                                <th>Durasi Ujian</th>
                                <th width="7%">Action</th>
                                <th>Status </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($peserta as $d) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d->nama_siswa; ?></td>
                                    <td><?php echo $d->nama_kelas; ?></td>
                                    <td><?php echo $d->nama_matapelajaran; ?></td>
                                    <td><?php echo $d->jenis_ujian; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($d->tanggal_ujian)); ?> | <?php echo $d->jam_ujian; ?></td>
                                    <td><?php echo $d->durasi_ujian; ?> Menit</td>
                                    <td><?php echo $d->action_display; ?></td>
                                    <td><?php echo $d->status_display; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section><?php
$this->load->view('admin/js');
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data').DataTable({
            // Opsi yang sudah ada
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            
            // Tambahkan koma, lalu opsi yang baru
            "lengthMenu": [ [10, 20, 25, 30, 40, 50, 100], [10, 20, 25, 30, 40, 50, 100] ]
        });

        $('.alert-message').alert().delay(3000).slideUp('slow');
    });
</script>
<?php
$this->load->view('admin/foot');
?>