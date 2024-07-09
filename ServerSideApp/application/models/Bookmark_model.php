<?php
class Bookmark_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function get_bookmark($id, $user_id) {
			$this->db->where('id', $id);
			$this->db->where('user_id', $user_id);
			return $this->db->query('SELECT * FROM bookmarks WHERE id = ? AND user_id = ?', array($id, $user_id))->row_array();
    }

    public function get_bookmark_count($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('bookmarks');
    }

    public function add_bookmark($data, $user_id) {
				$data->user_id = $user_id;
        $this->db->insert('bookmarks', $data);

				$id = $this->db->insert_id();
				return $this->get_bookmark($id, $user_id);
    }

    public function delete_bookmark($id, $user_id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        return $this->db->delete('bookmarks');
    }

    public function update_bookmark($id, $data, $user_id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        return $this->db->update('bookmarks', $data);
    }

    public function search($tag) {  
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->like('tags', $tag);
        $query = $this->db->get('bookmarks');
        $bookmarks = $query->result_array();
    
        // Clear existing bookmarks and add searched bookmarks
        this.collection.reset();
        this.collection.add(bookmarks);
    }


    public function get_bookmarks($user_id, $limit, $start, $tag) {
        $this->db->where('user_id', $user_id);
				if ($tag != null) {
					$this->db->like('tags', $tag);
				}
        $this->db->limit($limit, $start);
        $query = $this->db->get('bookmarks');
    
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }
    
}
?>
