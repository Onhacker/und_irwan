<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends MX_Controller {
	function __construct(){
		parent::__construct();

	}

	function index(){
		$data["uri"] = "Tanpa Nama";
		$this->load->view('daftar_view',$data);      
	}

	function und($uri,$nama = ""){
		if ($uri == "") {
			redirect(site_url());
		} else {
			$this->db->where("id_peserta", $uri);
			$x = $this->db->get("peserta")->row();
			// echo $this->db->last_query();
			$data["uri"] = $x->nama;
			$data["seb"] = $x->gambar;
			$this->load->view('daftar_view',$data);
		}
			      
	}
	
}
