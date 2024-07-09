<?php
class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation'); // Load form_validation library
        $this->load->helper(array('url', 'form'));
    }

    public function register() {
        $this->load->view('register');
    }

    public function create_account() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('register');
        } else {
            $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $password
            );

            $this->user_model->register($data);
            redirect('/user/login');
        }
    }

    public function login() {
        $this->load->view('login');
    }

    public function authenticate() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->user_model->login($username, $password);

        if ($user) {
            $this->session->set_userdata('user_id', $user->id);
            redirect('/bookmarks');
        } else {
            $this->session->set_flashdata('error', 'Invalid login credentials');
            redirect('/user/login');
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect('/user/login');
    }
}
?>
