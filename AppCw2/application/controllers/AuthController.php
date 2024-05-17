<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {
	private $user_id = 0;

	public function __construct(){
		parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->library('form_validation');
		$this->user_id = $this->session->userdata('user_id');
	}
	public function index(){
		if($this->session->userdata('user_id')){
			return redirect('AuthController/home');
		}
		if($this->form_validation->run('add_user_login_rules')){
			$post = $this->input->post();
			$post['password'] = md5($post['password']);
			$this->load->model('AuthModel');
			$user = $this->AuthModel->login($post);
			if($user){
				$this->session->set_userdata('user_id', $user[0]->user_id);
				return redirect('AuthController/home');
			}else{
				$this->session->set_flashdata('msg', 'try again!');
				$this->session->set_flashdata('msg_class', 'alert alert-danger');
				return redirect('AuthController/index');
			}
		}else{
			$this->load->view('users/login');
		}
	}

	public function register(){
		if($this->form_validation->run('add_user_register_rules')){
			$post = $this->input->post();
			if($post['password'] == $post['rpassword']){
				unset($post['rpassword']);
				$post['password'] = md5($post['password']);
				$this->load->model('AuthModel');
				if($this->AuthModel->register($post)){
					$this->session->set_flashdata('msg', 'Successfully Registered');
					$this->session->set_flashdata('msg_class', 'alert alert-primary');
					return redirect('users/register');
				}else{
					$this->session->set_flashdata('msg', 'try again!');
					$this->session->set_flashdata('msg_class', 'alert alert-danger');
					return redirect('users/register');
				}
			}else{
				$this->session->set_flashdata('msg', 'password does not matched');
				$this->session->set_flashdata('msg_class', 'alert alert-danger');
				return redirect('users/register');
			}

		}else{
			$this->load->view('users/register');
		}

	}
}