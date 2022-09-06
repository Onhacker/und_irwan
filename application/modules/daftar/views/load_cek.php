 <?php if ($peserta->num_rows() == 0) {?>
   <div class="alert alert-danger bg-danger text-white border-0" role="alert">
    Data tidak ditemukan
</div>
<?php } else { ?>
 <ul class="list-group list-group-flush">
    <li class="list-group-item"><strong>Nama Peserta :<br></strong>
      <div class="row">
        <?php 
        $i = 1;
        foreach ($peserta->result() as $row) : ?>
             <div class="col-lg-4">
               <div class="text-center card-box" style = "padding-top: 0.5rem !important; padding-right: 0.5rem !important; padding-bottom: 0.5rem !important; padding-left: 0.5rem !important;">
                <div>
                        <h4 ><a href="javscript:void(0)" class="text-dark"><?php echo $i++.". ".$row->nama ?></a></h4>
                        <p class="text-pink"><?php echo $row->jabatan ?> <span> | </span> <span class="text-pink"> <?php echo $row->no_hp ?> </span></p>
                        <button type="button"  onclick="edit_peserta(<?php echo $row->id_peserta ?>)" class="btn btn-info btn-xs waves-effect waves-light">Edit</button>    
                        <!-- <button type="button" onclick="hapus_peserta(<?php echo $row->id_peserta ?>)" class="btn btn-danger btn-xs waves-effect">Hapus</button> -->

                    </div> 
                </div> 
            </div>
        <?php endforeach; ?>
    </div>  
</li>

<?php 
$this->db->where("id", $pes->id_kecamatan);
$kec = $this->db->get("tiger_kecamatan")->row();
?>
<table class="table table-centered" style="padding: 2px !important">
    <tr>
        <td><strong>Kecamatan</strong></td>
        <td>:</td>
        <td><?php echo $kec->kecamatan; ?></td>
    </tr>
    <tr>
        <td><strong>Desa</strong></td>
        <td>:</td>
        <?php 
        $this->db->where("id", $pes->id_desa);
        $des = $this->db->get("tiger_desa")->row();
        ?>
        <td><?php echo $des->desa; ?></td>
    </tr>
    <tr>
        <td><strong>Waktu Pendaftaran</strong></td>
        <td>:</td>
        <?php 
            $ar = explode(" ", $pes->tanggal);
            $har = hari_ini($ar[1]);
        ?>
        <td><?php echo $har .", ".tgl_df($pes->tanggal) ; ?></td>
    </tr>
    <?php if ($pes->lunas == "L") { ?>
        <tr>
            <td><strong>Status Pembayaran</strong></td>
            <td>:</td>
            <td><strong class="text-success">Lunas</strong></td>
        </tr>
    <?php } else {?>
        <tr>
            <td><strong>Status Pembayaran</strong></td>
            <td>:</td>
            <td><strong class="text-danger">Belum Bayar</strong></td>
        </tr>
        <tr>
           
            <td colspan="3">
                <form id="form_up" method="post"  enctype="multipart/form-data">
                    <label class="text-primary labelz" for="actual-btnx" ><h4 style="color: white !important; text-align: center;">Upload Bukti Pembayaran </h4></label>
                    <input type="file" name="gambar" id="actual-btnx" hidden/>
                    <input type="hidden" name="id_desa" id="desa" value="<?php echo $pes->id_desa ?>">
                    <span id="file-chosenx"></span>
                    <p class="text-danger">Upload Bukti pembayaran (screenshot atau foto bukti pembayaran dalam bentuk JPG, PNG, JPEG)</p> 
                    <a href="javascript:;" onclick="update_bayar()" id="btdn-login" class="btn btn-lg btn-primary btn-block " style="background-color: #00a192; border: none;">UPDATE</a>
                </form>
                <style type="text/css">
                    .labelz {
                      background-color: indigo;
                      color: white;
                      padding: 0.1rem;
                      width: 100%;
                      /*font-family: sans-serif;*/
                      border-radius: 0.3rem;
                      cursor: pointer;
                      /*margin-top: 1rem;*/
                  }

                  #file-chosenx{
                      margin-left: 0.3rem;
                      font-family: sans-serif;
                  }
              </style>
              <script type="text/javascript">
                const actualBtnx = document.getElementById('actual-btnx');
                const fileChosenx = document.getElementById('file-chosenx');
                actualBtnx.addEventListener('change', function(){
                    fileChosenx.textContent = this.files[0].name
                })

                function update_bayar(){
                   
                    $('#form_up').form('submit',{
                        url: '<?php echo site_url("daftar/update_bayar") ?>/',
                        onSubmit: function(){
                            Swal.fire({
                                title: "Update...",
                                html: "Jangan tutup halaman ini",
                                allowOutsideClick: false,
                                onBeforeOpen: function() {
                                    Swal.showLoading()
                                },
                                onClose: function() {
                                    clearInterval(t)
                                }
                            })
                        return $(this).form('validate');
                        },
                        dataType:'json',
                        success: function(result){
                        console.log(result);
                        obj = $.parseJSON(result);
                        if (obj.success == false ){
                            swal.fire({   
                                title: obj.title,   
                                type: "error", 
                                html: obj.pesan,
                                allowOutsideClick: false,
                                confirmButtonClass: "btn btn-confirm mt-2"   
                            });
                            return false;
                        } else {
                            cek();
                            Swal.close();
                        }
                    }
                });

            }
            </script>
            </td>
        </tr>
    <?php } ?>

    <?php if ($pes->lunas == "L") { ?>
       <tr>
        <td><strong>Kode Pendaftaran</strong></td>
        <td>:</td>
        <td><button type="button" onclick="cetak_kode()" class="btn btn-success waves-effect waves-light ">Cetak Kode Pendaftaran </button></td>
    </tr>
    <?php } ?>
</table>

</ul>


<?php } ?>

 <?php if ($pes->lunas == "L") { ?>
<script type="text/javascript">
    function cetak_kode() {
        window.open("<?php echo site_url("daftar/kode/").$pes->id_desa ?>")
    
    }
</script>
<?php } ?>


<script type="text/javascript">
    function edit_peserta(list_id) {
        $('#form_app')[0].reset(); 
        loader();
            save_method = 'update_peserta';
            $.ajax({
                url : "<?php echo site_url('daftar/edit_peserta')?>/" + list_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    Swal.close();
                    $('#id_peserta_temp').val(data.id_peserta);
                    $('#nama').val(data.nama);
                    $('#jabatan').val(data.jabatan);
                    $('#no_hp').val(data.no_hp);
                    $('#full-width-modal').modal('show'); 
                    $('.mymodal-title').html('Edit Data <code>'+ data.nama+'</code>'); 
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error get data from ajax');
                }
            });

    }
    function hapus_peserta(list_id) {
            Swal.fire({
                title: "Yakin ingin menghapus  data ?",
                text: "Anda tidak dapat mengembalikan data terhapus",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya Hapus",
                cancelButtonText: "Batal",
                allowOutsideClick: false,
            }).then((result) => {
                if (result.value) {
                    loader();
                    $.ajax({
                        type: "POST",
                        url : "<?php echo site_url('daftar/hapus_data_peserta')?>/"+list_id,
                        // data: {id:list_id},
                        cache : false,
                        dataType: "json",
                        success: function(result) {
                            Swal.close();
                            reload_peserta();
                            if(result.success == false){
                                Swal.fire(result.title,result.pesan, "error");
                                return false;
                            } else {
                                Swal.fire(result.title,result.pesan, "success");
                                cek();

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
