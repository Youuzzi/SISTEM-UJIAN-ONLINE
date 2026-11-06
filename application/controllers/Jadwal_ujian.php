<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_ujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'siswa_login') {
            redirect(base_url() . 'auth?alert=belum_login');
        }
    }

    public function index()
    {
        // Menggunakan ID Siswa dari session
        $id_siswa = $this->session->userdata('id_siswa');

        $jadwal_ujian = $this->db->query("
            SELECT p.*, mp.kode_matapelajaran, mp.nama_matapelajaran, ju.jenis_ujian
            FROM tb_peserta p
            JOIN tb_matapelajaran mp ON p.id_matapelajaran = mp.id_matapelajaran
            JOIN tb_jenis_ujian ju ON p.id_jenis_ujian = ju.id_jenis_ujian
            WHERE p.id_siswa = ?
        ", [$id_siswa])->result();

        // --- Logika untuk Status Dinamis ---
        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = new DateTime();

        foreach ($jadwal_ujian as $ujian) {
            if ($ujian->status_ujian == '2') {
                $ujian->status_display = '<span class="btn btn-xs btn-success">Mengikuti Ujian</span>';
                continue;
            }

            $waktu_mulai_ujian    = new DateTime($ujian->tanggal_ujian . ' ' . $ujian->jam_ujian);
            $durasi_ujian_menit   = (int)$ujian->durasi_ujian;
            $waktu_berakhir_ujian = (clone $waktu_mulai_ujian)->modify("+$durasi_ujian_menit minutes");
            $batas_toleransi      = (clone $waktu_mulai_ujian)->modify("+5 minutes");

            if ($waktu_sekarang < $waktu_mulai_ujian) {
                $ujian->status_display = '<span class="btn btn-xs btn-default">Tunggu Waktu Ujian</span>';
            } else if ($waktu_sekarang <= $batas_toleransi) {
                $ujian->status_display = '<a href="'.base_url('ruang_ujian/soal/' . $ujian->id_peserta).'" class="btn btn-xs btn-primary">Kerjakan Sekarang</a>';
            } else if ($waktu_sekarang > $batas_toleransi && $waktu_sekarang <= $waktu_berakhir_ujian) {
                $ujian->status_display = '<span class="btn btn-xs btn-warning">Anda Terlambat</span>';
            } else {
                $ujian->status_display = '<span class="btn btn-xs btn-danger">Tidak Mengikuti Ujian</span>';
            }
        }

        $data['peserta'] = $jadwal_ujian;
        $this->load->view('siswa/v_jadwal_ujian', $data);
    }
}