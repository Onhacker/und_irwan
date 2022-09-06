<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cek_desa_id extends CI_Model {
	var $table = 'tiger_desa2';
	var $column_order = array('','tiger_desa2.desa','tiger_kecamatan.kecamatan');
	var $column_search = array('tiger_desa2.desa','tiger_kecamatan.kecamatan'); 
	var $order = array('tiger_desa.desa' => 'ASC');
	public function __construct(){
		parent::__construct();
	}
	private function get_data_query($id,$id_kota){
		$this->db->select('tiger_desa2.desa,tiger_desa2.id,tiger_desa2.id_kecamatan,tiger_kecamatan.kecamatan, proyek.id_proyek');
        $this->db->from("tiger_desa2");
        $this->db->where("tiger_desa2.kelompok", $id);
        $this->db->join("tiger_kecamatan", 'tiger_desa2.id_kecamatan = tiger_kecamatan.id');
        $this->db->join("proyek", 'proyek.id_kota = tiger_kecamatan.id_kota');
        
        // $this->db->from($this->table);
        $i = 0;
		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->like($item, $_POST['search']['value']);
				}
				// else {
				// 	$this->db->or_like($item, $_POST['search']['value']);
				// }

				if(count($this->column_search) - 1 == $i);

			}
			$i++;
		}
		$this->db->where("proyek.id_proyek", $id);
        $this->db->where("proyek.id_kota",$id_kota);
		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by('desa', 'ASC');
		}

	}

	function get_data($id,$id_kota){
		$this->get_data_query($id,$id_kota);
		if ($_POST["length"] == "-1") {
			$query = $this->db->get();
		} else {
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
		}	
		return $query->result();
		
	}

	function count_filtered($id,$id_kota){
		$this->get_data_query($id,$id_kota);
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all($id,$id_kota){
		$this->db->select('tiger_desa2.desa,tiger_desa2.id,tiger_desa2.id_kecamatan,tiger_kecamatan.kecamatan, proyek.id_proyek');
        $this->db->from("tiger_desa2");
        $this->db->join("tiger_kecamatan", 'tiger_desa2.id_kecamatan = tiger_kecamatan.id');
        $this->db->join("proyek", 'proyek.id_kota = tiger_kecamatan.id_kota');
        $this->db->where("proyek.id_proyek", $id);
        $this->db->where("tiger_desa2.kelompok", $id);
        $this->db->where("proyek.id_kota",$id_kota);
		return $this->db->count_all_results();
	}



}
