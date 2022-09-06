<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Terima Kasih</title>
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
                            <div class="col-lg-12 ">
                                <div class="card">
                                        
                                    <div class="card-body">         
                                        <a href="javascript:void(0);" class="btn btn-xs btn-danger">Periksa Kembali</a>
                                        <a href="javascript:void(0);" onclick="finish()" class="btn btn-xs btn-primary">Finish/ Selesai</a>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">

                             

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
<!-- <?php $this->load->view("daftar_js") ?> -->
<script type="text/javascript">
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
                    // loader();
                    $.ajax({
                        type: "POST",
                        url : "<?php echo site_url('daftar/finish')?>/",
                        // data: {id:list_id},
                        cache : false,
                        dataType: "json",
                        success: function(result) {
                            Swal.close();
                            reload_table();
                            if(result.success == false){
                                Swal.fire(result.title,result.pesan, "error");
                                return false;
                            } else {
                                Swal.fire(result.title,result.pesan, "success");
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("fucks");
                        }
                    });
                } else {
                    // $('#summernote').summernote("insertImage", src);
                }
            })
    }
</script>