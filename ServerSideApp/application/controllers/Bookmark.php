<?php
class Bookmark extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('bookmark_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['bookmarks'] = $this->bookmark_model->get_bookmarks(null, $user_id);
        $data['bookmark_count'] = $this->bookmark_model->get_bookmark_count($user_id);
        $this->load->view('bookmark_list', $data);
    }

    public function create() {
        $data = array(
            'title' => $this->input->post('title'),
            'url' => $this->input->post('url'),
            'tags' => $this->input->post('tags'),
            'user_id' => $this->session->userdata('user_id')
        );

        header('Content-Type: application/json');

        if ($this->bookmark_model->add_bookmark($data)) {
            $response = array(
                'success' => true,
                'message' => 'Bookmark added successfully',
                'bookmark' => $data
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Failed to add bookmark'
            );
        }

        echo json_encode($response);
    }

    public function view($id) {
        $user_id = $this->session->userdata('user_id');
        $data['bookmark'] = $this->bookmark_model->get_bookmark($id, $user_id);
        $data['bookmarks'] = $this->bookmark_model->get_bookmarks(null, $user_id);
        $this->load->view('bookmark_list', $data);
    }

    public function update($id) {
        $data = array(
            'title' => $this->input->post('title'),
            'url' => $this->input->post('url'),
            'tags' => $this->input->post('tags')
        );
        $user_id = $this->session->userdata('user_id');

        header('Content-Type: application/json');

        if ($this->bookmark_model->update_bookmark($id, $data, $user_id)) {
            echo json_encode(array('success' => true, 'message' => 'Bookmark updated successfully', 'bookmark' => $data));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update bookmark'));
        }
    }

    public function delete($id) {
        $user_id = $this->session->userdata('user_id');

        header('Content-Type: application/json');

        if ($this->bookmark_model->delete_bookmark($id, $user_id)) {
            echo json_encode(array('success' => true, 'message' => 'Bookmark deleted successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to delete bookmark'));
        }
    }
}
?>
