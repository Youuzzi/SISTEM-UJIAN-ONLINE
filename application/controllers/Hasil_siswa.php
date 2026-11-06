<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'siswa_login') {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        // Ambil id siswa dari session
        $id_siswa = $this->session->userdata('id_siswa');

        // Query untuk mengambil riwayat ujian siswa yang sudah selesai
        $data['hasil'] = $this->db->select('p.*, mp.nama_matapelajaran, ju.jenis_ujian')
            ->from('tb_peserta p')
            ->join('tb_matapelajaran mp', 'p.id_matapelajaran = mp.id_matapelajaran')
            ->join('tb_jenis_ujian ju', 'p.id_jenis_ujian = ju.id_jenis_ujian')
            ->where('p.id_siswa', $id_siswa)
            ->where('p.status_ujian', '2') // Hanya yang statusnya sudah selesai
            ->order_by('p.tanggal_ujian', 'DESC')
            ->get()->result();

        $this->load->view('siswa/v_hasil_ujian', $data);
    }
}