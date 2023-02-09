<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('v_login2');
	}

	public function cek_login()
	{
		$data = $this->input->post();
		$data['user_salt_encrypt'] = md5($data['user_password']);
		$dataLogin = $this->db->where($data)->get("ms_user")->row_array(); 
		$resp["is_error"] = "false";
		if (isset($dataLogin)) {
			$this->load->driver('cache');
			$cache_user = array();
			$cache_user["session_data"] = $this->db->get_where("setting",["active"=>"t"])->result();
			$this->cache->file->save('cu-login', $cache_user, 200000000);
			$this->session->set_userdata($dataLogin);
			$this->db->insert("user_activity",[
				"user_id"		=> $dataLogin["user_id"],
				"keterangan"	=> "Login sistem ".date("H:i:s"),
			]);
			$resp["message"] = "Sukses";
			$resp["redirect"] = site_url("dashboard");
			
		}else{
			$resp["message"] = "Username/Password tidak sesuai";
			$resp["is_error"] = "true";
		}
		echo json_encode($resp);
	}

	public function logout()
	{
		$this->db->insert("user_activity",[
			"user_id"		=> $this->session->user_id,
			"keterangan"	=> "Logout sistem ".date("H:i:s"),
		]);
		session_destroy();
		redirect('login');
	}
}
