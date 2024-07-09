<?php
class Bookmark extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('bookmark_model');
        $this->load->library('session');
        $this->load->helper('url');

				if (!array_key_exists("user_id", $this->session->userdata)) {
					redirect("/user/login");
					
				}
    }

    public function get() {
        $this->load->library('pagination');
    
        $config = array();
				$user_id = $this->session->userdata('user_id');

        /*$config['base_url'] = site_url('bookmark/view');*/
        $config['total_rows'] = $this->bookmark_model->get_bookmark_count($user_id);
        $config['per_page'] = 5; // Number of bookmarks per page
    
        $this->pagination->initialize($config);

				$url = parse_url($_SERVER['REQUEST_URI']);
				$params = [];
				if (array_key_exists("query", $url)) {
					parse_str($url['query'], $params);
				}

				$page = 1;
				$tag = null;
					
				if (array_key_exists("page", $params)) {
					$page = $params["page"];
				}
				if (array_key_exists("tag", $params)) {
					$tag = $params["tag"];
				}

        $data['bookmarks'] = $this->bookmark_model->get_bookmarks($user_id, $config['per_page'], $page, $tag);
        $data['pagination'] = $this->pagination->create_links();

        echo json_encode($data);
    }

    public function post() {
			$request = json_decode($this->security->xss_clean($this->input->raw_input_stream));
      $user_id = $this->session->userdata('user_id');
    
			$bookmark = $this->bookmark_model->add_bookmark($request, $user_id);
			echo json_encode($bookmark);

			
    }

    public function put($id) {
				$request = json_decode($this->security->xss_clean($this->input->raw_input_stream));
				$user_id = $this->session->userdata('user_id');

				$data = array(
					"title" => $request->title,
					"url" => $request->url,
					"tags" => $request->tags,
				);

        header('Content-Type: application/json');

        if (!$this->bookmark_model->update_bookmark($id, $data, $user_id)) {
					set_status_header(500);
          echo json_encode(array('success' => false, 'message' => 'Failed to update bookmark'));
					return;
        }

				echo json_encode($this->bookmark_model->get_bookmark($id, $user_id));
    }

    public function delete($id) {
        $user_id = $this->session->userdata('user_id');

        header('Content-Type: application/json');

        if (!$this->bookmark_model->delete_bookmark($id, $user_id)) {
            echo json_encode(array('success' => false, 'message' => 'Failed to delete bookmark'));
						return;
        }

				set_status_header(204);
    }

    /*public function search() {*/
    /*    $tag = $this->input->post('tag');*/
    /*    $user_id = $this->session->userdata('user_id');*/
    /*    $bookmarks = $this->bookmark_model->search_bookmarks($user_id, $tag);*/
    /**/
    /*    if (!empty($bookmarks)) {*/
    /*        $output = '';*/
    /*        foreach ($bookmarks as $bookmark) {*/
    /*            $output .= '*/
    /*                <div class="bookmark" data-id="' . $bookmark['id'] . '">*/
    /*                    <h3>' . $bookmark['title'] . '</h3>*/
    /*                    <a href="' . $bookmark['url'] . '">' . $bookmark['url'] . '</a>*/
    /*                    <p>Tags: ' . $bookmark['tags'] . '</p>*/
    /*                    <button class="delete" data-id="' . $bookmark['id'] . '">Delete</button>*/
    /*                    <button class="edit" data-id="' . $bookmark['id'] . '">Edit</button>*/
    /*                </div>*/
    /*            ';*/
    /*        }*/
    /*    } else {*/
    /*        $output = '<p>No bookmarks found with the tag: ' . htmlspecialchars($tag) . '</p>';*/
    /*    }*/
    /**/
    /*    echo $output;*/
    /*}*/
    
       
    /*public function view($page = 0) {*/
    /*    $this->load->library('pagination');*/
    /**/
    /*    $config = array();*/
    /*    /*$config['base_url'] = site_url('bookmark/view');*/
    /*    $config['total_rows'] = $this->bookmark_model->get_bookmark_count($this->session->userdata('user_id'));*/
    /*print($config['total_rows']);*/ /*    $config['per_page'] = 5; // Number of bookmarks per page*/
    /*    $config['uri_segment'] = 3;*/
    /**/
    /*    $this->pagination->initialize($config);*/
    /**/
    /*    $user_id = $this->session->userdata('user_id');*/
    /*    $data['bookmarks'] = $this->bookmark_model->get_bookmarks_paged($user_id, $config['per_page'], $page);*/
    /*    $data['pagination'] = $this->pagination->create_links();*/
    /**/
    /*    $this->load->view('bookmark_list', $data);*/
    /*}*/
    

}
?>
