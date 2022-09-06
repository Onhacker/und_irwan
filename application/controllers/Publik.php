<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publik extends Onhacker_Controller {
	function __construct(){
		parent::__construct();

	}

	function index(){
		echo "fuck";
	}

	function error(){
        $data['title'] = "Halaman Tidak Ditemukan - ".$this->fm->web_me()->nama_website;
        // $data["description"] = $this->fm->web_me()->meta_deskripsi;
        // $data["keywords"] = $this->fm->web_me()->meta_keyword;
        // $data["content"] = $this->load->view(onhacker_view("Error_view"),$data,true); 
        // $this->render($data);
       $this->load->view(onhacker_view("Error_view"),$data); 
    }



    function validasi($id) {
        
        $this->db->where("id_desa", $id);
        $re = $this->db->get("peserta");
        // echo $this->db->last_query();
        if ($re->num_rows() == 0) {
            $data['title'] = "Halaman Tidak Ditemukan - ".$this->fm->web_me()->nama_website;
            $this->load->view(onhacker_view("Error_view"),$data); 
        } else {

            $this->db->where("id_desa", $id);
            $data["res"] = $this->db->get("peserta");

            $this->db->where("id_desa", $id);
            $data["rec"] = $this->db->get("peserta")->row(); 

            $this->db->where("id", $id);
            $data["desa"] = $this->db->get("tiger_desa")->row();

            $this->db->where("id", $data["desa"]->id_kecamatan);
            $data["kecamatan"] = $this->db->get("tiger_kecamatan")->row();

            $this->db->where("id", $data["kecamatan"]->id_kota);
            $data["kota"] = $this->db->get("tiger_kota")->row();


            $this->db->where("id_desa", $id);
            $this->db->group_by("id_desa");
            $data["ket"] = $this->db->get("peserta")->row();


            $data["title"] = "Validasi Pendaftaran Desa ".$data["desa"]->desa;


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
        $data['data'] = site_url("publik/validasi/".$id); //data yang akan di jadikan QR CODE
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
        $pdf->AddPage("P", "F4");
        if ($data["rec"]->lunas == "L") {
            $html = $this->load->view("validasi",$data,true);
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
