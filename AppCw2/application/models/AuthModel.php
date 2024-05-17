<?php
class AuthModel extends CI_Model {
    
    public function signup_user() {
        // Retrieve form data from POST
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
        // Prepare data to insert into the database
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password
        );
    
        // Insert user data into the database
        $this->db->insert('users', $data);
    
        // Return the ID of the inserted user
        return $this->db->insert_id();
    }
    
    

    public function login_user() {
        // Retrieve form data from POST
        $username = $this->input->post('username');
        $password = $this->input->post('password');
    
        // Retrieve user data from database
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        $user = $query->row();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return false;
        }
    }
    

    public function logout_user() {
        // Destroy session
        $this->session->sess_destroy();
    }

    public function get_user_by_id($user_id) {
        // Retrieve user data from database
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row();
    }
}
