<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_peserta extends CI_Model {
	var $table = 'peserta';
	var $column_order = array('','','nama','jabatan','no_hp','lunas','id_desa','id_kecamatan');
	var $column_search = array('id_desa'); 
	var $order = array('id_desa' => 'ASC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
		$this->db->where('id_kota', $this->om->web_me()->id_kota);

        if($this->input->post('id_desa')) {
            $this->db->where('id_desa', $this->input->post('id_desa'));
        }

        if($this->input->post('id_kecamatan')) {
            $this->db->where('id_kecamatan', $this->input->post('id_kecamatan'));
        }

        if($this->input->post('nama')) {
            $this->db->like('nama', $this->input->post('nama'));
        }
    
        $this->db->from($this->table);
		
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
			$this->db->order_by('id_desa', 'ASC');
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
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}


	function get_by_id($id){
		if ($this->session->userdata("admin_level") == "admin") {
			$this->db->from($this->table);
			$this->db->where('id_sekolah',$id);
			$query = $this->db->get();
		} else {
			$this->db->where("username",$this->session->userdata("admin_username"));
			$this->db->from($this->table);
			$this->db->where('id_sekolah',$id);
			$query = $this->db->get();
		}   
		return $query;
	}

	function arr_pkm(){
        // $this->db->order_by("kecamatan", "ASC");
        $this->db->where("id_kota",$this->om->web_me()->id_kota);
        $res = $this->db->get("tiger_kecamatan");
        // echo $this->db->last_query();
		$arr[""]  = "== Semua Kecamatan == ";
		foreach($res->result() as $row) :
			$arr[$row->id]  = $row->kecamatan;
		endforeach;
		return $arr;
	}

  

}
