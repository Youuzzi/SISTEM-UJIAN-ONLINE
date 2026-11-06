<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Peserta extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status') != 'admin_login') {
            redirect(base_url('auth'));
        }
        $this->load->model('m_peserta');
        $this->load->model('m_data'); // Pastikan m_data di-load
    }

    public function index()
    {
        // --- PENAMBAHAN: Logika Status Dinamis ---
        
        // Mengambil semua data peserta ujian (query asli Anda ada di dalam model)
        $peserta_ujian = $this->m_peserta->get_peserta4()->result();

        date_default_timezone_set('Asia/Jakarta');
        $waktu_sekarang = new DateTime();

        foreach ($peserta_ujian as $ujian) {
            // Siapkan variabel waktu untuk setiap jadwal
            $waktu_mulai_ujian    = new DateTime($ujian->tanggal_ujian . ' ' . $ujian->jam_ujian);
            $durasi_ujian_menit   = (int)$ujian->durasi_ujian;
            $waktu_berakhir_ujian = (clone $waktu_mulai_ujian)->modify("+$durasi_ujian_menit minutes");

            // Tentukan status dan action
            if ($ujian->status_ujian == '2') {
                $ujian->status_display = '<span class="btn btn-xs btn-success">Selesai Ujian</span>';
                $ujian->action_display = '-'; // Tidak ada aksi jika sudah selesai
            } else if ($waktu_sekarang > $waktu_berakhir_ujian) {
                $ujian->status_display = '<span class="btn btn-xs btn-danger">Tidak Mengikuti Ujian</span>';
                $ujian->action_display = '-'; // Tidak ada aksi jika waktu sudah habis
            } else {
                // Jika ujian belum berlangsung atau sedang berlangsung
                $ujian->status_display = '<span class="btn btn-xs btn-default">Belum Ujian</span>';
                // Tombol Action tetap ditampilkan
                $ujian->action_display = '
                    <div class="btn-group">
                        <a href="'.base_url('peserta/edit/' . $ujian->id_peserta).'" class="btn btn-warning btn-flat btn-xs">Edit</a>
                        <a href="'.base_url('peserta/hapus/' . $ujian->id_peserta).'" onclick="return confirm(\'Apakah yakin data ini akan dihapus?\')" class="btn btn-danger btn-flat btn-xs">Hapus</a>
                    </div>';
            }
        }
        // --- SELESAI PENAMBAHAN ---

        $data['peserta'] = $peserta_ujian;
        $this->load->view('admin/v_peserta', $data);
    }

    public function hapus($id)
    {
        $where = array('id_peserta' => $id);
        $this->m_data->delete_data($where, 'tb_peserta');
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-message"><h4><i class="icon fa fa-check"></i> Data Peserta Ujian berhasil di hapus !</h4></div>');
        redirect(base_url('peserta'));
    }

    public function edit($id)
    {
        $data['peserta'] = $this->m_peserta->get_joinpeserta($id);
        $data['mapel'] = $this->m_data->get_data('tb_matapelajaran')->result();
        $data['siswa'] = $this->m_data->get_data('tb_siswa')->result();
        $data['jenis_ujian'] = $this->m_data->get_data('tb_jenis_ujian')->result();
        $this->load->view('admin/v_peserta_edit', $data);
    }

    public function update()
    {
        // Fungsi update Anda tidak diubah
        $id_peserta         = $this->input->post('id'); // Mengambil id_peserta dari form
		$peserta 		    = $this->input->post('peserta');
		$mapel 			    = $this->input->post('mapel');
		$tanggal		    = $this->input->post('tanggal');
		$jam			    = $this->input->post('jam');
		$durasi_ujian		= $this->input->post('durasi_ujian');
		$jenis			    = $this->input->post('jenis');
		$timer_ujian 		= $durasi_ujian*60;
		$where  = array('id_peserta' => $id_peserta);

		$data = array(
			'id_siswa'		   => $peserta,
			'id_matapelajaran' => $mapel,
			'id_jenis_ujian'   => $jenis,
			'tanggal_ujian'	   => $tanggal,
			'jam_ujian'		   => $jam,
			'durasi_ujian'	   => $durasi_ujian,
			'timer_ujian'	   => $timer_ujian
		);

		$this->m_data->update_data($where, $data, 'tb_peserta');
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-message"><h4><i class="icon fa fa-check"></i> Data berhasil di Update.</h4></div>');
		redirect(base_url('peserta'));
    }
}