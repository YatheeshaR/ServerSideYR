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
        redirect('bookmark');


    }

    // public function view($id) {
    //     $user_id = $this->session->userdata('user_id');
    //     $data['bookmark'] = $this->bookmark_model->get_bookmark($id, $user_id);
    //     $data['bookmarks'] = $this->bookmark_model->get_bookmarks(null, $user_id);
    //     $this->load->view('bookmark_list', $data);
    // }

    public function edit($id) {
        $user_id = $this->session->userdata('user_id');
        $data['bookmark'] = $this->bookmark_model->get_bookmarks($id, $user_id);
    
        if (empty($data['bookmark'])) {
            show_404();
        }
    
        $this->load->view('edit_bookmark', $data);
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

    public function search() {
        $tag = $this->input->post('tag');
        $user_id = $this->session->userdata('user_id');
        $bookmarks = $this->bookmark_model->search_bookmarks($user_id, $tag);
    
        if (!empty($bookmarks)) {
            $output = '';
            foreach ($bookmarks as $bookmark) {
                $output .= '
                    <div class="bookmark" data-id="' . $bookmark['id'] . '">
                        <h3>' . $bookmark['title'] . '</h3>
                        <a href="' . $bookmark['url'] . '">' . $bookmark['url'] . '</a>
                        <p>Tags: ' . $bookmark['tags'] . '</p>
                        <button class="delete" data-id="' . $bookmark['id'] . '">Delete</button>
                        <button class="edit" data-id="' . $bookmark['id'] . '">Edit</button>
                    </div>
                ';
            }
        } else {
            $output = '<p>No bookmarks found with the tag: ' . htmlspecialchars($tag) . '</p>';
        }
    
        echo $output;
    }
    
       
    public function view($page = 0) {
        $this->load->library('pagination');
    
        $config = array();
        $config['base_url'] = site_url('bookmark/view');
        $config['total_rows'] = $this->bookmark_model->get_bookmark_count($this->session->userdata('user_id'));
        $config['per_page'] = 5; // Number of bookmarks per page
        $config['uri_segment'] = 3;
    
        $this->pagination->initialize($config);
    
        $user_id = $this->session->userdata('user_id');
        $data['bookmarks'] = $this->bookmark_model->get_bookmarks_paged($user_id, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
    
        $this->load->view('bookmark_list', $data);
    }
    

}
?>
