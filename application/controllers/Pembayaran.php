<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';
        $data1['user'] = $this->db->get('user')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pembayaran/index', $data1);
        $this->load->view('templates/footer');
    }
    public function detail($nisn)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';
        $data1['user'] = $this->db->get('user')->result();


        $query = $this->db->query('SELECT * FROM user 
				WHERE nisn =' . $nisn . '');
        if ($query->num_rows() == 0) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pembayaran/detail_siswa', $data);
            $this->load->view('templates/footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('pembayaran/detail_siswa', $data1);
            $this->load->view('pembayaran/pembayaran_spp', $data1);
            $this->load->view('pembayaran/pembayaran_buku', $data1);
            $this->load->view('templates/footer');
        }
    }
    public function pembayaran_spp()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Pembayaran';
        $data['siswa'] = $this->db->get('siswa')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('pembayaran/pembayaran_spp', $data);
        $this->load->view('templates/footer');
    }
}
