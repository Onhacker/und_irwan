<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_daftar extends CI_Model {
	var $table = 'im_anak';
	var $column_order = array('','','create_date','no_kia','nama','jk','tgl_lahir','id_desa','nama_ibu','id_pkm');
	var $column_search = array('nama'); 
	var $order = array('id_anak' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){

		if($this->input->post('tahun')) {
			$this->db->where('tahun', $this->input->post('tahun'));
		}

		if($this->input->post('id_pkm')) {
            $this->db->where('id_pkm', $this->input->post('id_pkm'));
        }

        if($this->input->post('id_desa')) {
            $this->db->where('id_desa', $this->input->post('id_desa'));
        }

        if($this->input->post('jk')) {
            $this->db->where('jk', $this->input->post('jk'));
        }

        if($this->input->post('no_kia')) {
            $this->db->where('no_kia', $this->input->post('no_kia'));
        }
        if($this->input->post('nama')) {
            $this->db->like('nama', $this->input->post('nama'));
        }
    
        if ($this->session->userdata("admin_username") == "admin") {
        	if($this->input->post('id_pkm')) {
            	$this->db->where('id_pkm', $this->input->post('id_pkm'));
        	}
        }

		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
		}
        
		$i = 0;
		foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by('tahun', 'DESC');
			$this->db->order_by('id_anak', 'DESC');
		}

	}

	function get_data(){
		$this->get_data_query();
		if ($_POST["length"] == "-1") {
			$query = $this->db->get();
		} else {
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
		}	
		return $query->result();
	}

	function count_filtered(){
		$this->get_data_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all(){
		if ($this->session->userdata("admin_username") == "admin") {
			$this->db->from($this->table);
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
		}
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		$this->db->from("peserta_temp");
		$this->db->where('id_peserta_temp',$id);
		$query = $this->db->get();
		return $query;
	}

	function get_by_id_peserta($id){
		$this->db->from("peserta");
		$this->db->where('id_peserta',$id);
		$query = $this->db->get();
		return $query;
	}

	function arr_kec(){
		$this->db->where("id_kota",$this->fm->web_me()->id_kota);
        $this->db->order_by("id", "ASC");
		$res = $this->db->get("tiger_kecamatan");
		$arr[""]  = "== Pilih Kecamatan == ";
		foreach($res->result() as $row) :
			$arr[$row->id]  = $row->kecamatan;
		endforeach;
		return $arr;
	}

	function arr_desa(){
		$this->db->where("id_kota",$this->fm->web_me()->id_kota);
        $this->db->order_by("id_desa", "ASC");
		$res = $this->db->get("lokasi");
		$arr[""]  = "== Semua Desa == ";
		foreach($res->result() as $row) :
			$arr[$row->id_desa]  = $row->desa;
		endforeach;
		return $arr;
	}

	function arr_desa2(){
		$this->db->where("id_kecamatan",$this->session->userdata("kecamatan"));
        $this->db->order_by("id_desa", "ASC");
		$res = $this->db->get("lokasi");
		$arr[""]  = "== Semua Desa == ";
		foreach($res->result() as $row) :
			$arr[$row->id_desa]  = $row->desa;
		endforeach;
		return $arr;
	}

}
