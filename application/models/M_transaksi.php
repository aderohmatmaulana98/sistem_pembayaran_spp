<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaksi extends CI_Model
{
    function tampil_detail($where1)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where_in('nisn', $where1);
        return $query = $this->db->get();
    }
    function tampil_buku($where1)
    {
        $this->db->select('*');
        $this->db->from('tagihan_buku');
        $this->db->where_in('nisn', $where1);
        return $query = $this->db->get();
    }
    public function save_pem_bulanan($data)
    {
        return $this->db->insert_batch('pembayaran_bulanan', $data);
    }
    function tampil_data_spp()
    {
        $this->db->select('*');
        // $this->db->from('pembayaran_bulanan');
        // $this->db->join('user', 'pembayaran_bulanan.nisn=user.nisn');
        return $query = $this->db->get('pembayaran_bulanan');
    }
    public function id_transaksi()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_transaksi,3)) AS kd_max FROM spp_bulanan WHERE DATE(tanggal_bayar)=CURDATE()");
        $kd = 1;
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd++;
        }
        $kode = "SPP-";
        date_default_timezone_set('Asia/Jakarta');
        return $kode . date('dmy') . $kd;
    }
    function tampil_data()
    {
        $this->db->select('*');
        $this->db->from('user');
        return $query = $this->db->get();
    }
    public function tahun()
    {
        $this->db->select('*');
        $this->db->from('tahun_ajaran');

        return $query = $this->db->get()->result();
    }
    public function session_tahun()
    {
        $this->db->select('*');
        $this->db->from('tahun_ajaran');
        $this->db->where_in('Status', 'ON');
        return $query = $this->db->get();
    }
    function tampil_datatahun()
    {
        $this->db->select('*');
        $this->db->from('tahun_ajaran');

        $this->db->where_in('Status', 'ON');
        return $query = $this->db->get();
    }
    function tampil_databulan()
    {
        return $this->db->get('bulan');
    }
    function input_data($data)
    {
        $this->db->insert('pembayaran_bulanan', $data);
    }
    public function save_batch($data)
    {
        return $this->db->insert_batch('spp_bulanan', $data);
    }
}
