<?php
class AuthController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('AuthModel');
        $this->load->database();
        $this->load->library('form_validation'); // Load the form_validation library here
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function signup() {
        // Validate user input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        if ($this->form_validation->run() === FALSE) {
            // Display error messages
            $this->load->view('signup_view');
        } else {
            // Register user
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT) // Hash the password before saving it
            );
            $user_id = $this->AuthModel->signup_user($data);
            if ($user_id) {
                // Redirect to home page
                redirect('Home');
            } else {
                // Display error message
                $this->session->set_flashdata('message', 'Error occurred during signup. Please try again.');
                redirect('AuthController/signup');
            }
        }
    }

    public function login() {
        // Validate user input
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE) {
            // Display error messages
            $this->load->view('login_view');
        } else {
            // Authenticate user
            $data = array(
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );
            $user = $this->AuthModel->login_user($data);
            if ($user && password_verify($data['password'], $user->password)) { // Verify the password
                // Store user data in session and redirect to home page
                $this->session->set_userdata('user_id', $user->id);
                redirect('Home');
            } else {
                // Display error message
                $this->session->set_flashdata('message', 'Invalid email or password. Please try again.');
                redirect('AuthController/login');
            }
        }
    }

    public function logout() {
        // Unset user data in session and redirect to home page
        $this->session->unset_userdata('user_id');
        redirect('AuthController/login');
    }
}
?>
