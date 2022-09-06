<link href="<?php echo base_url(); ?>assets/admin/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $title ?></a></li>
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
                    
                     <div class="button-list">
                        <button type="button" onclick="add()" class="btn btn-success btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button>
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                    </div>
                    <hr>
                   
                        <form id="form-filter">
                            <div class="row">
                               
                      


                             <div class="col-md-12">
                                <div class="form-group">
                                    <label >Nama Peserta</label>
                                    <input class='form-control' type="text" id="nama_cari" autocomplete="off">
                                </div>
                            </div> 


                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <a href="javascript: void(0);"  id="btn-filter" class="btn btn-blue btn-sm mr-1">
                                        <i class="fa fa-search"></i> Cari
                                    </a>
                                    <a href="javascript: void(0);" id="btn-reset" class="btn btn-danger btn-sm ">
                                        <i class="fa fa-undo"></i> Reset
                                    </a> 
                                </div>
                            </div>
                        </div>
                    </form>
                  


                    <span id="nama_f"></span>
                    <table id="datable_1" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="2%" class="float-center">
                                    <div class="checkbox checkbox-primary checkbox-single">
                                        <input id="check-all" type="checkbox">
                                        <label></label>
                                    </div>
                                </th>
                                <th width="3%" ><strong>No.</strong>    </th>
                                <th >Nama</th>
                                <th >Share</th>
                               
                                
                               
                              
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->


  <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="display: none;">
        <div class="modal-dialog  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="mymodal-title" id="full-width-modalLabel">Modal Heading</h4>
                    <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="form_app" method="post"  enctype="multipart/form-data" >
                        <input type="hidden" name="id_peserta" id="id_peserta">
                         <div class="form-group mb-3">
                            <label class="text-primary">Sebutan</label>
                            <input class='form-control' name="gambar" type="text" id="gambar" autocomplete="off">
                            <small>Contoh : Bapak, Ibu, Saudara, Saudari, Mr dll</small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="text-primary">Nama</label>
                            <input class='form-control' name="nama" type="text" id="nama" autocomplete="off">
                        </div>
                       
                        
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
                        <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php   $this->load->view($controller."_js");
    ?>

  
</div>
