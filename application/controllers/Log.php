<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cek login untuk semua fungsi di controller ini
        if (!$this->session->userdata('status')) {
            redirect(base_url('auth'));
        }
    }

    // Fungsi untuk MENAMPILKAN halaman log ke admin
    public function index()
    {
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url('auth')); 
        }

        $data['logs'] = $this->db->select('log.*, s.nama_siswa, s.nis, mp.nama_matapelajaran')
            ->from('cheating_log log')
            ->join('tb_peserta p', 'log.user_id = p.id_peserta')
            ->join('tb_siswa s', 'p.id_siswa = s.id_siswa')
            ->join('tb_matapelajaran mp', 'p.id_matapelajaran = mp.id_matapelajaran')
            ->order_by('log.waktu', 'DESC')
            ->get()->result();

        $this->load->view('admin/v_log_cheating', $data);
    }

    // Fungsi untuk MENERIMA laporan dari JavaScript siswa
    public function simpan()
    {
        if ($this->session->userdata('status') == 'siswa_login') {
            $data = json_decode(file_get_contents("php://input"), true);
            
            if (!empty($data)) {
                $this->db->insert('cheating_log', [
                    'user_id'           => $data['user_id'],
                    'jenis_pelanggaran' => $data['jenis'],
                    'detail'            => $data['detail'],
                    'waktu'             => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}