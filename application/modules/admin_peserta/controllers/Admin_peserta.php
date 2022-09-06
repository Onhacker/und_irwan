<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_peserta extends Admin_Controller {
	function __construct(){
		parent::__construct();
		cek_session_akses(get_class($this),$this->session->userdata('admin_session'));
		$this->load->model("M_admin_peserta", "dm");
	}

	function index(){
        // redirect("https://lpkpd.org/");
		$data["controller"] = get_class($this);		
		$data["title"] = "Data Pendaftar";
		$data["subtitle"] = "Pendaftar" ;
		$data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
		$this->render($data);
	}


	function get_data(){   
        $list = $this->dm->get_data();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $res) {
            $no++;
            $row = array();
            $row["id_peserta"] = $res->id_peserta;
            $row["id_desa"] = $res->id_desa;
            $row["nama"] = $res->nama;
            $row["no_hp"] = $res->no_hp;

            
            $row["jabatan"] = $res->jabatan;
            $row["id_kecamatan"] = $res->id_kecamatan;
            if ($res->lunas == "L") {
                $row["lunas"] = '<span class="badge badge-success">Lunas</span> <a href="'.site_url("upload/gambar/").'/'.$res->gambar.'" target = "_BLANK"> <span class="badge badge-danger">Cek Bukti </span>  </a>';
                $row["detail"] = "<a target='_BLANK' href=".site_url('publik/validasi/').$res->id_desa." class='btn btn-info btn-xs waves-effect waves-light'> Detail</a>  ";
            } else {
                $row["lunas"] = '<span class="badge badge-danger">BB</span>';
                $row["detail"] = "";
            }
            $this->db->where("id", $res->id_desa);
            $de = $this->db->get("tiger_desa")->row();
            
            $this->db->where("id", $res->id_kecamatan);
            $kec = $this->db->get("tiger_kecamatan")->row();

            $row["nama_desa"] = "<span class ='text-primary'>".$de->desa."</span>";
            $row["kecamatan"] = "<span class ='text-primary'>".$kec->kecamatan."</span>";
            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single"> <input type="checkbox" class="data-check" value="'.$res->id_peserta.'"><label></label></div>';

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

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sekolah','Nama Sekolah','required'); 
        $this->form_validation->set_rules('id_desa','Desa','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $data["username"] = $this->session->userdata("admin_username");
            $data["id_pkm"] = $this->session->userdata("admin_pkm");
            
            $this->db->where("id_desa",$data["id_desa"]);
            $d = $this->db->get("master_desa")->row();
            $data["desa"] = $d->desa;
            $data["id_kecamatan"] = $d->id_kecamatan;

            $this->db->where("id_kecamatan",$data["id_kecamatan"]);
            $k = $this->db->get("master_kecamatan")->row();
            $data["kecamatan"] = $k->kecamatan;

            $this->db->where("sekolah",$data["sekolah"]);
            $res = $this->db->get("master_sekolah");

            if ($res->num_rows() >  0) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Sekolah Sudah Ada");
            } else {
                $this->db->insert('master_sekolah',$data); 
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            }
        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 
    
    function update(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        $this->form_validation->set_rules('sekolah','Nama Sekolah','required'); 
        $this->form_validation->set_rules('id_desa','Desa','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $this->db->where("id_desa",$data["id_desa"]);
            $d = $this->db->get("master_desa")->row();
            $data["desa"] = $d->desa;
            $data["id_kecamatan"] = $d->id_kecamatan;

            $this->db->where("id_kecamatan",$data["id_kecamatan"]);
            $k = $this->db->get("master_kecamatan")->row();
            $data["kecamatan"] = $k->kecamatan;

            $this->db->where("id_sekolah !=", $data["id_sekolah"]);
            $this->db->where("sekolah",$data["sekolah"]);
            $cek = $this->db->get("master_sekolah");
            $r = $cek->row();
            if ($cek->num_rows() >= 1) {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => $r->sekolah." Sudah ada");
                echo json_encode($ret);
                return false;
            }
            $this->db->where("id_sekolah",$data["id_sekolah"]);
            $res  = $this->om->update("master_sekolah",$data); 
            if($res) {    
                $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil diupdate");
            } else {
                $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Data Gagal diupdate ");
            }
    
        } else {
            $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => validation_errors());
        }
        echo json_encode($ret);
    } 

	
	function hapus_data(){
        $list_id = $this->input->post('id');
            foreach ($list_id as $id) {
                $this->db->where("id_peserta",$id);
                $x = $this->db->get("peserta")->row();
                $y = "upload/gambar/".$x->gambar;
                unlink($y);
                // unlink(site_url("upload/gambar/").$x->gambar);

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
            }
        echo json_encode($ret);
    } 


    function get_desa($id_kecamatan) {
        $form = $this->uri->segment(4);
        $sel="";
        $id_desa = $this->uri->segment(4);
        $this->db->where("id_kecamatan",$id_kecamatan);
        $this->db->order_by("desa");
        $res = $this->db->get("tiger_desa  ");
        //echo $this->db->last_query();
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

	
}
