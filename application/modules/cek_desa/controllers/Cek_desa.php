<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cek_desa extends MX_Controller {
	function __construct(){
		parent::__construct();
	}

	function index(){
		$data["des"] = "Data Peserta Kabupaten. Pusat Konsultasi Pemerintahan Daerah (PKPD)";
		$data["title"] = "Peserta Kabupaten";
		$data["e_heading"] = "Kabupaten";
		$this->load->view('cek_desa_view',$data);        
	}

	function get_data(){    
	 	$this->load->model("M_cek_desa",'dm');
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_proyek"] = $res->id_proyek;
            $row["tgl_acara"] = $res->tgl_acara;
            $row["kabupaten"] = '<a href="'.site_url("cek_desa/kode/").$res->id_proyek.'">'.ucwords(strtolower($res->kota)).'</a>';
            $row["prov"] = ucwords(strtolower($res->provinsi));
            $row["web"] = $res->aplikasi;
           
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->dm->count_all(),
                        "recordsFiltered" => $this->dm->count_filtered(),
                        "data" => $data,
                );
        // echo $this->db->last_query();
        echo json_encode($output);
    }

	function kode($id=""){
        if ($id == "") {
            redirect(site_url("cek_desa"));
        }
		$this->db->where("id_proyek", $id);
		$p = $this->db->get("proyek")->row();

		$this->db->where("id", $p->id_kota);
		$k = $this->db->get("tiger_kota")->row();

		$data["des"] = "Data Desa Training & Edukasi ". $p->nama_website." ".$k->kota." ".$p->tgl_acara. " di ".$p->hotel;
		$data["title"] = str_replace("KABUPATEN ", "", $k->kota);
		$data["e_heading"] = "" ;
        $data["kab"] = ucwords(strtolower($k->kota));
        $data["tgl"] = $p->tgl_acara;
        $data["a"] = $p->nama_website;
        $data["b"] = "Se - ". ucwords(strtolower($k->kota));
        $data["c"] = $p->hotel;
		$data["e_heading2"] = $p->nama_website." Se - ".ucwords(strtolower($k->kota))."<br>".$p->tgl_acara. " di ".$p->hotel ;
		$this->load->view('cek_kode_view',$data);        
	}

	function get_data_desa($id){  
        // if ($id == 7) {
        //         $this->load->model("M_cek_desa_id3",'dm');
        // }   elseif ($id == 10) {
        //     $this->load->model("M_cek_id10",'dm');
        // }   else {
            $this->load->model("M_cek_desa_id",'dm');
        // }
	 	
	 	$this->db->where("id_proyek", $id);
	 	$p = $this->db->get("proyek")->row();
        $list = $this->dm->get_data($id,$p->id_kota);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_proyek"] = $res->id_proyek;
            $row["desa"] = ucwords(strtolower($res->desa));
            $row["kec"] = ucwords(strtolower($res->kecamatan));
           
            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->dm->count_all($id,$p->id_kota),
                        "recordsFiltered" => $this->dm->count_filtered($id,$p->id_kota),
                        "data" => $data,
                );
        // echo $this->db->last_query();
        echo json_encode($output);
    }
	
}
