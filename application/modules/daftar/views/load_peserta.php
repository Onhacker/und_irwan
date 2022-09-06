<div class="card-box text-center">
    
   <?php 
   $i = 1;
   foreach ($peserta_temp->result() as $row) : ?>

    <h4 class="mb-0"><?php echo $i++.". ".$row->nama ?></h4>
    <p class="text-black"><?php echo $row->jabatan ?><br><?php echo $row->no_hp ?></p>

    <button type="button" onclick="edit(<?php echo $row->id_peserta_temp ?>)" class="btn btn-success btn-xs waves-effect mb-2 waves-light">Edit</button>
    <button type="button" onclick="hapus_data(<?php echo $row->id_peserta_temp ?>)" class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Hapus</button>
    <hr>
    <?php endforeach; ?>
     <button type="button" onclick="add()" id="btn-tambahlagi" class="btn btn-blue btn-block btn-rounded waves-effect waves-light">
    <i class="fe-user-plus"></i> TAMBAH PESERTA
                                           </button>
</div>


<script type="text/javascript">
    function edit(list_id) {
        $('#form_app')[0].reset(); 
        loader();
            save_method = 'update';
            $.ajax({
                url : "<?php echo site_url('daftar/edit')?>/" + list_id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    Swal.close();
                    $('#id_peserta_temp').val(data.id_peserta_temp);
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

    function hapus_data(list_id) {
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
                        url : "<?php echo site_url('daftar/hapus_data')?>/"+list_id,
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