<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta_tambah extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url().'auth?alert=belum_login');
        }
        $this->load->library('form_validation');
    }

    public function index()
    {
        if (isset($_GET['kelas']) && !empty($_GET['kelas'])) {
            $id_kelas = $this->input->get('kelas');
            $data['siswa'] = $this->db->query('SELECT * from tb_siswa join tb_kelas where tb_siswa.id_kelas=tb_kelas.id_kelas and tb_kelas.id_kelas= ?', [$id_kelas])->result();
        } else {
            $data['siswa'] = $this->db->query('SELECT * from tb_siswa join tb_kelas where tb_siswa.id_kelas=tb_kelas.id_kelas')->result();
        }
        
        // --- PERUBAHAN DI SINI ---
        // Mengambil data kelas dan langsung mengurutkannya
        $data['kelas'] = $this->db->order_by('nama_kelas', 'ASC')->get('tb_kelas')->result();
        
        $data['mapel'] = $this->m_data->get_data('tb_matapelajaran')->result();
        $data['jenis_ujian'] = $this->m_data->get_data('tb_jenis_ujian')->result();
        
        $this->load->view('admin/v_peserta_tambah', $data);
    }

    public function insert_()
    {
        // ... (Fungsi insert_() Anda tidak perlu diubah, sudah benar) ...
        $this->form_validation->set_rules('mapel', 'Mata Pelajaran', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal Ujian', 'required');
        $this->form_validation->set_rules('jam', 'Jam Ujian', 'required');
        $this->form_validation->set_rules('durasi_ujian', 'Durasi Ujian', 'required');
        $this->form_validation->set_rules('jenis_ujian', 'Jenis Ujian', 'required');
        if (empty($this->input->post('id'))) {
            $this->form_validation->set_rules('siswa_dipilih', 'Siswa', 'required', ['required' => 'Anda harus memilih minimal satu siswa!']);
        }

        $tanggal = $this->input->post('tanggal');
        $jam     = $this->input->post('jam');
        $jadwal_exist = $this->db->get_where('tb_peserta', [
            'tanggal_ujian' => $tanggal, 
            'jam_ujian'     => $jam
        ])->num_rows();

        if ($this->form_validation->run() == FALSE || $jadwal_exist > 0) {
            $error_message = '';
            if ($jadwal_exist > 0) {
                $error_message = '<li>Jadwal pada tanggal dan jam tersebut sudah digunakan oleh ujian lain!</li>';
            }
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger alert-message">
                    <i class="icon fa fa-ban"></i><b>Maaf, Gagal Menyimpan!</b><br>
                    <ul>' . validation_errors('<li>', '</li>') . $error_message . '</ul>
                </div>');
            redirect($_SERVER['HTTP_REFERER'] ?: base_url('peserta_tambah'));

        } else {
            $this->m_data->insert_multiple();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><i class="icon fa fa-check"></i><b>Selamat!</b><br>Peserta Ujian berhasil dibuat.</div>');
            redirect(base_url('peserta'));
        }
    }   
}