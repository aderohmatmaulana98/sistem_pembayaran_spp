<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_transaksi');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';
        $data['siswa'] = $this->db->get_where('user', ['role_id' => 2])->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pembayaran/index', $data);
        $this->load->view('templates/footer');
    }
    public function detail($nisn)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';
        $where1 = array('nisn' => $nisn);
        $data1['siswa'] = $this->M_transaksi->tampil_detail($where1)->result();
        $data1['siswa_buku'] = $this->M_transaksi->tampil_buku($where1)->result();



        $query = $this->db->query('SELECT * FROM user 
				WHERE nisn =' . $nisn .  '');
        if ($query->num_rows() == 0) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pembayaran/detail_siswa', $data1);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pembayaran/detail_siswa', $data1);
            $this->load->view('pembayaran/pembayaran_buku', $data1);
            $this->load->view('templates/footer');
        }
    }
    public function pembayaran_spp()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';
        $data['siswa'] = $this->db->get_where('user', ['role_id' => 2])->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pembayaran/pembayaran_spp', $data);
        $this->load->view('templates/footer');
    }
}
