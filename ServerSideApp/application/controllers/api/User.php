<?php
use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\Format; // Ensure Format class is also imported

require APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->library('form_validation'); // Load form_validation library
        $this->load->helper(array('url', 'form'));
    }

    public function index_get() {
        // Load the login view
        $this->load->view('login');
    }

    public function register_post() {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->response(['message' => validation_errors()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $password
            );

            $this->User_model->register($data);
            $this->response(['message' => 'Account created successfully'], REST_Controller::HTTP_CREATED);
        }
    }

    // public function login_post() {
    //     $username = $this->input->post('username');
    //     $password = $this->input->post('password');

    //     $user = $this->User_model->login($username, $password);

    //     if ($user) {
    //         $this->session->set_userdata('user_id', $user->id);
    //         $this->response(['message' => 'Login successful'], REST_Controller::HTTP_OK);
    //     } else {
    //         $this->response(['message' => 'Invalid login credentials'], REST_Controller::HTTP_UNAUTHORIZED);
    //     }
    // }

    public function login_post(){
		$_POST = json_decode(file_get_contents("php://input"), true);
		$this->form_validation->set_rules('username', 'checkUsername', 'required');
		$this->form_validation->set_rules('password', 'checkPassword', 'required');

		if($this->form_validation->run() == FALSE){
			$this->response("Something went wrong!.", REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$username = strip_tags($this->post('username'));
			$password = strip_tags($this->post('password'));

			$result = $this->UserModel->loginUser($username, sha1($password));
//			$result = $this->UserModel->loginUser($username, $password);
//			print_r($result);
			if($result != false){
				$this->response(array(
						'status' => TRUE,
						'message' => 'User has logged in successfully.',
						'data' => true,
						'username' => $result->username,
						'email' => $result->email,

					), REST_Controller::HTTP_OK);
			}else{
				$this->response("Enter valid username and password", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}

    public function logout_post() {
        $this->session->unset_userdata('user_id');
        $this->response(['message' => 'Logout successful'], REST_Controller::HTTP_OK);
    }
}
?>
