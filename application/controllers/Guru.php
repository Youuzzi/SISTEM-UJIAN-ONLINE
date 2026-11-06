<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guru extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url('auth'));
        }
        $this->load->model('m_data');
    }

    public function index()
    {
        $data['guru'] = $this->m_data->get_data('tb_guru')->result();
        $this->load->view('admin/v_guru', $data);
    }

    public function guru_aksi()
    {
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim|is_unique[tb_guru.nip]', [
            'required'  => 'NIP harus diisi!',
            'is_unique' => 'NIP yang Anda masukkan sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama Guru harus diisi!']);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tb_guru.username]', [
            'required'  => 'Username harus diisi!',
            'is_unique' => 'Username ini sudah digunakan!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => 'Password harus diisi!']);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-message">
                    <i class="icon fa fa-ban"></i><b>Maaf, Gagal!</b><br>
                    ' . validation_errors() . '
                </div>');
            redirect(base_url('guru'));
        } else {
            $data = array(
                'nip'       => $this->input->post('nip'),
                'nama_guru' => $this->input->post('nama'),
                'username'  => $this->input->post('username'),
                'password'  => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            );

            // --- BAGIAN INI DIPERBAIKI UNTUK MEMBERI NOTIFIKASI YANG BENAR ---
            if ($this->m_data->insert_data($data, 'tb_guru')) {
                // Jika database melaporkan BERHASIL
                $this->session->set_flashdata('message', '
                    <div class="alert alert-success alert-message">
                        <i class="icon fa fa-check"></i><b>Selamat!</b><br>
                        Anda telah berhasil menambahkan data guru.
                    </div>');
            } else {
                // Jika database melaporkan GAGAL
                $this->session->set_flashdata('message', '
                    <div class="alert alert-danger alert-message">
                        <i class="icon fa fa-ban"></i><b>Maaf, Gagal!</b><br>
                        Terjadi kesalahan saat menyimpan ke database. Periksa kembali data Anda.
                    </div>');
            }

            redirect(base_url('guru'));
            // --- SELESAI PERBAIKAN ---
        }
    }

    public function hapus($id)
    {
        $where = array('id_guru' => $id);
        $this->m_data->delete_data($where,'tb_guru');
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><i class="icon fa fa-check"></i><b>Selamat!</b><br>Anda telah berhasil menghapus data guru.</div>');
        redirect(base_url('guru'));
    }

    public function edit($id)
    {
        $where  = array('id_guru' => $id);
        $data['guru'] = $this->m_data->edit_data($where,'tb_guru')->result();
        $this->load->view('admin/v_guru_edit', $data);
    }

    public function update()
    {
        $id         = $this->input->post('id_guru');
        $nip        = $this->input->post('nip');
        $nama       = $this->input->post('nama');
        $username   = $this->input->post('username');
        $password   = $this->input->post('password');

        $where = array('id_guru' => $id);

        if (empty($password)) {
            $data = array(
                'nip'       => $nip,
                'nama_guru' => $nama,
                'username'  => $username,
            );
        } else {
            $data = array(
                'nip'       => $nip,
                'nama_guru' => $nama,
                'username'  => $username,
                'password'  => password_hash($password, PASSWORD_DEFAULT),
            );
        }

        $this->m_data->update_data($where, $data, 'tb_guru');
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat!</b><br>Anda telah berhasil mengupdate data guru.</div>');
        redirect(base_url('guru'));
    }
}
