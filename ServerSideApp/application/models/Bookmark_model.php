<?php
class Bookmark_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    
    public function get_bookmarks($id, $user_id) {
        if ($id === null) {
            $this->db->where('user_id', $user_id);
            return $this->db->get('bookmarks')->result_array();
        } else {
            $this->db->where('id', $id);
            $this->db->where('user_id', $user_id);
            return $this->db->query('SELECT * FROM bookmarks WHERE id = ? AND user_id = ?', array($id, $user_id))->row_array();
        }
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


    public function get_bookmarks_paged($user_id, $limit, $start) {
        $this->db->where('user_id', $user_id);
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
