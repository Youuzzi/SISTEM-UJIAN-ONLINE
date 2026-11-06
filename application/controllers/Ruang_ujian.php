<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruang_ujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'siswa_login') {
            redirect(base_url() . 'auth?alert=belum_login');
        }
    }

    public function soal()
    {
        $id_peserta = $this->uri->segment(3);
        
        // --- BLOK "PENJAGA PINTU" ---
        $peserta = $this->db->get_where('tb_peserta', ['id_peserta' => $id_peserta])->row();

        if (!$peserta || $peserta->id_siswa != $this->session->userdata('id_siswa')) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Jadwal ujian tidak valid.</div>');
            redirect('jadwal_ujian');
        }
        
        if ($peserta->status_ujian == '2') {
            $this->session->set_flashdata('message', '<div class="alert alert-success">Anda sudah menyelesaikan ujian ini.</div>');
            redirect('jadwal_ujian');
        }

        date_default_timezone_set('Asia/Jakarta');
        $waktu_mulai_ujian    = new DateTime($peserta->tanggal_ujian . ' ' . $peserta->jam_ujian);
        $durasi_ujian_menit   = (int)$peserta->durasi_ujian;
        $waktu_sekarang       = new DateTime();
        $waktu_berakhir_ujian = (clone $waktu_mulai_ujian)->modify("+$durasi_ujian_menit minutes");
        $batas_toleransi      = (clone $waktu_mulai_ujian)->modify("+5 minutes");

        if ($waktu_sekarang < $waktu_mulai_ujian) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning">Ujian belum dimulai.</div>');
            redirect('jadwal_ujian');
        }
        if ($waktu_sekarang > $waktu_berakhir_ujian) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Waktu ujian telah berakhir.</div>');
            redirect('jadwal_ujian');
        }
        if ($waktu_sekarang > $batas_toleransi) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda terlambat lebih dari 5 menit.</div>');
            redirect('jadwal_ujian');
        }
        // --- AKHIR BLOK "PENJAGA PINTU" ---

        $soal_ujian = $this->db->query('SELECT * FROM tb_soal_ujian WHERE id_matapelajaran = ? ORDER BY RAND()', [$peserta->id_matapelajaran]);

        $this->m_data->update_data(['id_peserta' => $id_peserta], ['status_ujian' => 1], 'tb_peserta');

        $sisa_waktu_detik = $waktu_berakhir_ujian->getTimestamp() - $waktu_sekarang->getTimestamp();
        
        $data = array(
            "soal"       => $soal_ujian->result(),
            "total_soal" => $soal_ujian->num_rows(),
            "max_time"   => ($sisa_waktu_detik > 0) ? $sisa_waktu_detik : 0,
            "id"         => (array) $peserta
        );
        $this->load->view('ujian/v_soalujian', $data);
    }

    public function jawab_aksi()
    {
        $id_peserta = $this->input->post('id_peserta');
        $jumlah     = $this->input->post('jumlah_soal');
        $id_soal    = $this->input->post('soal');
        $jawaban    = $this->input->post('jawaban');

        if (empty($jawaban)) $jawaban = [];
        
        $data = [];
        for ($i = 0; $i < $jumlah; $i++) {
            $nomor = $id_soal[$i];
            $jawab = isset($jawaban[$nomor]) ? $jawaban[$nomor] : null;
            $data[] = ['id_peserta' => $id_peserta, 'id_soal_ujian' => $nomor, 'jawaban' => $jawab];
        }

        $this->db->insert_batch('tb_jawaban', $data);

        $cek = $this->db->query('SELECT tb_soal_ujian.id_soal_ujian, tb_soal_ujian.kunci_jawaban FROM tb_jawaban JOIN tb_soal_ujian ON tb_jawaban.id_soal_ujian = tb_soal_ujian.id_soal_ujian WHERE id_peserta = ?', [$id_peserta]);

        $benar = 0;
        foreach ($cek->result() as $d) {
             if (isset($jawaban[$d->id_soal_ujian]) && $jawaban[$d->id_soal_ujian] == $d->kunci_jawaban) {
                $benar++;
            }
        }

        $jumlah_soal = $cek->num_rows();
        $salah = $jumlah_soal - $benar;
        $nilai = ($jumlah_soal > 0) ? ($benar / $jumlah_soal) * 100 : 0;

        $this->m_data->update_data(['id_peserta' => $id_peserta], [
            'benar'        => $benar,
            'salah'        => $salah,
            'status_ujian' => 2,
            'nilai'        => round($nilai)
        ], 'tb_peserta');

        redirect(base_url('jadwal_ujian'));
    }
}