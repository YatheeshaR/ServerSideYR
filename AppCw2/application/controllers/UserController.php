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
}