<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin_peserta_fix extends CI_Model {
	var $table = 'peserta';
	var $column_order = array('','','nama','','id_desa','id_kecamatan');
	var $column_search = array('id_desa'); 
	var $order = array('id_peserta' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	
	private function get_data_query(){
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
			// $this->db->order_by('id_kecamatan', 'ASC');
			$this->db->order_by('id_peserta', 'DESC');
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
		
			$this->db->from($this->table);
			$this->db->where('id_peserta',$id);
			$query = $this->db->get();
		
		return $query;
	}

	function valid_join($query,$table){
        if ($this->session->userdata("admin_level")=='admin'){
            return $query;
        } else {
            $this->db->where($table.".username", $this->session->userdata("admin_username"));
            return $query;
        }
    }

    function arr_pkm(){
        $this->db->where("id","1");
        $k = $this->db->get("id_kota")->row();

        $this->db->where("id_kota",$k->id_kota);
        $res = $this->db->get("tiger_kecamatan");
        // echo $this->db->last_query();
		$arr[""]  = "== Semua Kecamatan == ";
		foreach($res->result() as $row) :
			$arr[$row->id]  = $row->kecamatan;
		endforeach;
		return $arr;
	}

	function arr_kecamatan(){
		$this->db->where("id","1");
        $k = $this->db->get("id_kota")->row();

        $this->db->where("id_kota",$k->id_kota);
        $res = $this->db->get("tiger_kecamatan");

		$arr[""]  = "== Pilih Kecamatan == ";
		foreach($res->result() as $row) :
			$arr[$row->id]  = $row->kecamatan;
		endforeach;
		return $arr;
	}

	function arr_jabatan(){
		$this->db->order_by("id_jabatan", "ASC");
		$res = $this->db->get("desa_jabatan");
        // echo $this->db->last_query();
		$arr[""]  = "== Pilih Jabatan == ";
		foreach($res->result() as $row) :
			$arr[$row->jabatan]  = $row->jabatan;
		endforeach;
		return $arr;
	}

  

}
