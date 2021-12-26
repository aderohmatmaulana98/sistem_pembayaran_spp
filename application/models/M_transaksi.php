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
}
