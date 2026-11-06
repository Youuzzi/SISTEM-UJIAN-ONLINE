
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_ujian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url('auth'));
        }
        $this->load->model('m_hasil');
        $this->load->library('mypdf');
    }

    public function index()
    {
        // Logika untuk filter
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
            $data['hasil'] = $this->m_hasil->get_peserta_by_mapel($id);
        } else {
            $data['hasil'] = $this->m_hasil->get_all_peserta();
        }

        // Mengambil daftar mapel untuk dropdown filter
        $data['mapel_list'] = $this->m_data->get_data('tb_matapelajaran')->result();
        $this->load->view('admin/v_hasil', $data);
    }

    public function print_all()
    {
        // Logika untuk cetak berdasarkan filter
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
            $data['cetak'] = $this->m_hasil->get_peserta_by_mapel($id);
        } else {
            $data['cetak'] = $this->m_hasil->get_all_peserta();
        }

        // Menyiapkan logo Zirocraft untuk laporan PDF
        $path = FCPATH . 'image/Black Text.png';

        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $img_data = file_get_contents($path);
            $data['logo'] = 'data:image/' . $type . ';base64,' . base64_encode($img_data);
        } else {
            $data['logo'] = '';
        }

        $this->mypdf->generate('admin/v_cetak', $data, 'Laporan Hasil Ujian', 'A4', 'Landscape');
    }

    public function cetak($id)
    {
        $data['cetak'] = $this->m_hasil->cetak($id);

        // Menyiapkan logo Zirocraft untuk laporan PDF
        $path = FCPATH . 'image/Black Text.png';

        if (file_exists($path)) {
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $img_data = file_get_contents($path);
            $data['logo'] = 'data:image/' . $type . ';base64,' . base64_encode($img_data);
        } else {
            $data['logo'] = '';
        }

        $this->mypdf->generate('admin/v_cetak', $data, 'Laporan Hasil Ujian', 'A4', 'Landscape');
    }
}
