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
                        <!-- <button type="button" onclick="add()" class="btn btn-success btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-plus"></i></span>Tambah
                        </button>
                        <button type="button" onclick="edit()" class="btn btn-info btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-edit"></i></span>Edit
                        </button> -->
                        <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
                            <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
                        </button>
                    </div>
                    <hr>
                   
                        <form id="form-filter">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cwebsite">Kecamatan</label>
                                        <?php 
                                        $id_kecamatan = isset($id_kecamatan)?$id_kecamatan:"";
                                        echo form_dropdown("id_kecamatan",$this->dm->arr_pkm(),$id_kecamatan,'id="id_kecamatan" onchange="get_desa(this,\'#id_desa_cari\',1)" class="form-control"') 
                                        ?>
                                    </div>
                                </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cwebsite">Desa</label>
                                     <?php  echo form_dropdown("id_desa",array(),'','id="id_desa_cari" class="form-control" data-toggle="select2"');   ?>

                                    <small id="loading" class="text-danger"></small>
                                </div>
                            </div>
                      
                            <div class="col-md-4">
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
                                <th >Jabatan</th>
                                <th >No. Hp</th>
                                
                                <th >Pembayaran</th>
                                <th >Desa</th>
                                <th >Kecamatan</th>
                                 <th >Detail</th>
                               
                              
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->




    <?php   $this->load->view($controller."_js");
    ?>

  
</div>
