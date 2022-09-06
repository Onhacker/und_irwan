<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Daftar Online <?php echo $rec->nama_website ?></title>
    
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, 
    user-scalable=0' >
    <meta content="Onhacker.net" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    
    <link rel="shortcut icon" href="<?php echo base_url('assets') ?>/images/favicon.ico">
    
    <link href="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo base_url('assets/admin') ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>

</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card bg-pattern">
                        <div class="card-body p-2">

                            <div class="text-center">

                                <span><img src="<?php echo base_url('assets/images/').$rec->gambar ?>" alt="<?php echo base_url('assets/images/').$rec->gambar ?>" height="80"></span>

                                <p class="text-primary mb-2 mt-2"><h3><strong>PENDAFTARAN ONLINE BIMTEK<br><?php echo ucwords(strtolower($rec->nama_website))."<br>Se - ".ucwords(strtolower($this->fm->web_me()->kota)) ?> di <?php echo ucwords(strtolower($this->fm->web_me()->hotel)) ?>  Tanggal <?php echo ucwords(strtolower($this->fm->web_me()->tgl_acara)) ?></strong></h3></p>
                            </div>
                            <hr>


                            <ul class="nav nav-pills navtab-bg nav-justified">
                                <li class="nav-item">
                                    <a href="#home1" onclick="home()" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        Pendaftaran<br>Peserta
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#profile1" onclick="cek_status()" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Cek Status<br>Pendaftaran
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#info1" onclick="cek_info()" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Info<br>BIMTEK
                                    </a>
                                </li>
                                
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="home1">
                                   <div class="row">
                                    <div class="col-lg-12">
                                        <div class="alert alert-dark bg-dark text-white border-0" role="alert">
                                            <h4 style="color: white">Silahkan Lakukan Transfer Ke<strong></h4>
                                            <table class="table table-centered" style="padding: 2px !important; color: white !important">
                                                <tr>
                                                    <td><strong>Rekening</strong></td>
                                                    <td>:</td>
                                                    <td>Bank BNI Cab. Pecenongan Jakarta</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nomor Rekening</strong></td>
                                                    <td>:</td>
                                                    <td>028.7989.244</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Nama Rekening</strong></td>
                                                    <td>:</td>
                                                    <td>Pusat Konsultasi Pemerintahan Daerah</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Jumlah Transfer</strong></td>
                                                    <td>:</td>
                                                    <td>Rp <?php echo uang($this->fm->web_me()->uang) ?> / <?php echo ($this->fm->web_me()->per) ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="p-sm-3">
                                            <h3 class=" mb-2 text-left text-pink "><strong>KONTAK PERSON : <?php echo ($this->fm->web_me()->no_telp). " a/n ".$this->fm->web_me()->kadis ?></strong></h3>
                                            <h3 class=" mb-2 text-center"><strong>PENDAFTARAN</strong></h3>
                                            <button type="button" onclick="add()" class="btn btn-blue  btn-rounded waves-effect waves-light">
                                             <i class="fe-user-plus"></i> TAMBAH PESERTA
                                         </button>

                                         <p></p>
                                         <div class="d-flex justify-content-center"><div class="spinner-grow text-primary m-2" role="status"></div></div>
                                         <div id="tampil_peserta"></div>


                                         <form id="frm" method="post" class="text-left" enctype="multipart/form-data">
                                            <div class="form-group mb-2">
                                                <label class="text-primary" for="emailaddress" style="color: #00a192 !important ;"><h4>Kecamatan</h4></label>
                                                <?php 
                                                $id_kecamatan = isset($id_kecamatan)?$id_kecamatan:$this->session->userdata("kecamatan");
                                                echo form_dropdown("id_kecamatan",$this->dm->arr_kec(),$id_kecamatan,'id="id_kecamatan" onchange="get_desa(this,\'#id_desa_cari\',1)" class="form-control form-control-lg"') 
                                                ?>
                                            </div>

                                            <div class="form-group mb-2" id="frm_id_desa">
                                             <label class="text-primary" for="emailaddress" style="color: #00a192 !important ;"><h4>Desa</h4></label><?php 
                                             if ($this->session->userdata("validasi") == true) {
                                                $id_desa = isset($id_desa)?$id_desa:$this->session->userdata("desa");
                                                echo form_dropdown("id_desa",$this->dm->arr_desa2(),$id_desa,'id="id_desa_cari" class="form-control form-control-lg" data-toggle=""') ;
                                            } else {
                                                $id_desa = isset($id_desa)?$id_desa:"";
                                                echo form_dropdown("id_desa",array(),'','id="id_desa_cari" class="form-control form-control-lg" data-toggle=""'); 
                                            }

                                            ?>
                                            <small id="loading" class="text-danger"></small>
                                        </div>


                                        <div class="form-group mb-2">
                                            <label class="text-primary" style="color: #00a192 !important ;"><h4>Pilih Pelunasan/Belum</h4></label>
                                            <select class="form-control form-control-lg" name="lunas" id="lunas">


                                                <?php if ($this->session->userdata("validasi") == true) {?>
                                                    <?php if ($this->session->userdata("lunas") == "L") {?><
                                                    <option value="L" selected="">Lunas</option>
                                                    <option value="B">Belum Bayar</option>
                                                <?php } elseif ($this->session->userdata("lunas") == "B") {?>
                                                    <option value="L">Lunas</option>
                                                    <option value="B" selected="">Belum Bayar</option>
                                                <?php } ?>
                                            <?php } else {?>
                                                <option value="">Pilih  Pelunasan</option>
                                                <option value="L">Lunas</option>
                                                <option value="B">Belum Bayar</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row lunas_foto">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label class="text-primary labelx" for="actual-btn" ><h4 style="color: white !important; text-align: center;"><i class="fe-image"></i> Upload Bukti Pembayaran </h4></label>
                                                <input type="file" name="gambar" id="actual-btn" hidden/>
                                                <span id="file-chosen"></span>
                                                <h4 class="text-danger">Silahkan Upload Bukti pembayaran (screenshot atau foto bukti pembayaran dalam bentuk JPG, PNG, JPEG)</h4>
                                            </div>
                                        </div> 

                                    </div>
                                    <style type="text/css">
                                        .labelx {
                                          background-color: indigo;
                                          color: white;
                                          padding: 0.5rem;
                                          width: 100%;
                                          /*font-family: sans-serif;*/
                                          border-radius: 0.3rem;
                                          cursor: pointer;
                                          margin-top: 1rem;
                                      }

                                      #file-chosen{
                                          margin-left: 0.3rem;
                                          font-family: sans-serif;
                                      }
                                  </style>


                                  <div class="form-group mb-0 text-center">
                                    <?php if ($this->session->userdata("validasi") == true) {?>
                                        <a href="javascript:;" onclick="daftar_ses()" id="btdn-login" class="btn btn-lg btn-primary btn-block " style="background-color: #00a192; border: none;">DAFTAR</a>
                                    <?php } else {?>
                                        <a href="javascript:;" onclick="daftar()" id="btdn-login" class="btn btn-lg btn-primary btn-block " style="background-color: #00a192; border: none;">DAFTAR</a>
                                    <?php } ?>

                                    
                                    <div class="spinner-border text-primary m-2" id="btn-loader" role="status" style="display: none;"></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="text-center text-danger" id="spinner_cek">Memuat Pengecekan....</div>
                <div id="tampil_cek_view">

                </div>
            </div>


            <div>

               <div class="text-center text-danger" id="spinner_info">Memuat Info....</div>
               <div id="tampil_cek_info">


               </div>
           </div>


       </div>
   </div> 
</div>

</div> 
</div>

</div>

</div>




<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
    <div class="modal-dialog  modal-dialog-scrollable modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form_app" method="post"  enctype="multipart/form-data" >
                    <input type="hidden" name="id_peserta_temp" id="id_peserta_temp">
                    <div class="form-group mb-3">
                        <label class="text-primary">Nama</label>
                        <input class='form-control' name="nama" type="text" id="nama" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">Jabatan</label>
                        <input class='form-control' name="jabatan" type="text" id="jabatan" autocomplete="off">
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-primary">No. HP/ Whatsapp</label>
                        <input class='form-control' name="no_hp" type="number" id="no_hp" autocomplete="off">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<footer class="footer footer-alt">
    <span class="text-white"><?php echo date("Y") ?> &copy; Powered By </span><a href="https://lpkpd.org" class="text-white-50">PKPD</a> 
</footer> 
<script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>


<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>

<script src="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.js"></script>


<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/jquery.form.js"></script>

<script src="<?php echo base_url("assets/admin") ?>/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
</body>
<script src="<?php echo base_url("assets/admin/") ?>libs/select2/select2.min.js"></script>
</html>
<?php $this->load->view("daftar_js") ?>