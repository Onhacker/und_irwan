<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends MX_Controller {
	function __construct(){
		parent::__construct();
		$this->timezone();
		$this->load->helper("front");
		$this->load->model("front_model",'fm');
		$this->load->model("M_daftar",'dm');
	}

	function index(){
		// redirect("https://lpkpd.org/");
			// $data["rec"] = $this->fm->web_me();
			// $data["kode"] = $this->reload_captcha();
			$this->load->view('daftar_view',$data);      
	}

	function und($uri,$nama = ""){
			$this->db->where("id_peserta", $uri);
			$x = $this->db->get("peserta")->row();
			// echo $this->db->last_query();
			$data["uri"] = $x->nama;
			$this->load->view('daftar_view',$data);      
	}

	function microtime_microseconds()
	{
		list($usec, $sec) = explode(" ", microtime());
		$cek =  round(($usec * 1000) + $sec);
		$cek2 = explode(".", $cek);
		return $cek;
	}
	function add_peserta(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama Peserta','required'); 
        $this->form_validation->set_rules('jabatan','Jabatan','required'); 
        $this->form_validation->set_rules('no_hp','No. HP/Whatsaap','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) {
        	 
        	$this->db->where("no_hp", $data["no_hp"]);
        	$cek = $this->db->get("peserta");
        	$det = $cek->row();
        	if ($cek->num_rows() == 1) {
        		$ret = array("success" => false,
	            		"title" => "Gagal",
	            		"pesan" => "Nomor Hp sudah digunakan atas nama ".$det->nama." dan Jabatan ".$det->jabatan.". Silahkan melakukan pengecekan status pendaftaran");
	            	echo json_encode($ret);
	            	return false;
        	}
        	
        	if ($this->session->userdata("add_peserta") == "") {
        		$t = explode(" ",microtime());
        		$this->session->set_userdata("add_peserta",md5($this->get_client_ip())."-".date("YmdHis")."-".$this->microtime_microseconds());
        		$data["session"]= $this->session->userdata("add_peserta");
        	} else {
				$data["session"]= $this->session->userdata("add_peserta");
        	}
        	
        	// $this->session->set_userdata("nama",$data["nama"]);
        	// $this->session->set_userdata("jabatan",$data["jabatan"]);
        	// $this->session->set_userdata("no_hp",$data["no_hp"]);
        	$this->db->insert("peserta_temp",$data);
        	$ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 

    function update_peserta(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama Peserta','required'); 
        $this->form_validation->set_rules('jabatan','Jabatan','required'); 
        $this->form_validation->set_rules('no_hp','No. HP/Whatsaap','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) {
        	$this->db->where("id_peserta_temp",$data["id_peserta_temp"]);
        	$this->db->update("peserta_temp",$data);
        	$ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 

    function update_peserta_dua(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nama','Nama Peserta','required'); 
        $this->form_validation->set_rules('jabatan','Jabatan','required'); 
        $this->form_validation->set_rules('no_hp','No. HP/Whatsaap','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) {
        	$data["id_peserta"] = $data["id_peserta_temp"];
        	unset($data["id_peserta_temp"]);
        	$this->db->where("id_peserta",$data["id_peserta"]);
        	$this->db->update("peserta",$data);
        	// echo $this->db->last_query();
        	$ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 

    function edit($id){
        $data = array();
        $res = $this->dm->get_by_id($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }

    function edit_peserta($id){
        $data = array();
        $res = $this->dm->get_by_id_peserta($id);
        if($res->num_rows() > 0 ){
            $data = $res->row_array();
        } else {
            $data = array();
        }
        echo json_encode($data);
    }

    function hapus_data($id){
    	$this->db->where("id_peserta_temp",$id);
    	$res =$this->db->delete("peserta_temp");
    	if($res) {    
    		$ret = array("success" => true,
    			"title" => "Berhasil",
    			"pesan" => "Data berhasil dihapus");
    	} else {
    		$ret = array("success" => false,
    			"title" => "Gagal",
    			"pesan" => "Data Gagal dihapus");
    	}
    	echo json_encode($ret);
    } 

    function hapus_data_pesertaqq($id){
    	$this->db->where("id_peserta",$id);
    	$res =$this->db->delete("peserta");
    	if($res) {    
    		$ret = array("success" => true,
    			"title" => "Berhasil",
    			"pesan" => "Data berhasil dihapus");
    	} else {
    		$ret = array("success" => false,
    			"title" => "Gagal",
    			"pesan" => "Data Gagal dihapus");
    	}
    	echo json_encode($ret);
    } 

    function reload_peserta(){
        $data["controller"] = get_class($this); 
        $this->db->where("session", $this->session->userdata("add_peserta"));
        $data["peserta_temp"] = $this->db->get("peserta_temp");    
        $this->load->view('load_peserta',$data);        
    }

    function cek_status(){
    	$this->load->view('load_cek_view');  
    }

    function cek_info(){
    	$this->load->view('load_info_view');  
    }

    function cek($no_hp){
        $data["controller"] = get_class($this); 
        $this->db->where("no_hp", $no_hp);
        $data["pes"] = $this->db->get("peserta")->row();  

        $this->db->where("id_desa", $data["pes"]->id_desa);  
        $data["peserta"] = $this->db->get("peserta");  
        $this->load->view('load_cek',$data);        
    }

	function konfirmasi(){
		if ($this->session->userdata("validasi") == true) {
			$this->db->where("session_temp", $this->session->userdata("add_peserta"));
        	$data["peserta_temp"] = $this->db->get("peserta");    
			$this->load->view('konfirmasi_view',$data);
		} else {
			redirect(site_url("daftar"));
		}	
	}

	function thanks(){
		$this->load->view('thanks_view');
	}

	function get_desa($id_kecamatan) {
		$form = $this->uri->segment(4);
        $sel="";
        $id = $this->uri->segment(4);
        $this->db->where("id_kecamatan",$id_kecamatan);
        $this->db->order_by("id");
        $res = $this->db->get("tiger_desa");
       
        $str = "";

        if($form<>0) {
        $str .="<option value=''> == Semua Desa == </option> "; }
        else {
            $str .="<option value=''> == Semua Desa == </option> ";
        }
        foreach($res->result() as $row) :
            if($id!='') {
                $sel = ($row->id == $id)?"selected":"";
            }
             $str .= "<option value=\"$row->id\" $sel> $row->desa </option> \n";
        endforeach;
        echo $str;
    }

	function timezone(){
        $this->db->where("id_identitas", "1");
        $s = $this->db->get("identitas")->row();
        return date_default_timezone_set($s->waktu);
    }


    function update_bayar(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_desa','Desa','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == true ) { 
			
			$data["lunas"] = "L";
			if ($data["lunas"] == "L") {
				$new_name = "reupload_".date("Ymdhis")."_".$data2["id_desa"];
				$config['upload_path'] = 'upload/gambar/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
	            // $config['max_size'] = '5000'; // kb
	            $config['file_name'] = $new_name;
	            $this->load->library('upload', $config);
	            if (empty($_FILES['gambar']["name"])){
	            	$ret = array("success" => false,
	            		"title" => "Gagal",
	            		"pesan" => "Bukti Pelunasan Harus Diisi");
	            	echo json_encode($ret);
	            	return false;
	            }
	            if (! $this->upload->do_upload('gambar')) {
	            	// $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";
	            	$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")";
	            	$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
					echo json_encode($ret);
	            	return false;

	            } else {
	            	$fdata =  $this->upload->data();
	            	// compres
	            	$config['image_library']='gd2';
	            	$config['source_image']='upload/gambar/'.$fdata['file_name'];
	            	$config['create_thumb']= FALSE;
	            	$config['maintain_ratio']= FALSE;
	            	$config['quality']= '50%';
	            	$config['width']= 400;
	            	$config['height']= 500;
	            	$config['new_image']= 'upload/gambar/'.$fdata['file_name'];
	            	$this->load->library('image_lib', $config);
	            	$this->image_lib->resize();
	            	// end of comptes
	            	$data['gambar'] = $fdata['file_name'];	

	            	$this->db->where("id_desa", $data2["id_desa"]);
	            	$res = $this->db->update("peserta",$data);
	            	// echo $this->db->last_query();
	            } 

	        } 

			if($res) {
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil disimpan");
			} else {
				// rec(get_class($this));
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
		
	}


    function daf(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_kecamatan','Kecamatan','required'); 
		$this->form_validation->set_rules('id_desa','Desa','required'); 
		$this->form_validation->set_rules('lunas','Pilih Pelunasan','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			if ($this->session->userdata("add_peserta") == "") {
				$ret = array("success" => false,
	            		"title" => "Gagal",
	            		"pesan" => "Masukkan Nama Peserta");
	            	echo json_encode($ret);
	            	return false;
			}
			$data["lunas"] = $data2["lunas"];
			$data["tanggal"] = date("Y-m-d H:i:s");
			$data["session"] = md5("YmdHis")."_".$data["id_desa"]."-".$data["id_kecamatan"];
			if ($data2["lunas"] == "L") {
				$new_name = $data["session"];
				$config['upload_path'] = 'upload/gambar/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
	            // $config['max_size'] = '5000'; // kb
	            $config['file_name'] = $new_name;
	            $this->load->library('upload', $config);
	            if (empty($_FILES['gambar']["name"])){
	            	$ret = array("success" => false,
	            		"title" => "Gagal",
	            		"pesan" => "Bukti Pelunasan Harus Diisi");
	            	echo json_encode($ret);
	            	return false;
	            }
	            if (! $this->upload->do_upload('gambar')) {
	            	// $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";
	            	$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")";
	            	$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
					echo json_encode($ret);
	            	return false;

	            } else {
	            	$fdata =  $this->upload->data();
	            	// compres
	            	$config['image_library']='gd2';
	            	$config['source_image']='upload/gambar/'.$fdata['file_name'];
	            	$config['create_thumb']= FALSE;
	            	$config['maintain_ratio']= FALSE;
	            	$config['quality']= '50%';
	            	$config['width']= 400;
	            	$config['height']= 500;
	            	$config['new_image']= 'upload/gambar/'.$fdata['file_name'];
	            	$this->load->library('image_lib', $config);
	            	$this->image_lib->resize();
	            	// end of comptes
	       
	            	$data['gambar'] = $fdata['file_name'];	

	            	$this->db->where("session", $this->session->userdata("add_peserta"));
	            	$p = $this->db->get("peserta_temp");
	            	foreach ($p->result() as $row):
	            		$data["id_temp"] = $row->id_peserta_temp;
	            		$data["session_temp"] = $row->session;
	            		$data["nama"] = $row->nama;
	            		$data["jabatan"] = $row->jabatan;
	            		$data["no_hp"] = $row->no_hp;
	            		$data["id_kota"] = $this->fm->web_me()->id_kota;
	            		$res  = $this->db->insert("peserta",$data);
	            	endforeach;

	            	
	            	$this->session->set_userdata("gambar",$data["gambar"]);
	            } 

	        } else {
	        		$this->db->where("session", $this->session->userdata("add_peserta"));
	            	$p = $this->db->get("peserta_temp");
	            	foreach ($p->result() as $row):
	            		$data["id_temp"] = $row->id_peserta_temp;
	            		$data["session_temp"] = $row->session;
	            		$data["nama"] = $row->nama;
	            		$data["jabatan"] = $row->jabatan;
	            		$data["no_hp"] = $row->no_hp;
	            		$data["id_kota"] = $this->fm->web_me()->id_kota;
	            		$res  = $this->db->insert("peserta",$data);
	            	endforeach;
	            // $res  = $this->db->insert("peserta",$data);
	        }

			if($res) {
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil disimpan");
				$this->session->set_userdata("validasi",true);
				$this->session->set_userdata("lunas",$data["lunas"]);
				$this->session->set_userdata("kecamatan",$data["id_kecamatan"]);
				$this->session->set_userdata("desa",$data["id_desa"]);
				$this->session->set_userdata("session",$data["session"]);
				$this->session->set_userdata("tanggal",$data["tanggal"]);
				

			} else {
				// rec(get_class($this));
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
		
	}

	function daf_ses(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_kecamatan','Kecamatan','required'); 
		$this->form_validation->set_rules('id_desa','Desa','required'); 
		$this->form_validation->set_rules('lunas','Pilih Pelunasan','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 
			$this->db->where("session", $this->session->userdata("add_peserta"));
	        $p = $this->db->get("peserta_temp");
			if ($p->num_rows() == 0) {
				$ret = array("success" => false,
	            		"title" => "Gagal",
	            		"pesan" => "Masukkan Nama Peserta");
	            	echo json_encode($ret);
	            	return false;
			}
			

			$data["lunas"] = $data2["lunas"];
			$data["tanggal"] = date("Y-m-d H:i:s");
			$data["session"] = md5("YmdHis")."_".$data["id_desa"]."-".$data["id_kecamatan"];
			if ($data2["lunas"] == "L") {
				$new_name = $data["session"];
				$config['upload_path'] = 'upload/gambar/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
	            // $config['max_size'] = '5000'; // kb
	            $config['file_name'] = $new_name;
	            $this->load->library('upload', $config);
	            if (empty($_FILES['gambar']["name"])){
	            	$this->db->where("session", $this->session->userdata("add_peserta"));
	            	$p = $this->db->get("peserta_temp");
	            	$a = $p->num_rows();

	            	$this->db->where("session_temp", $this->session->userdata("add_peserta"));
	            	$q = $this->db->get("peserta");
	            	$b = $q->num_rows();
	            	if ($a==$b) {
	            		foreach ($p->result() as $row):
		            		$data["nama"] = $row->nama;
		            		$data["jabatan"] = $row->jabatan;
		            		$data["no_hp"] = $row->no_hp;
		            		$this->db->where("session",$this->session->userdata("session"));
		            		$this->db->where("session_temp",$row->session);
		            		$this->db->where("id_temp",$row->id_peserta_temp);
		            		$res  = $this->db->update("peserta",$data);
	            		endforeach;
	            	} else {
	            		$this->db->where("session_temp", $this->session->userdata("add_peserta"));
	            		$this->db->delete("peserta");
	            		foreach ($p->result() as $row):
		            		$data["id_temp"] = $row->id_peserta_temp;
		            		$data["session_temp"] = $row->session;
		            		$data["nama"] = $row->nama;
		            		$data["jabatan"] = $row->jabatan;
		            		$data["no_hp"] = $row->no_hp;
		            		$data["id_kota"] = $this->fm->web_me()->id_kota;
		            		$res  = $this->db->insert("peserta",$data);
	            		endforeach;
	            	}

	            }
	            if (! $this->upload->do_upload('gambar')) {
	            	// $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";
	            	$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")";

	            } else {
	            	$fdata =  $this->upload->data();
	            	// compres
	            	$config['image_library']='gd2';
	            	$config['source_image']='upload/gambar/'.$fdata['file_name'];
	            	$config['create_thumb']= FALSE;
	            	$config['maintain_ratio']= FALSE;
	            	$config['quality']= '50%';
	            	$config['width']= 400;
	            	$config['height']= 500;
	            	$config['new_image']= 'upload/gambar/'.$fdata['file_name'];
	            	$this->load->library('image_lib', $config);
	            	$this->image_lib->resize();
	            	// end of comptes
	            	$data['gambar'] = $fdata['file_name'];	
	            	// $this->db->where("session",$this->session->userdata("session"));
	            	// $res  = $this->db->update("peserta",$data);
	            	$this->db->where("session", $this->session->userdata("add_peserta"));
	            	$p = $this->db->get("peserta_temp");
	            	$a = $p->num_rows();

	            	$this->db->where("session_temp", $this->session->userdata("add_peserta"));
	            	$q = $this->db->get("peserta");
	            	$b = $q->num_rows();
	            	if ($a==$b) {
	            		foreach ($p->result() as $row):
		            		$data["nama"] = $row->nama;
		            		$data["jabatan"] = $row->jabatan;
		            		$data["no_hp"] = $row->no_hp;
		            		$this->db->where("session",$this->session->userdata("session"));
		            		$this->db->where("session_temp",$row->session);
		            		$this->db->where("id_temp",$row->id_peserta_temp);
		            		$res  = $this->db->update("peserta",$data);
	            		endforeach;
	            	} else {
	            		$this->db->where("session_temp", $this->session->userdata("add_peserta"));
	            		$this->db->delete("peserta");
	            		foreach ($p->result() as $row):
		            		$data["id_temp"] = $row->id_peserta_temp;
		            		$data["session_temp"] = $row->session;
		            		$data["nama"] = $row->nama;
		            		$data["jabatan"] = $row->jabatan;
		            		$data["no_hp"] = $row->no_hp;
		            		$data["id_kota"] = $this->fm->web_me()->id_kota;
		            		$res  = $this->db->insert("peserta",$data);
	            		endforeach;
	            	}
	            	$this->session->set_userdata("gambar",$data["gambar"]);
	            } 

	        } else {
	        	// $data['gambar'] = "";	
	        	// $this->db->where("session",$this->session->userdata("session"));
	         //    $res  = $this->db->update("peserta",$data);
	        		$this->db->where("session", $this->session->userdata("add_peserta"));
	            	$p = $this->db->get("peserta_temp");
	            	$a = $p->num_rows();

	            	$this->db->where("session_temp", $this->session->userdata("add_peserta"));
	            	$q = $this->db->get("peserta");
	            	$b = $q->num_rows();
	            	if ($a==$b) {
	            		foreach ($p->result() as $row):
		            		$data["nama"] = $row->nama;
		            		$data["jabatan"] = $row->jabatan;
		            		$data["no_hp"] = $row->no_hp;
		            		$this->db->where("session",$this->session->userdata("session"));
		            		$this->db->where("session_temp",$row->session);
		            		$this->db->where("id_temp",$row->id_peserta_temp);
		            		$res  = $this->db->update("peserta",$data);
	            		endforeach;
	            	} else {
	            		$this->db->where("session_temp", $this->session->userdata("add_peserta"));
	            		$this->db->delete("peserta");
	            		foreach ($p->result() as $row):
		            		$data["id_temp"] = $row->id_peserta_temp;
		            		$data["session_temp"] = $row->session;
		            		$data["nama"] = $row->nama;
		            		$data["jabatan"] = $row->jabatan;
		            		$data["no_hp"] = $row->no_hp;
		            		$data["id_kota"] = $this->fm->web_me()->id_kota;
		            		$res  = $this->db->insert("peserta",$data);
	            		endforeach;
	            	}
	            
	        }

			if($res) {
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil disimpan");
				$this->session->set_userdata("validasi",true);
				$this->session->set_userdata("lunas",$data["lunas"]);
				$this->session->set_userdata("kecamatan",$data["id_kecamatan"]);
				$this->session->set_userdata("desa",$data["id_desa"]);
				$this->session->set_userdata("session",$data["session"]);
				$this->session->set_userdata("tanggal",$data["tanggal"]);
				
			} else {
				// rec(get_class($this));
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
		// echo $this->db->last_query();
		
	}

	function finish(){
		$this->db->where("session", $this->session->userdata("add_peserta"));
		$res = $this->db->delete("peserta_temp");
		// echo $this->db->last_query();
		$this->session->unset_userdata("add_peserta")  ;
		$this->session->unset_userdata("validasi");
		$this->session->unset_userdata("lunas");
		$this->session->unset_userdata("kecamatan");
		$this->session->unset_userdata("desa");
		$this->session->unset_userdata("gambar");
		$this->session->unset_userdata("session");
		$this->session->unset_userdata("tanggal");

		

		


		if($res) {    
			// redirect(site_url("daftar/thanks"));
			$ret = array("success" => true,
				"title" => "Berhasil",
				"pesan" => "Data berhasil disimpan");
		} else {
			$ret = array("success" => false,
				"title" => "Gagal",
				"pesan" => "Data Gagal disimpan");
		}

		echo json_encode($ret);
    } 

    function get_daftar(){
		$data = $this->db->escape_str($this->input->post());
		$data2 = $this->input->post();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('id_kecamatan','Kecamatan','required'); 
		$this->form_validation->set_rules('id_desa','Desa','required'); 
		$this->form_validation->set_rules('nama','Nama Peserta','required'); 

		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required'); 
		$this->form_validation->set_rules('lunas','Pilih Pelunasan','required'); 
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('required', '* %s Harus diisi ');
		$this->form_validation->set_message('min_length', '* %s Minimal 10 Digit ');
		$this->form_validation->set_message('max_length', '* %s Maksimal 12 Digit ');
		$this->form_validation->set_error_delimiters('<br> ', ' ');
		if($this->form_validation->run() == TRUE ) { 

			$data["jabatan"] = $data2["jabatan"];
			$data["nama"] = $data2["nama"];
			$data["lunas"] = $data2["lunas"];
			// $data["tanggal"] = date("Y-m-d");
			if ($data2["lunas"] == "L") {
				$new_name = $data["nama"];
				$config['upload_path'] = 'upload/gambar/';
				$config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
	            // $config['max_size'] = '5000'; // kb
	            $config['file_name'] = $new_name;
	            $this->load->library('upload', $config);
	            if (empty($_FILES['gambar']["name"])){
	            	$ret = array("success" => false,
	            		"title" => "Gagal",
	            		"pesan" => "Bukti Pelunasan Harus Diisi");
	            	echo json_encode($ret);
	            	return false;
	            }
	            if (! $this->upload->do_upload('gambar')) {
	            	// $rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")<br>Max file (".($config['max_size']/1000)." Mb)";
	            	$rules = "<hr>Tipe file (".str_replace("|", ", ", $config['allowed_types']).")";
	    //         	$ret = array("success" => false,
					// "title" => "Gagal",
					// "pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
					// echo json_encode($ret);

	            } else {
	            	$fdata =  $this->upload->data();
	            	// compres
	            	$config['image_library']='gd2';
	            	$config['source_image']='upload/gambar/'.$fdata['file_name'];
	            	$config['create_thumb']= FALSE;
	            	$config['maintain_ratio']= FALSE;
	            	$config['quality']= '50%';
	            	$config['width']= 400;
	            	$config['height']= 500;
	            	$config['new_image']= 'upload/gambar/'.$fdata['file_name'];
	            	$this->load->library('image_lib', $config);
	            	$this->image_lib->resize();
	            	// end of comptes
	            	$data['gambar'] = $fdata['file_name'];	
	            	// $res  = $this->db->insert("peserta",$data);
	            	$this->session->set_userdata("nama",$data["nama"]);
	            	$this->session->set_userdata("jabatan",$data["jabatan"]);
	            	$res = $this->session->set_userdata("lunas",$data["lunas"]);
	            	$this->session->set_userdata("gambar",$data["gambar"]);
	            } 

	            } else {
	            	$this->session->set_userdata("nama",$data["nama"]);
	            	$this->session->set_userdata("jabatan",$data["jabatan"]);
	            	$res = $this->session->set_userdata("lunas",$data["lunas"]);
	            }

			

			if($res) {
				$ret = array("success" => true,
					"title" => "Berhasil",
					"pesan" => "Data berhasil disimpan");
			} else {
				// rec(get_class($this));
				$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => "Data Gagal disimpan ".$this->upload->display_errors("<br>",$rules));
			}

		} else {
			$ret = array("success" => false,
					"title" => "Gagal",
					"pesan" => validation_errors());
		}
		echo json_encode($ret);
		
		
	}

	function reload(){
		redirect(site_url("admin_dashboard"));
	}

	function write(){
		unlink($this->session->userdata("file"));
		$this->session->unset_userdata("file");
		$t = microtime(true);
		$micro = sprintf("%06d",($t - floor($t)) * 1000000);
		$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
		$acak = $this->get_client_ip().$d->format("Y-m-d H:i:s.u");
		$acak = substr(md5($acak), 0,15);
		$new_image = $acak.".png";
		$config['image_library']='gd2';
		$config['source_image'] = 'assets/images/qr/cap.png';
		$config['wm_text'] = $this->reload_captcha();
		$config['wm_type'] = 'text';
		$config['wm_font_path'] = 'system/fonts/texb.ttf';
		$config['wm_font_size'] = '14';
		$config['wm_font_color'] = 'F3FF00';
		$config['wm_vrt_alignment'] = 'bottom';
		$config['wm_hor_alignment'] = 'center';
		$config['quality'] = '100%';
		$config['new_image']= 'assets/images/qr/'.$new_image;
		$this->load->library('image_lib',$config);
		$this->image_lib->watermark();
		$path = 'assets/images/qr/';
		$filename =  $path.$new_image;
		$this->session->set_userdata("file",$filename);
		return $new_image;            
	}

	function reload_captcha(){
		$acak = $this->get_client_ip().date("yy-m-d H:i:s");
        $acak = md5($acak);
        $serial = substr(preg_replace("/[^0-9]/", '', $acak),0,4);
        $this->session->set_userdata("capctcha",$serial);
        return Terbilang($serial);
      
	}


	function ceklogin(){
		$data = $this->input->post();
		unset($data["password2"]);
		if ($data["captcah"] == $this->session->userdata("capctcha")) {
			$this->db->select('*')->from('users');
			$this->db->where("blokir","N");
			$this->db->where("deleted","N");
			$this->db->where("password",hash("sha512", md5($data['kode'])));
			$this->db->where("username",$data['member']);
			$this->db->or_where("email",$data['member']);
			$res = $this->db->get();
			$rows = $res->row();
			if($res->num_rows() == 1 and $data["captcah"] == $this->session->userdata("capctcha")) {
				$this->session->set_userdata("admin_login",true);
				$this->session->set_userdata("admin_username",$rows->username);
				$this->session->set_userdata("admin_level",$rows->level);
				$this->session->set_userdata("admin_attack",$rows->attack);
				$this->session->set_userdata("admin_permisson",$rows->permission_publish);
				$this->session->set_userdata("admin_session",$rows->id_session);
				if ($this->session->userdata("admin_level") == "user") {
					$this->session->set_userdata("admin_pkm",$rows->id_pkm);
				}
				// $x["ip"] = $this->get_client_ip();
				// $x["browser"] = $this->get_client_browser();
				// $x["os"] = $_SERVER['HTTP_USER_AGENT'];
				// $x["waktu"] = date("Y-m-d H:i:s");
				// $x["username"] = $this->session->userdata("admin_username");
				// $this->db->insert("user_akses", $x);
				$ret = array("success"=>true,
					"pesan"=> "Login Berhasil",
					"operation" =>"insert");
				$this->session->unset_userdata("capctcha");
			} else {
				$ret = array("success"=>false,
					"new" => $this->reload_captcha(),
					"title" => "Gagal",
					"type" => "error",
					"pesan"=> "Login Gagal. Username/Email dan password tidak diterima");
			}
		} else {
			$ret = array("success"=>false,
					"new" => $this->reload_captcha(),
					"title" => "Gagal",
					"type" => "error",
					"pesan"=> "Captcha Gagal");
		}
		
		
		echo json_encode($ret);
	}

	function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'IP tidak dikenali';
		return $ipaddress;
	}

	function get_client_ip_2() {
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'IP tidak dikenali';
		return $ipaddress;
	}


	function get_client_browser() {
		$browser = '';
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
			$browser = 'Netscape';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
			$browser = 'Firefox';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
			$browser = 'Chrome';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
			$browser = 'Opera';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
			$browser = 'Internet Explorer';
		else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
			$browser = 'Safari';
		else
			$browser = 'Other';
		return $browser;
	}

	function logout(){
		$this->session->unset_userdata("admin_login");
		$this->session->unset_userdata("admin_username");
		$this->session->unset_userdata("admin_permisson");
		$this->session->unset_userdata("admin_level");
		$this->session->unset_userdata("admin_session");
		$this->session->unset_userdata("admin_attack");
		$this->session->unset_userdata("admin_pkm");
		$this->load->view("logout");
	}

	function download(){
		$this->load->helper('download');
    	force_download(FCPATH.'/upload/file/Undangan E Inspirated Lutim Desa.pdf', null);
	}

	function kode($id) {
     	
        $this->db->where("id_desa", $id);
        $re = $this->db->get("peserta");
        
        if ($re->num_rows() == 0) {
        	$data['title'] = "Halaman Tidak Ditemukan - ".$this->fm->web_me()->nama_website;
        	$this->load->view(onhacker_view("Error_view"),$data); 
        } else {

        	$this->db->where("id_desa", $id);
        	$data["res"] = $this->db->get("peserta")->row();
        	$this->db->where("id", $id);
        	$data["desa"] = $this->db->get("tiger_desa")->row();

        	$data["title"] = "Kode Pendaftaran Desa ".$data["desa"]->desa;


        $this->load->library('ciqrcode'); //pemanggilan library QR CODE
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/images/qr/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name=$id.'.png'; //buat name dari qr code sesuai dengan nim

        // $data['data'] = site_url("admin_imunisasi/pdf/".$id); //data yang akan di jadikan QR CODE
        $data['data'] = site_url("publik/validasi/".$id);//data yang akan di jadikan QR CODE
        $data['level'] = 'H'; //H=High
        $data['size'] = 10;
        $data['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($data); // fungsi untuk generate QR CODE
        


        $data['header'] = $data["title"];
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        $pdf->SetTitle( $data['header']);
        
        $pdf->SetMargins(20, 10, 20);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(10);
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetAuthor('Onhacker.net');

        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
     // add a page
        $pdf->AddPage("L", "A6");
        if ($data["res"]->lunas == "L") {
        	$html = $this->load->view("kode",$data,true);
	        $pdf->writeHTML($html, true, false, true, false, '');
	        unlink($data['savename']);
	        $pdf->Output($data['header'] .'.pdf', 'I');
        } else {
        	$data['title'] = "Halaman Tidak Ditemukan - ".$this->fm->web_me()->nama_website;
        	$this->load->view(onhacker_view("Error_view"),$data); 
        }
        
    }
    } 
	
}
