<?php
class UserController extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Question_model');
        $this->load->model('Tag_model');
    }

    public function index() {
        // Retrieve top questions and tags from database
        $data['questions'] = $this->Question_model->get_top_questions(5);
        $data['tags'] = $this->Tag_model->retrieve_all_tags();
        // Load view
        $this->load->view('user_view', $data);
    }

    public function search_questions() {
        // Retrieve searched questions from database
        $keyword = $this->input->post('keyword');
        $data['questions'] = $this->Question_model->search_questions($keyword);
        // Load view
        $this->load->view('search_results_view', $data);
    }
    public function home(){
		$this->chklog();
		$this->load->model('user_model');
		$user_data = $this->user_model->user_data($this->user_id);
		$this->session->set_userdata('fullname', ucwords($user_data[0]->fname." ".$user_data[0]->lname));
		$top_answers = $this->user_model->get_user_top_ans($this->user_id);
		$this->load->view('users/home', compact('top_answers'));
	}

	public function logout(){
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('fullname');
        return redirect('users/index');
	}

	public function chklog(){
		if(!$this->user_id){
			return redirect('users/index');
		}
	}
}