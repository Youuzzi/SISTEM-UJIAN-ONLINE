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
            <?= $this->session->flashdata('message'); ?>
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo date('d F Y'); ?> | <span id="time"></span></h3>
                </div>
                <div class="box-body" style="overflow-x: scroll;">
                    <center><h4 class="box-title">Jadwal Ujian</h4></center>
                    <table id="data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th>Kode</th>
                                <th>Mata Pelajaran</th>
                                <th>Waktu Ujian</th>
                                <th>Durasi</th>
                                <th>Jenis Ujian</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($peserta as $d) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $d->kode_matapelajaran; ?></td>
                                    <td><?php echo $d->nama_matapelajaran; ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($d->tanggal_ujian)); ?> | <?php echo date('H:i:s', strtotime($d->jam_ujian)); ?></td>
                                    <td><?php echo $d->durasi_ujian; ?> Menit</td>
                                    <td><?php echo $d->jenis_ujian; ?></td>
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
$this->load->view('siswa/js');
?>
<script type="text/javascript">
    $('.alert-message').alert().delay(3000).slideUp('slow');

    function showTime() {
        var today = new Date();
        var curr_hour = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();
        
        document.getElementById('time').innerHTML = 
            ('0' + curr_hour).slice(-2) + ":" + 
            ('0' + curr_minute).slice(-2) + ":" + 
            ('0' + curr_second).slice(-2);
    }
    setInterval(showTime, 1000);
    showTime(); // Panggil sekali saat load
</script>
<?php
$this->load->view('siswa/foot');
?>