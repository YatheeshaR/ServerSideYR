<?php
class AuthModel extends CI_Model {
    
    public function login($post){
        $q = $this->db->where(['email'=>$post['email'], 'password'=>$post['password']])
        ->get('users');
        return $q->result();
    }

    public function register($post){
        return $this->db->insert('users', $post);
    }

    public function user_data($user_id){
        $q = $this->db->where(['user_id'=>$user_id])
        ->get('users');
        return $q->result();
    }
}
