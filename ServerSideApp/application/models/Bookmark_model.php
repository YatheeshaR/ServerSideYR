<?php
class Bookmark_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_bookmarks($id, $user_id) {
        $this->db->where('id', $id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get('bookmarks');
        return $query->row_array();
    }

    public function get_bookmark_count($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->count_all_results('bookmarks');
    }

    public function add_bookmark($data) {
        return $this->db->insert('bookmarks', $data);
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

    public function search_bookmarks($user_id, $tag) {
        $this->db->where('user_id', $user_id);
        $this->db->like('tags', $tag);
        $query = $this->db->get('bookmarks');
        return $query->result_array();
    }
}
?>
