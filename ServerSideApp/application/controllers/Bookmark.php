<?php
class Bookmark extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('bookmark_model');
        $this->load->library('session');
        $this->load->helper('url');

				if (!array_key_exists("user_id", $this->session->userdata)) {
					redirect("/user/login");

					// IDEALLY you want to do much better security here. for now this is what we will do
				}
    }

    public function index() {
        $this->load->view('bookmark_list');
    }
	}
?>
