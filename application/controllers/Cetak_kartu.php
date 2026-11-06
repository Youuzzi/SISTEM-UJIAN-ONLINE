<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cetak_kartu extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        // Mengambil daftar kelas untuk dropdown
        $data['kelas'] = $this->db->order_by('nama_kelas', 'ASC')->get('tb_kelas')->result();

        // Cek jika ada filter kelas yang dipilih
        if ($this->input->get('id_kelas')) {
            $id_kelas = $this->input->get('id_kelas');
            $data['siswa_list'] = $this->db->get_where('tb_siswa', ['id_kelas' => $id_kelas])->result();
        } else {
            $data['siswa_list'] = null; // Kosongkan jika belum ada filter
        }

        $this->load->view('admin/v_cetak_kartu_pilih', $data);
    }

    public function proses_cetak()
    {
        $id_kelas = $this->input->post('id_kelas');
        $data['siswa'] = $this->db->get_where('tb_siswa', ['id_kelas' => $id_kelas])->result();
        $kelas_info = $this->db->get_where('tb_kelas', ['id_kelas' => $id_kelas])->row();
        $data['nama_kelas'] = $kelas_info->nama_kelas;

        $this->load->library('mypdf');
        $this->mypdf->generate('admin/v_kartu_template', $data, 'kartu-login-'.$data['nama_kelas'], 'A4', 'portrait');
    }
}
