<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Konfirmasi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Onhacker.net" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('assets') ?>/images/favicon.ico">
    <!-- Sweet Alert-->
    <link href="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="<?php echo base_url('assets/admin') ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/admin') ?>/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/admin") ?>/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
     <link href="<?php echo base_url(); ?>assets/admin/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
     <script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>

</head>

<body class="authentication-bg authentication-bg-pattern">

    <div class="account-pages mt-5 mb-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-2">
                            <div class="col-lg-12 " id="iden">
                                <div class="card">
                                     <div class="card-body">
                                        <h4 class="card-title text-center">KONFIRMASI DATA PENDAFTARAN<br>Traning & Edukasi<br><?php echo $this->fm->web_me()->nama_website."<br>".$this->fm->web_me()->kota ?></h4>
                                                                        
                                    </div>
                                    <?php if ($this->session->userdata("lunas") == "L") { ?>
                                        <div class="card-body">
                                            <h5 class="card-title">Bukti Transfer</h5>

                                            <img class="card-img-top img-fluid" src="<?php echo site_url("upload/gambar/").$this->session->userdata("gambar") ?>" alt="Card image cap">
                                        </div>
                                    <?php } ?>
                                   
                                    <ul class="list-group list-group-flush">

                                        <div class="card-box text-center">
                                            <label class="text-primary" for="emailaddress" style="color: #00a192 !important ;"><h4><strong><u>Peserta</u></strong></h4></label>
                                         <?php 
                                         $i = 1;
                                         foreach ($peserta_temp->result() as $row) : ?>

                                            <h4 class="mb-0"><?php echo $i++.". ".$row->nama ?></h4>
                                            <p class="text-black"><?php echo $row->jabatan ?><br><?php echo $row->no_hp ?></p>

                                            <hr>
                                        <?php endforeach; ?>
                                      
                                    </div>

                                        <li class="list-group-item">
                                        </li>
                                        <?php 
                                            $this->db->where("id", $this->session->userdata("kecamatan"));
                                            $kec = $this->db->get("tiger_kecamatan")->row();
                                        ?>
                                        <li class="list-group-item">Kecamatan : <strong><?php echo $kec->kecamatan; ?></strong></li>
                                        <?php 
                                            $this->db->where("id", $this->session->userdata("desa"));
                                            $des = $this->db->get("tiger_desa")->row();
                                        ?>
                                        <li class="list-group-item">Desa : <strong><?php echo $des->desa; ?></strong></li>
                                        <li class="list-group-item">Waktu Register : <strong><?php echo tgl_df($this->session->userdata("tanggal")) ; ?></strong></li>
                                        <?php if ($this->session->userdata("lunas") == "L") { ?>
                                        <li class="list-group-item">Status Pembayaran : <strong class="text-success">Lunas</strong></li>
                                        <?php } else {?>
                                            <li class="list-group-item">Status Pembayaran : <strong class="text-danger">Belum Bayar</strong></li>
                                        <?php } ?>
                                      
                                    </ul>
                                    <div style="padding: 0.5rem !important">         
                                        <a href="javascript:void(0);" onclick="periksa()" class="btn  btn-danger">Periksa Kembali</a>
                                        <a href="javascript:void(0);" onclick="finish()" class="btn  btn-primary ml-5">Finish/ Selesai</a>
                                    </div>
                                </div>
                            </div>
                           <div class="card bg-pattern" id="fin">

                            <div class="card-body p-4">
                                <div class="mt-3 text-center">
                                    <svg version="1.1" xmlns:x="&amp;ns_extend;" xmlns:i="&amp;ns_ai;" xmlns:graph="&amp;ns_graphs;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 98 98" style="height: 120px;" xml:space="preserve">
                                        <style type="text/css">
                                            .st0{fill:#FFFFFF;}
                                            .st1{fill:#1abc9c;}
                                            .st2{fill:#FFFFFF;stroke:#1abc9c;stroke-width:2;stroke-miterlimit:10;}
                                            .st3{fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-miterlimit:10;}
                                        </style>
                                            <g i:extraneous="self">
                                                <circle id="XMLID_50_" class="st0" cx="49" cy="49" r="49"></circle>
                                                <g id="XMLID_4_">
                                                    <path id="XMLID_49_" class="st1" d="M77.3,42.7V77c0,0.6-0.4,1-1,1H21.7c-0.5,0-1-0.5-1-1V42.7c0-0.3,0.1-0.6,0.4-0.8l27.3-21.7
                                                        c0.3-0.3,0.8-0.3,1.2,0l27.3,21.7C77.1,42.1,77.3,42.4,77.3,42.7z"></path>
                                                    <path id="XMLID_48_" class="st2" d="M66.5,69.5h-35c-1.1,0-2-0.9-2-2V26.8c0-1.1,0.9-2,2-2h35c1.1,0,2,0.9,2,2v40.7
                                                        C68.5,68.6,67.6,69.5,66.5,69.5z"></path>
                                                    <path id="XMLID_47_" class="st1" d="M62.9,33.4H47.2c-0.5,0-0.9-0.4-0.9-0.9v-0.2c0-0.5,0.4-0.9,0.9-0.9h15.7
                                                        c0.5,0,0.9,0.4,0.9,0.9v0.2C63.8,33,63.4,33.4,62.9,33.4z"></path>
                                                    <path id="XMLID_46_" class="st1" d="M62.9,40.3H47.2c-0.5,0-0.9-0.4-0.9-0.9v-0.2c0-0.5,0.4-0.9,0.9-0.9h15.7
                                                        c0.5,0,0.9,0.4,0.9,0.9v0.2C63.8,39.9,63.4,40.3,62.9,40.3z"></path>
                                                    <path id="XMLID_45_" class="st1" d="M62.9,47.2H47.2c-0.5,0-0.9-0.4-0.9-0.9v-0.2c0-0.5,0.4-0.9,0.9-0.9h15.7
                                                        c0.5,0,0.9,0.4,0.9,0.9v0.2C63.8,46.8,63.4,47.2,62.9,47.2z"></path>
                                                    <path id="XMLID_44_" class="st1" d="M62.9,54.1H47.2c-0.5,0-0.9-0.4-0.9-0.9v-0.2c0-0.5,0.4-0.9,0.9-0.9h15.7
                                                        c0.5,0,0.9,0.4,0.9,0.9v0.2C63.8,53.7,63.4,54.1,62.9,54.1z"></path>
                                                    <path id="XMLID_43_" class="st2" d="M41.6,40.1h-5.8c-0.6,0-1-0.4-1-1v-6.7c0-0.6,0.4-1,1-1h5.8c0.6,0,1,0.4,1,1v6.7
                                                        C42.6,39.7,42.2,40.1,41.6,40.1z"></path>
                                                    <path id="XMLID_42_" class="st2" d="M41.6,54.2h-5.8c-0.6,0-1-0.4-1-1v-6.7c0-0.6,0.4-1,1-1h5.8c0.6,0,1,0.4,1,1v6.7
                                                        C42.6,53.8,42.2,54.2,41.6,54.2z"></path>
                                                    <path id="XMLID_41_" class="st1" d="M23.4,46.2l25,17.8c0.3,0.2,0.7,0.2,1.1,0l26.8-19.8l-3.3,30.9H27.7L23.4,46.2z"></path>
                                                    <path id="XMLID_40_" class="st3" d="M74.9,45.2L49.5,63.5c-0.3,0.2-0.7,0.2-1.1,0L23.2,45.2"></path>
                                                </g>
                                            </g>
                                    </svg>

                                    <h3>Success !</h3>
                                    <p class="text-muted font-14 mt-2"> Terima Kasih Telah Melakukan Pendaftaran Online Traning & Edukasi <?php echo ucwords(strtolower($this->fm->web_me()->nama_website." ".$this->fm->web_me()->kota)) ?>
                                    <a href="<?php echo site_url("daftar") ?>" class="btn btn-block btn-pink waves-effect waves-light mt-3">Kembali</a>
                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                   

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

  

<footer class="footer footer-alt">
    <span class="text-white"><?php echo date("Y") ?> &copy; Powered By </span><a href="https://lpkpd.org" class="text-white-50">PKPD</a> 
</footer> 
<script src="<?php echo base_url("assets/admin") ?>/js/jquery-3.1.1.min.js"></script>

<!-- Vendor js -->
<script src="<?php echo base_url('assets/admin') ?>/js/vendor.min.js"></script>
<!-- Sweet Alerts js -->
<script src="<?php echo base_url('assets/admin') ?>/libs/sweetalert2/sweetalert2.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url('assets/admin') ?>/js/app.min.js"></script>
<!-- jqyery form-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.easyui.min.js"></script>
<script src="<?php echo base_url('assets/admin') ?>/js/jquery.form.js"></script>

<script src="<?php echo base_url("assets/admin") ?>/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url("assets/admin") ?>/js/pages/gallery.init.js"></script>
</body>
<script src="<?php echo base_url("assets/admin") ?>/libs/dropify/dropify_peng.js"></script>
<script src="<?php echo base_url("assets/admin/") ?>libs/select2/select2.min.js"></script>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        $("#fin").hide();
    });
    function periksa(){
        window.location.href = "<?php echo site_url("daftar"); ?>";
    }
    function finish() {
            Swal.fire({
                title: "Yakin Data Sudah Benar ?",
                text: "Pastikan Data anda sudah benar",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya Benar",
                cancelButtonText: "Batal",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:'<?php echo site_url("daftar/finish"); ?>/',
                        success: function(data){
                            $("#iden").hide();
                            $("#fin").show();
                        }
                    });
                } else {
                    // $('#summernote').summernote("insertImage", src);
                }
            })
    }
</script>