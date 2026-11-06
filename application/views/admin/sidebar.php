<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url('image/ZIRO.png') ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('nama'); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
            
            <li <?= $this->uri->segment(1) == 'home' ? 'class="active"' : '' ?>>
                <a href="<?php echo base_url('home'); ?>"><i class="fa fa-home"></i>
                    <span>Home</span>
                </a>
            </li>


            <?php if ($this->session->userdata('status') == 'admin_login') { ?>
                <li <?= $this->uri->segment(1) == 'guru' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('guru'); ?>"><i class="fa fa-user-secret"></i> <span>Data Guru</span></a>
                </li>
                <li <?= $this->uri->segment(1) == 'siswa' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('siswa'); ?>"><i class="fa fa-users"></i> <span>Data Siswa</span></a>
                </li>
                <li <?= $this->uri->segment(1) == 'soal_ujian' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('soal_ujian'); ?>"><i class="fa fa-files-o"></i> <span>Kelola Soal Ujian</span></a>
                </li>
                <li <?= $this->uri->segment(1) == 'peserta' || $this->uri->segment(1) == 'peserta_tambah' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('peserta'); ?>"><i class="fa fa-list-alt"></i> <span>Kelola Peserta Ujian</span></a>
                </li>
                <li <?= $this->uri->segment(1) == 'hasil_ujian' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('hasil_ujian'); ?>"><i class="fa fa-table"></i> <span>Hasil Ujian</span></a>
                </li>
                <li <?= $this->uri->segment(1) == 'log' ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('log'); ?>"><i class="fa fa-warning"></i> 
                        <span>Log Pelanggaran</span>
                    </a>
                </li>
                <li <?= $this->uri->segment(1) == 'cetak_kartu' ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('cetak_kartu'); ?>"><i class="fa fa-print"></i> 
                        <span>Cetak Kartu Login</span>
                    </a>
                </li>
                 <li <?= $this->uri->segment(1) == 'utilitas' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('utilitas'); ?>"><i class="fa fa-gears"></i>
                        <span>Utilities</span>
                    </a>
                </li>
            <?php } ?>
            
            <?php if ($this->session->userdata('status') == 'guru_login') { ?>
                 <li <?= $this->uri->segment(1) == 'soal_ujian' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('soal_ujian'); ?>"><i class="fa fa-files-o"></i> <span>Kelola Soal Ujian</span></a>
                </li>
            <?php } ?>

            <li <?= $this->uri->segment(1) == 'password' ? 'class="active"' : '' ?>>
                <a href="<?php echo base_url('password'); ?>"><i class="fa fa-lock"></i>
                    <span>Ganti Password</span>
                </a>
            </li>
            <li>
                <a href="<?php echo base_url('auth/logout'); ?>"><i class="fa fa-power-off"></i>
                    <span>Keluar Akun</span>
                </a>
            </li>
        </ul>
    </section>
    </aside>

<div class="content-wrapper">