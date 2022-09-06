<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_peserta_fix extends Admin_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("M_admin_peserta_fix", "dm");
    }

    function index(){
        $this->db->where("id","1");
        $k = $this->db->get("id_kota")->row();
        $this->db->where("id",$k->id_kota);
        $kk = $this->db->get("tiger_kota")->row();
        $data["controller"] = get_class($this);     
        $data["title"] = "Data Undangan";
        $data["subtitle"] = "Undangan";
        $data["content"] = $this->load->view($data["controller"]."_view",$data,true); 
        $this->render($data);
    }


    function buat_name($l,$int = "") {
        // if ($int == "0") {
            $c = array (' ');
            $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+','–');
            $l = str_replace($d, '', $l); 
            $l = strtolower(str_replace($c, '_', $l));
            return $l;
        // }
       
        
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
            $row["nama"] = $res->gambar." ".$res->nama;
            $row["gambar"] = $res->gambar;

            
            $row["jabatan"] = $res->jabatan;
            $row["share"] = "<a target='_BLANK' href='https://api.whatsapp.com/send?text=_Assalamualaikum%20Warahmatullahi%20Wabarakatuh_%0A%0ATanpa%20mengurangi%20rasa%20hormat%2C%20perkenankan%20kami%20mengundang%20".$res->gambar."%20%0A%0A*[%20".$res->nama."%20]*%0A%0Auntuk%20menghadiri%20pernikahan%20kami%0A%0A*Irwan%20dan%20Imma*%0A%0ABerikut%20link%20undangan%20kami%2C%20untuk%20info%20lengkap%20dari%20acara%20bisa%20kunjungi%20%3A%0A".site_url("und/".$res->id_peserta."/".$this->buat_name($res->nama)."")."%20Merupakan%20suatu%20kebahagiaan%20bagi%20kami%20apabila%20".$res->gambar."%20berkenan%20untuk%20hadir%20dan%20memberikan%20doa%20restu.%0A%0AMohon%20maaf%20perihal%20undangan%20hanya%20di%20bagikan%20melalui%20pesan%20ini.%0ATerima%20kasih%20banyak%20atas%20perhatiannya.%0A%0A_Wassalamualaikum%20Warahmatullahi%20Wabarakatuh_
' class='btn btn-info btn-xs waves-effect waves-light'> Share</a> ";

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
        // echo $this->db->last_query();

        echo json_encode($data);
    }

    function add(){
        $data = $this->db->escape_str($this->input->post());
        $this->load->library('form_validation');
        // $this->form_validation->set_rules('id_kecamatan','Kecamatan','required'); 
        // $this->form_validation->set_rules('id_desa','Desa','required'); 
        $this->form_validation->set_rules('nama','Nama','required'); 
        // $this->form_validation->set_rules('id_jabatan','Jabatan','required'); 
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            $res = $this->db->insert('peserta',$data); 
            // echo $this->db->last_query();

            if ($res) {
               $ret = array("success" => true,
                    "title" => "Berhasil",
                    "pesan" => "Data berhasil disimpan");
            } else {
                 $ret = array("success" => false,
                    "title" => "Gagal",
                    "pesan" => "Sekolah Sudah Ada");
                
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
        // $this->form_validation->set_rules('id_kecamatan','Kecamatan','required'); 
        // $this->form_validation->set_rules('id_desa','Desa','required'); 
        $this->form_validation->set_rules('nama','Nama','required'); 
        // $this->form_validation->set_rules('id_jabatan','Jabatan','required');  
        $this->form_validation->set_message('required', '* %s Harus diisi ');
        $this->form_validation->set_error_delimiters('<br> ', ' ');
        if($this->form_validation->run() == TRUE ) { 
            
            $this->db->where("id_peserta",$data["id_peserta"]);

            

            $res  = $this->db->update("peserta",$data); 
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

    function get_desa2($id_kecamatan) {
        $form = $this->uri->segment(4);
        $sel="";
        $id = $this->uri->segment(4);
        $this->db->where("id_kecamatan",$id_kecamatan);
        $this->db->order_by("id");
        $res = $this->db->get("tiger_desa");
       
        $str = "";

        if($form<>0) {
        $str .="<option value=''> == Pilih Desa == </option> "; }
        else {
            $str .="<option value=''> == Pilih Desa == </option> ";
        }
        foreach($res->result() as $row) :
            if($id!='') {
                $sel = ($row->id == $id)?"selected":"";
            }
             $str .= "<option value=\"$row->id\" $sel> $row->desa </option> \n";
        endforeach;
        echo $str;
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
