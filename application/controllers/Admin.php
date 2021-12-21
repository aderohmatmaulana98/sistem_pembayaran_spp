<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('M_thajaran');
        $this->load->helper('url');
        is_log_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }
    public function tahun_ajaran()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Tahun Ajaran';
        $data['tahun_ajaran'] = $this->db->get('tahun_ajaran')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/tahun_ajaran', $data);
        $this->load->view('templates/footer');
    }
    function tambah_thajaran()
    {
        $id_tahun = rand(00, 99);
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $besar_spp = $this->input->post('besar_spp');
        $Status = $this->input->post('Status');
        $data = array(
            'id_tahun' => $id_tahun,
            'tahun_ajaran' => $tahun_ajaran,
            'besar_spp' => $besar_spp,
            'Status'   => $Status
        );
        $this->db->insert('tahun_ajaran', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Tahun Ajaran berhasil ditambahkan !
      </div>');
        redirect('admin/tahun_ajaran');
    }
    function update_thajaran()
    {
        $id_tahun = $this->input->post('id_tahun');
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $besar_spp = $this->input->post('besar_spp');
        $Status = $this->input->post('Status');
        $data = array(
            'id_tahun' => $id_tahun,
            'tahun_ajaran' => $tahun_ajaran,
            'besar_spp' => $besar_spp,
            'Status'     => $Status,
        );
        $where = array('id_tahun' => $id_tahun);
        $this->M_thajaran->update_data($where, $data, 'tahun_ajaran');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Tahun Ajaran berhasil diubah
      </div>');
        redirect('admin/tahun_ajaran');
    }
    public function deleteAjaran()
    {
        $id_tahun = $this->input->get('id_tahun');
        $this->db->delete('tahun_ajaran', array('id_tahun' => $id_tahun));
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Tahun Ajaran berhasil dihapus
      </div>');
        redirect('admin/tahun_ajaran');
    }
    public function my_profile()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/my_profile', $data);
        $this->load->view('templates/footer');
    }

    public function role()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role';
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id)
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role Access';
        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roleaccess', $data);
        $this->load->view('templates/footer');
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Akses Di ubah !
		  </div>');
    }
}
