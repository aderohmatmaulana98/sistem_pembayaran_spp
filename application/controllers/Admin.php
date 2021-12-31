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
        $this->form_validation->set_rules('role', 'Role', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/role', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_role', ['role' => $this->input->post('role')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Role berhasil ditambahkan !
		  </div>');

            redirect('admin/role');
        }
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
    public function update_role()
    {
        $role = $this->input->post('role');
        $id = $this->input->post('id');

        $data = ['role' => $role];
        $where = ['id' => $id];

        $this->db->where($where);
        $this->db->update('user_role', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Role berhasil diubah !
      </div>');

        redirect('admin/role');
    }

    public function delete_role($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_role');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Role berhasil dihapus !
      </div>');

        redirect('admin/role');
    }

    public function buat_admin()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Buat Admin';
        $data['admin'] = $this->db->get_where('user', ['role_id' => 1])->result_array();

        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email must unique!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]', [
            'min_length' => 'Password to short!'
        ]);


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/buat_admin', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'nisn' => 0123,
                'nama' =>  htmlspecialchars($this->input->post('fullname', true)),
                'email' =>  htmlspecialchars($this->input->post('email', true)),
                'jenis_kelamin' =>  1,
                'image' =>  'default.png',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 1,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Akun admin berhasil dibuat !
		  </div>');

            redirect('admin/buat_admin');
        }
    }
    public function change_password()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Change Password';

        $this->form_validation->set_rules('current_password', 'Password saat ini', 'required|trim');
        $this->form_validation->set_rules('new_password', 'Password baru', 'required|trim|min_length[6]|matches[konfirmasi_password]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi password', 'required|trim|min_length[6]|matches[new_password]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Password saat ini salah !
		  </div>');

                redirect('admin/change_password');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password baru tidak boleh sama dengan saat ini !
                  </div>');
                    redirect('admin/change_password');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password berhasil diubah !
                  </div>');
                    redirect('admin/change_password');
                }
            }
        }
    }

    public function edit_admin()
    {
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $id = $this->input->post('id');

        $data = ['nama' => $nama, 'email' => $email];
        $where = ['id' => $id];

        $this->db->where($where);
        $this->db->update('user', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Admin berhasil diubah !
      </div>');

        redirect('admin/buat_admin');
    }

    public function delete_admin($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Admin berhasil dihapus !
      </div>');

        redirect('admin/buat_admin');
    }

    public function whatsapp()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Whatsapp';

        $this->form_validation->set_rules('pesan', 'Pesan', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/whatsapp', $data);
            $this->load->view('templates/footer');
        } else {
            $pesan = $this->input->post('pesan');

            $sql = "SELECT user.no_hp
                    FROM USER
                    WHERE user.role_id = 2";
            $no_hp = $this->db->query($sql)->result_array();

            foreach ($no_hp as $n) {

                $this->_sendwa($pesan, $no_hp, $n);
            }
            die;

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Pesan berhasil dikirim !
          </div>');

            redirect('admin/whatsapp');
        }
    }

    private function _sendwa($pesan, $no_hp, $n)
    {
        $n = $n['no_hp'];
        $curl = curl_init();
        $token = "2APPlbuVrzVm4D9WVZZOtRzB034znPIuQdMn85fPYVd7px2fncFMmD2V7ZmTlXA4";
        $payload = [
            "data" => [
                [
                    'phone' => $n,
                    'message' => $pesan,
                    'secret' => false, // or true
                    'priority' => false, // or true
                ],
            ],
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $token",
                "Content-Type: application/json"
            )
        );

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, "https://teras.wablas.com/api/v2/send-bulk/text");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        echo "<pre>";
        print_r($result);
    }
}
