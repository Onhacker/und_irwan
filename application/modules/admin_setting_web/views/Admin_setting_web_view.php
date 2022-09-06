<link href="<?php echo base_url("assets/admin") ?>/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><?php echo $title ?></li>
                        <li class="breadcrumb-item active"><?php echo $subtitle ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $subtitle ?></h4>
            </div>
        </div>
    </div>     

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="form_app" method="post"  enctype="multipart/form-data" >

                             

                                <div class="form-group mb-3">
                                    <label class="text-primary" for="simpleinput">Provinsi</label>
                                    <?php 
                                    $record->id_provinsi = isset($record->id_provinsi)?$record->id_provinsi:"";
                                    echo form_dropdown("id_provinsi",$this->dm->arr_prov(),$record->id_provinsi,'id="id_provinsi" onchange="get_kota(this,\'#id_kota_cari\',1)" class="form-control"') 
                                    ?>
                                   
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Kab/Kota</label>
                                    <?php 
                                    $$record->id_kota = isset($record->id_kota)?$record->id_kota:"";
                                    echo form_dropdown("id_kota",$this->dm->arr_kota(),$record->id_kota,'id="id_kota_cari"  class="form-control" data-toggle=""') 
                                    ?>
                                     <small id="loading" class="text-danger"></small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-primary" for="simpleinput">Nama System</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->nama_website))?$record->nama_website:"";  ?>"  id="nama_website" name="nama_website" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Pembayaran per peserta/desa</label>
                                    <?php    
                                    $arr_per = array("peserta"=>"Per Peserta",
                                      "desa" => "Per Desa");
                                    $per = isset($record->per)?$record->per:"";
                                    echo form_dropdown("per",$arr_per,$per,'class="form-control"') ?>
                                 
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Jumlah Peserta</label>
                                   
                                    <?php    
                                    $arr_tahun_awal = array(
                                        "0" => "Bebas",
                                        "1"=>"1 Peserta",
                                      "2" => "2 peserta",
                                      "3" => "3 peserta",
                                      "4" => "4 Peserta");
                                    $tahun_awal = isset($record->tahun_awal)?$record->tahun_awal:"";
                                    echo form_dropdown("tahun_awal",$arr_tahun_awal,$tahun_awal,'class="form-control"') ?>
                                  
                                 
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Jumlah Pembayaran</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->uang))?$record->uang:"";  ?>"  id="uang" name="uang" placeholder="">
                                </div>
                                
                               
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Penanda Tangan</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->kadis))?$record->kadis:"";  ?>"  id="kadis" name="kadis" placeholder="">
                                </div>
                               
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Tempat Pelaksanaan</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->hotel))?$record->hotel:"";  ?>"  id="hotel" name="hotel" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Tanggal Pelaksanaan</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->tgl_acara))?$record->tgl_acara:"";  ?>"  id="tgl_acara" name="tgl_acara" placeholder="">
                                </div>
                                
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">No. HP/ Whatsapp</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->no_telp))?$record->no_telp:"";  ?>"  id="no_telp" name="no_telp" placeholder="">
                                    <small class="text-info">Contoh : 085203954888. Isikan no hp agar Desa dapat melihat informasi kontak anda</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Email</label>
                                     <input type="text" class="form-control" value="<?php echo (isset($record->email))?$record->email:"";  ?>"  id="email" name="email" placeholder="">
                                    <small class="text-info">Email ini digunakan sebagai pengirim pesan otomatis (Seperti mengirim link reset password otomatis) .</small>
                                </div>
                              
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Waktu Lokasi</label>
                                    <?php    
                                    $arr_waktu = array("Asia/Jakarta"=>"WIB",
                                      "Asia/Makassar" => "WITA",
                                      "Asia/Jayapura" => "WIT");
                                    $waktu = isset($record->waktu)?$record->waktu:"";
                                    echo form_dropdown("waktu",$arr_waktu,$waktu,'class="form-control"') ?>
                                 
                                </div>

                                <div class="row">
                                  <div class="col-6">
                                    <a href="javascript:;" onclick="update()" id="btn-login" class="btn btn-primary btn-block">Update</a>
                                </div>
                                <div class="col-6">
                                    <button type="reset" onclick="home()" class="btn btn-block  btn-secondary waves-effect m-l-5">
                                        Batal
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view($controller."_js"); ?>

    
</div>
