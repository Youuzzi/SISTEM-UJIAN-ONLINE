<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Memuat model m_data jika belum di autoload
        $this->load->model('m_data');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim', ['required' => 'Username harus di isi!']);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus di isi!']);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('v_login');
        } else {
            $username = htmlspecialchars($this->input->post('username', TRUE));
            $password = htmlspecialchars($this->input->post('password', TRUE));

            $admin = $this->db->get_where('tb_admin', ['username' => $username])->row();
            $guru  = $this->db->get_where('tb_guru', ['username' => $username])->row();
            $siswa = $this->db->get_where('tb_siswa', ['username' => $username])->row();

            if ($admin && password_verify($password, $admin->password)) {
                // Login sebagai Admin
                $data_session = array(
                    'id_admin'  => $admin->id_admin, // Gunakan nama kolom yang benar
                    'nama'      => $admin->nama_user,
                    'username'  => $admin->username,
                    'status'    => 'admin_login'
                );
                $this->session->set_userdata($data_session);
                redirect(base_url('home'));

            } else if ($guru && password_verify($password, $guru->password)) {
                // Login sebagai Guru
                $data_session = array(
                    'id_guru'   => $guru->id_guru, // Gunakan nama kolom yang benar
                    'nama'      => $guru->nama_guru,
                    'username'  => $guru->username,
                    'status'    => 'guru_login'
                );
                $this->session->set_userdata($data_session);
                redirect(base_url('home'));

            } else if ($siswa && password_verify($password, $siswa->password)) {
                // Login sebagai Siswa
                $data_session = array(
                    // --- PERBAIKAN KRUSIAL DI SINI ---
                    'id_siswa'  => $siswa->id_siswa, // Nama session harus 'id_siswa'
                    'nis'       => $siswa->nis,
                    'nama'      => $siswa->nama_siswa,
                    'username'  => $siswa->username,
                    'status'    => 'siswa_login'
                );
                $this->session->set_userdata($data_session);
                redirect(base_url('jadwal_ujian')); // Langsung ke jadwal ujian

            } else {
                // Jika semua login gagal
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-message text-center"><b>Login Gagal!</b><br>Maaf, Username atau Password salah.</div>');
                redirect(base_url('auth'));
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }

}