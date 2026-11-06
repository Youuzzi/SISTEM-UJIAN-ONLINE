<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url('auth'));
        }
        // Pastikan model m_data sudah di-load
        $this->load->model('m_data');
    }

    public function index()
    {
        // --- PENAMBAHAN: Logika untuk filter kelas ---
        if (isset($_GET['kelas']) && !empty($_GET['kelas'])) {
            $id_kelas = $this->input->get('kelas');
            // Query untuk mengambil siswa HANYA dari kelas yang dipilih
            $data['siswa'] = $this->db->query('SELECT * FROM tb_siswa 
                JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas 
                WHERE tb_kelas.id_kelas = ?', [$id_kelas])->result();
        } else {
            // Jika tidak ada filter, tampilkan SEMUA siswa
            $data['siswa'] = $this->db->query('SELECT * FROM tb_siswa 
                JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas')->result();
        }
        
        // --- PERBAIKAN: Mengurutkan daftar kelas ---
        $data['kelas'] = $this->db->order_by('nama_kelas', 'ASC')->get('tb_kelas')->result();
        
        $this->load->view('admin/v_siswa', $data);
    }

    public function create()
    {
        // Aturan validasi asli Anda
        $this->form_validation->set_rules('nis', 'NIS', 'required|trim|is_unique[tb_siswa.nis]', ['required' => 'NIS harus diisi!', 'is_unique' => 'NIS ini sudah terdaftar!']);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim', ['required' => 'Nama harus diisi!']);
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas harus dipilih!']);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tb_siswa.username]', ['required' => 'Username harus diisi!', 'is_unique' => 'Username ini sudah digunakan!']);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus diisi!']);

        if ($this->form_validation->run() == FALSE) {
            // Logika jika validasi gagal (tidak diubah)
            $data['kelas'] = $this->db->order_by('nama_kelas', 'ASC')->get('tb_kelas')->result();
            $this->load->view('admin/v_siswa_tambah', $data);
        } else {
            // Logika jika validasi berhasil
            // --- PENAMBAHAN: Menyimpan password asli ---
            $plain_password = $this->input->post('password', TRUE); 
            $data = array(
                'nama_siswa'     => htmlspecialchars($this->input->post('nama', TRUE)),
                'nis'            => htmlspecialchars($this->input->post('nis', TRUE)),
                'id_kelas'       => htmlspecialchars($this->input->post('kelas', TRUE)),
                'username'       => htmlspecialchars($this->input->post('username', TRUE)),
                'password'       => password_hash($plain_password, PASSWORD_DEFAULT), 
                'password_plain' => $plain_password // Menyimpan password asli untuk dicetak
            );
            $this->m_data->insert_data($data, 'tb_siswa');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat!</b><br>Anda telah berhasil menambahkan data siswa.</div>');
            
            // Kirim sinyal 'SUCCESS' ke JavaScript (tidak diubah)
            echo "SUCCESS";
        }
    }

    public function edit($id)
    {
        // Kode asli Anda (tidak diubah)
        $data['siswa'] = $this->m_data->get_joinsiswa($id)->result();
        $data['kelas'] = $this->db->order_by('nama_kelas', 'ASC')->get('tb_kelas')->result();
        $this->load->view('admin/v_siswa_edit', $data);
    }
    
    public function update()
    {
        // Kode asli Anda (tidak diubah)
        $id         = $this->input->post('id');
        $nama       = $this->input->post('nama');
        $nis        = $this->input->post('nis');
        $kelas      = $this->input->post('kelas');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');

        $where = array('id_siswa' => $id);

        if ($password == "") {
            // Jika password tidak diubah
            $data = array(
                'nama_siswa' => $nama,
                'nis' => $nis,
                'id_kelas' => $kelas,
                'username' => $username
            );
        } else { 
            // Jika password diubah
            // --- PENAMBAHAN: Menyimpan password asli yang baru ---
            $data = array(
                'nama_siswa'     => $nama,
                'nis'            => $nis,
                'id_kelas'       => $kelas,
                'username'       => $username,
                'password'       => password_hash($password, PASSWORD_DEFAULT),
                'password_plain' => $password // Menyimpan password asli baru
            );
        }
        $this->m_data->update_data($where, $data, 'tb_siswa');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat!</b><br>Anda telah berhasil mengupdate data siswa.</div>');
        redirect(base_url('siswa'));
    }

    public function hapus($id)
    {
        // Kode asli Anda (tidak diubah)
        $where = array(
            'id_siswa' => $id
        );
        $this->m_data->delete_data($where, 'tb_siswa');
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><i class="icon fa fa-check"></i><b>Selamat!</b><br>Anda telah berhasil menghapus data siswa.</div>');
        redirect(base_url('siswa'));
    }
}