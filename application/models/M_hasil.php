<?php
defined('BASEPATH') or exit('no direct script access allowed');

class M_hasil extends CI_Model
{
    // Mengambil semua data peserta yang sudah ujian
    public function get_all_peserta()
    {
        return $this->db->select('p.*, s.nama_siswa, k.nama_kelas, mp.nama_matapelajaran, ju.jenis_ujian')
            ->from('tb_peserta p')
            ->join('tb_siswa s', 'p.id_siswa = s.id_siswa')
            ->join('tb_kelas k', 's.id_kelas = k.id_kelas')
            ->join('tb_matapelajaran mp', 'p.id_matapelajaran = mp.id_matapelajaran')
            ->join('tb_jenis_ujian ju', 'p.id_jenis_ujian = ju.id_jenis_ujian')
            ->where('p.status_ujian', '2') // Hanya yang sudah selesai
            ->order_by('mp.nama_matapelajaran', 'ASC')
            ->order_by('k.nama_kelas', 'ASC')
            ->get()->result();
    }

    // Mengambil data peserta berdasarkan filter mata pelajaran
    public function get_peserta_by_mapel($id_mapel)
    {
        return $this->db->select('p.*, s.nama_siswa, k.nama_kelas, mp.nama_matapelajaran, ju.jenis_ujian')
            ->from('tb_peserta p')
            ->join('tb_siswa s', 'p.id_siswa = s.id_siswa')
            ->join('tb_kelas k', 's.id_kelas = k.id_kelas')
            ->join('tb_matapelajaran mp', 'p.id_matapelajaran = mp.id_matapelajaran')
            ->join('tb_jenis_ujian ju', 'p.id_jenis_ujian = ju.id_jenis_ujian')
            ->where('p.status_ujian', '2') // Hanya yang sudah selesai
            ->where('p.id_matapelajaran', $id_mapel)
            ->order_by('k.nama_kelas', 'ASC')
            ->order_by('s.nama_siswa', 'ASC')
            ->get()->result();
    }
    
    // Mengambil data untuk cetak per individu
    public function cetak($id_peserta)
    {
        return $this->db->select('p.*, s.nama_siswa, s.nis, k.nama_kelas, mp.nama_matapelajaran, ju.jenis_ujian')
            ->from('tb_peserta p')
            ->join('tb_siswa s', 'p.id_siswa = s.id_siswa')
            ->join('tb_kelas k', 's.id_kelas = k.id_kelas')
            ->join('tb_matapelajaran mp', 'p.id_matapelajaran = mp.id_matapelajaran')
            ->join('tb_jenis_ujian ju', 'p.id_jenis_ujian = ju.id_jenis_ujian')
            ->where('p.id_peserta', $id_peserta)
            ->get()->result();
    }
}