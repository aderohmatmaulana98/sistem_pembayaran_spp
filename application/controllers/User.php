<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_log_in();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }
    public function my_profile()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'User';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/my_profile', $data);
        $this->load->view('templates/footer');
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
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
			Password saat ini salah !
		  </div>');

                redirect('user/change_password');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password baru tidak boleh sama dengan saat ini !
                  </div>');
                    redirect('user/change_password');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password berhasil diubah !
                  </div>');
                    redirect('user/change_password');
                }
            }
        }
    }

    public function edit_profil()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Edit Profil';

        // $this->form_validation->set_rules('nisn', 'NISN', 'required|trim');
        // $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        // $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        // $this->form_validation->set_rules('no_hp', 'No HP', 'required|trim');
        // $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        // $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        // $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        // $this->form_validation->set_rules('image', 'Foto', 'required|trim');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/edit_profil', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profil_aksi()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $nisn = $this->input->post('nisn');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $no_hp = $this->input->post('no_hp');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $alamat = $this->input->post('alamat');


        //cek jika ada gambar yang akan diupload
        $upload_image = $_FILES['image'];




        //ika ada gambar yang di upload

        if ($upload_image) {
            $config['upload_path']          = './assets/assets/images/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2048;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $old_image = $data['user']['image'];
                if ($old_image != 'default.png') {
                    unlink(FCPATH, './assets/assets/images/profile/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('image', $new_image);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                redirect('user/my_profile');
            }
        }

        $this->db->set('nisn', $nisn);
        $this->db->set('nama', $nama);
        $this->db->set('no_hp', $no_hp);
        $this->db->set('tempat_lahir', $tempat_lahir);
        $this->db->set('tgl_lahir', $tgl_lahir);
        $this->db->set('alamat', $alamat);
        $this->db->where('email', $email);
        $this->db->update('user');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Profile berhasil di ubah!
		  </div>');
        redirect('user/my_profile');
    }
}
