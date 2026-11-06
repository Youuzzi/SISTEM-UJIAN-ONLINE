<?php 
$this->load->view('admin/head');
?>

<!--tambahkan custom css disini-->

<?php
$this->load->view('admin/topbar');
$this->load->view('admin/sidebar');
?>

<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">

    <div class="callout callout-danger">
        <h4>Selamat Datang, <?php echo $this->session->userdata('nama');?> </h4>
        
    </div>

    <div class="box box-success box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Petunjuk Penggunaan</h3>
        </div><!-- /.box-header -->
       <div class="box-body">
    <ul>
        <li><b>Home</b><br>
            Beranda utama yang menampilkan ringkasan informasi penting seperti jumlah siswa, guru, soal, dan statistik ujian.
        </li>

        <li><b>Data Guru</b><br>
            Digunakan untuk mengelola data guru. Admin dapat menambahkan guru baru, mengedit data guru, dan menghapus guru yang tidak aktif.
        </li>

        <li><b>Data Siswa</b><br>
            Menambahkan, mengedit, atau menghapus informasi siswa. Di sini juga dapat dibuat akun login untuk masing-masing siswa.
        </li>

        <li><b>Kelola Soal Ujian</b><br>
            Menu ini digunakan untuk membuat dan mengelola soal ujian. Di dalamnya admin bisa:
            <ul>
                <li>Menambahkan soal baru</li>
                <li>Memilih mata pelajaran</li>
                <li>Menentukan jenis ujian (UTS, UAS, dll)</li>
                <li>Menentukan jumlah soal, jawaban benar, dan durasi ujian</li>
                <li>Mengedit atau menghapus soal</li>
            </ul>
        </li>

         <li><b>Kelola Peserta Ujian</b><br>
            Digunakan untuk mengatur data peserta yang mengikuti ujian berdasarkan soal yang sudah dibuat. Admin dapat memilih kelas atau kelompok siswa yang akan mengikuti ujian pada mata pelajaran dan jadwal tertentu.
        </li>

        <li><b>Hasil Ujian</b><br>
            Menampilkan hasil ujian dari seluruh siswa. Admin bisa melihat nilai, jumlah soal benar dan salah, serta status apakah siswa telah mengikuti ujian atau tidak.
        </li>

        <li><b>Utilities</b><br>
            Berisi fitur penting seperti <b>Backup Database</b>. Admin dapat mengunduh file cadangan (.sql) untuk menghindari kehilangan data saat terjadi error pada sistem.
        </li>

        <li><b>Ganti Password</b><br>
            Digunakan untuk mengganti password admin agar akun tetap aman. Jika lupa password, admin perlu bantuan dari pengelola utama.
        </li>

        <li><b>Keluar Akun</b><br>
            Digunakan untuk logout dan kembali ke halaman login sistem.
        </li>
    </ul>
</div>



</section><!-- /.content -->
  
<?php 
$this->load->view('admin/js');
?>

<!--tambahkan custom js disini-->

<script type="text/javascript">

	$(function(){
		$('#data-tables').dataTable();
	});

	$('.alert-message').alert().delay(3000).slideUp('slow');

</script>


<?php
$this->load->view('admin/foot');
?>

