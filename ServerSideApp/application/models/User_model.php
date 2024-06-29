<?php
class User_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function register($data) {
        return $this->db->insert('users', $data);
    }

    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $user = $query->row();

        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }

    public function get_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }
}
?>
