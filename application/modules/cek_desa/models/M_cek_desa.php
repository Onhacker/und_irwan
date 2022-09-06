<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_cek_desa extends CI_Model {
	var $table = 'proyek';
	var $column_order = array('','kota','provinsi','aplikasi','tgl_acara');
	var $column_search = array('kota','provinsi', 'aplikasi','tgl_acara'); 
	var $order = array('id_proyek' => 'DESC');
	public function __construct(){
		parent::__construct();
	}
	private function get_data_query(){
		$this->db->select('tiger_kota.kota,proyek.id_proyek,tiger_provinsi.provinsi,nama_website,aplikasi,proyek.id_kota,tgl_acara');
        $this->db->from("proyek");
        $this->db->join("tiger_kota", 'proyek.id_kota = tiger_kota.id');
        $this->db->join("tiger_provinsi", 'proyek.id_provinsi = tiger_provinsi.id');
        // $this->db->from($this->table);
		foreach ($this->column_search as $item) {
			if($_POST['search']['value']) {
				if($i===0){
					$this->db->like($item, $_POST['search']['value']);
				}
				else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i);

			}
			$i++;
		}

		if(isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if(isset($this->order)){
			$order = $this->order;
			$this->db->order_by('id_proyek', 'DESC');
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
		$this->db->select('tiger_kota.kota,proyek.id_proyek,tiger_provinsi.provinsi,nama_website,proyek.id_kota');
        $this->db->from("proyek");
        $this->db->join("tiger_kota", 'proyek.id_kota = tiger_kota.id');
        $this->db->join("tiger_provinsi", 'proyek.id_provinsi = tiger_provinsi.id');
		return $this->db->count_all_results();
	}



}
