<?php
use Restserver\Libraries\REST_Controller;
require APPPATH . '/libraries/REST_Controller.php';

class Bookmark extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Bookmark_model');
    }

    // Display all bookmarks
    public function index_get() {
        $bookmarks = $this->Bookmark_model->get_all_bookmarks();
        $this->response($bookmarks, REST_Controller::HTTP_OK);
    }

    // Create a new bookmark
    public function index_post() {
        $data = $this->input->post();
        if ($this->Bookmark_model->insert_bookmark($data)) {
            $this->response(['message' => 'Bookmark created successfully'], REST_Controller::HTTP_CREATED);
        } else {
            $this->response(['message' => 'Failed to create bookmark'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // Edit an existing bookmark
    public function index_put($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($this->Bookmark_model->update_bookmark($id, $data)) {
            $this->response(['message' => 'Bookmark updated successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['message' => 'Failed to update bookmark'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // Delete a bookmark
    public function index_delete($id) {
        if ($this->Bookmark_model->delete_bookmark($id)) {
            $this->response(['message' => 'Bookmark deleted successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['message' => 'Failed to delete bookmark'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // Search bookmarks by tag
    public function search_post() {
        $tag = $this->input->post('tag');
        $user_id = $this->session->userdata('user_id');
        $bookmarks = $this->Bookmark_model->search_bookmarks($user_id, $tag);

        if (!empty($bookmarks)) {
            $this->response($bookmarks, REST_Controller::HTTP_OK);
        } else {
            $this->response(['message' => 'No bookmarks found with the tag: ' . htmlspecialchars($tag)], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // View bookmarks with pagination
    public function view_get($page = 0) {
        $this->load->library('pagination');

        $config = array();
        $config['base_url'] = site_url('bookmark/view');
        $config['total_rows'] = $this->Bookmark_model->get_bookmark_count($this->session->userdata('user_id'));
        $config['per_page'] = 5; // Number of bookmarks per page
        $config['uri_segment'] = 3;

        $this->pagination->initialize($config);

        $user_id = $this->session->userdata('user_id');
        $bookmarks = $this->Bookmark_model->get_bookmarks_paged($user_id, $config['per_page'], $page);
        $pagination = $this->pagination->create_links();

        $this->response(['bookmarks' => $bookmarks, 'pagination' => $pagination], REST_Controller::HTTP_OK);
    }
}
?>
