<script type="text/javascript">
	$(document).ready(function() {
		$('.spinner-grow').hide(); 
        $('#spinner_cek').hide();
        $('#spinner_info').hide(); 
        $("#home1").hide();
       // $("#btn-tambah").hide();
       reload_peserta();
        
		<?php if ($this->session->userdata("add_peserta") != "") {?>
			reload_peserta();
		<?php } ?>
		const actualBtn = document.getElementById('actual-btn');

		const fileChosen = document.getElementById('file-chosen');

		actualBtn.addEventListener('change', function(){
			fileChosen.textContent = this.files[0].name
		})

		<?php if ($this->session->userdata("validasi") == true) {?>
            $("#btn-tambah").hide();
            // $("#btn-tambahlagi").show();
            // $("#tampil_peserta").show();
			// $("#id_kecamatan").val(<?php echo $this->session->userdata("kecamatan"); ?>);
			$('#frm_id_desa').show();
			<?php if ($this->session->userdata("lunas") == "L") {?>
				$(".lunas_foto").show();
			<?php } else {?>
				$(".lunas_foto").hide();
			<?php } ?>
			
		<?php } else {?>
			$('#frm_id_desa').hide();
			$(".lunas_foto").hide();
		<?php } ?>
		
		
		// $('#id_desa_cari,#id_kecamatan').select2();
		$("#btn-loader").hide();
		$("#btn-loader-reset").hide();
		$('form').bind("keypress", function(e) {
			if (e.keyCode == 13) {               
				e.preventDefault();
				return false;
			}
		});

		$("#lunas").change(function(){
            if($(this).val() == "L") {
                $(".lunas_foto").show();
            }
            else {
                $(".lunas_foto").hide();
            }
        });

		// <?php if ($this->session->userdata("validasi") == true) {?>
		// 	<?php if ($this->session->userdata("jumlah_peserta") == "1") { ?>
		// 		$(".satupeserta").show();
		// 		$(".duapeserta").hide();
		// 	<?php } else {?>
		// 		$(".satupeserta").hide();
		// 		$(".duapeserta").show();
		// 	<?php } ?>
		// <?php } ?>

		// $(".satupeserta").hide();
		// $(".duapeserta").hide();
		// $("#jumlah_peserta").change(function(){
  //           if($(this).val() == "1") {
  //               $(".satupeserta").show();
  //               $(".duapeserta").hide();
  //           } else if ($(this).val() == "2") {
  //           	$(".duapeserta").show();
  //           	$(".satupeserta").hide();
  //           } else {
  //           	$(".duapeserta").hide();
  //           	$(".satupeserta").hide();
  //           }
            
  //       });
		
		$('.form-checkbox').click(function(){
			if($(this).is(':checked')){
				$('#kode').attr('type','text');
			}else{
				$('#kode').attr('type','password');
			}
		});
	});

	function get_desa(id,target,dropdown){
		$('#frm_id_desa').show();
		$("#loading").html('Loading data....');
		console.log('id desa' + $(id).val() );
		$.ajax({
			url:'<?php echo site_url("daftar/get_desa"); ?>/'+$(id).val()+'/'+dropdown,
			success: function(data){
				$("#loading").hide();
				$(target).html('').append(data);
                // $("#btn-tambah").show();
                $("#tampil_peserta").show();
			}
		});
	}

	function add(){ 
		// reset_select();
		$('#form_app')[0].reset(); 
		save_method = 'add';
		$('#id_peserta_temp').val("");
		$('#full-width-modal').modal('show'); 
		$('.mymodal-title').text('Tambah Peserta'); 
	}

    function close_modal(){
        Swal.fire({
            title: "Yakin ingin membatalkan ?",
            text: "Anda tidak dapat mengembalikan data yang belum tersimpan",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Tutup",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                $("#full-width-modal").modal("hide");
            } 
        })
    }
    function loader() {
        Swal.fire({
            title: "Prosess...",
            html: "Jangan tutup halaman ini",
            allowOutsideClick: false,
            onBeforeOpen: function() {
                Swal.showLoading()
            },
            onClose: function() {
                clearInterval(t)
            }
        })
    }

    function simpan(){
        var url;
        if(save_method == 'add') {
            url = "<?php echo site_url('daftar/add_peserta')?>/";
        } else if (save_method == 'update_peserta') {
            url = "<?php echo site_url('daftar/update_peserta_dua')?>/";
        } else {
            url = "<?php echo site_url('daftar/update_peserta')?>/";
        }   

        $('#form_app').form('submit',{
            url: url,
            onSubmit: function(){
                loader();
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
                Swal.fire({
                    title: obj.title,  
                    html: obj.pesan,   
                    type: "success",
                    allowOutsideClick: false,
                    confirmButtonClass: "btn btn-confirm mt-2"
                });

                $("#full-width-modal").modal("hide"); 
                reload_peserta();
                cek();
            }   
        }
        });
    }

    function reload_peserta(){
    	$('.spinner-grow').show(); 
    	$.ajax({
    		url :'<?php echo site_url("daftar/reload_peserta"); ?>/',
    		success: function(result){
    			$("#tampil_peserta").html(result);
    			$('.spinner-grow').hide(); 

    		}

    	});
    }

    function home(){
        $("#tampil_cek_view").hide();
        $("#tampil_cek_info").hide();
        $('.spinner-grow').show(); 
        $("#home1").show();
        $("#ber").hide();
        $('.spinner-grow').hide(); 
    }

    function cek_status(){
        $('#spinner_info').hide();
        $("#home1").hide();
        $("#ber").hide();
        $("#tampil_cek_info").hide();
        $('#spinner_cek').show(); 

        $.ajax({
            url :'<?php echo site_url("daftar/cek_status"); ?>/',
            success: function(result){
                $("#tampil_cek_view").show();
                $("#tampil_cek_view").html(result);
                $('#spinner_cek').hide(); 
                $('.spinner-grow').hide(); 
                $('#spinner_hasil').hide(); 

            }

        }); 
    }

    function cek_info(){
        $('#spinner_cek').hide(); 
        $("#home1").hide();
        $("#tampil_cek_view").hide();
        $('#spinner_info').show(); 
        $.ajax({
            url :'<?php echo site_url("daftar/cek_info"); ?>/',
            success: function(result){
                $("#tampil_cek_info").html(result);
                $("#tampil_cek_info").show();
                $('#spinner_info').hide(); 
                

            }

        }); 
    }

    function cek(){
     	// $('.spinner-grow').show(); 
        $('#spinner_hasil').show(); 
     	no_hp = $("#no_hp_cek").val();
        if (no_hp == "") {
            swal.fire({   
                title: "Peringatan",   
                type: "error", 
                html: "Masukkan No Hp",
                allowOutsideClick: false,
                confirmButtonClass: "btn btn-confirm mt-2"   
            });
            // $('.spinner-grow').hide(); 
            $('#spinner_hasil').hide(); 
        } else {
            $.ajax({
                url :'<?php echo site_url("daftar/cek"); ?>/'+no_hp,
                success: function(result){
                    $("#tampil_cek").html(result);
                    // $('.spinner-grow').hide(); 
                    $('#spinner_hasil').hide(); 

                }

            }); 
        }
    	
    }

	$(document).on('click', '#btn-login', function(e) {
		e.preventDefault();
		swal({
			title: 'Konfirmasi',
			input: 'checkbox',
			inputValue: 0,
			html: "Nama Peserta : "+" "+$("#nama").val()+"<br>Jabatan : "+$("#jabatan").val()+"<br>Kecamatan : <?php echo $this->session->userdata("kecamatan") ?>",
			showCancelButton: true,
			inputPlaceholder: ' Benar Ini adalah data saya',
			confirmButtonText: 'Daftar',
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Periksa Kembali',
			inputValidator: function (result) {
				return new Promise(function (resolve, reject) {
					if (result) {
						$('#frm').form('submit',{
							url: '<?php echo site_url("daftar/get_daftar") ?>',
							onSubmit: function(){
								Swal.fire({
									title: "Menyimpan...",
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
									Swal.fire({
										title: obj.title,  
										html: obj.pesan,   
										type: "success",
										allowOutsideClick: false,
										confirmButtonClass: "btn btn-confirm mt-2"
									})
								}
							}
						});
					} else {
						Swal.fire({
							title: "Gagal",
							text: "Silahkan Centang Benar Ini adalah data saya",
							type: "info",
							confirmButtonClass: "btn btn-confirm mt-2"
						})
					}
				})
			}
		}).then(function (result) {
			// $('#frm').submit();
		});
	});


    

    <?php if ($this->session->userdata("validasi") == true)  {?>
    	function daftar_ses(){
    		$('#frm').form('submit',{
    			url: '<?php echo site_url("daftar/daf_ses") ?>',
    			onSubmit: function(){

    				Swal.fire({
    					title: "Menyimpan...",
    					html: "Jangan tutup halaman ini",
    					allowOutsideClick: false,
    					onBeforeOpen: function() {
    						Swal.showLoading()
    					},
    					onClose: function() {
    						clearInterval(t)
    					}
    				})
                //loader
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
            		location.href='<?php echo site_url("daftar/konfirmasi") ?>'
                    // Swal.fire({
                    //     title: obj.title,  
                    //     html: obj.pesan,   
                    //     type: "success",
                    //     allowOutsideClick: false,
                    //     confirmButtonClass: "btn btn-confirm mt-2"
                    // })
                }
            }
        });

    	}
    <?php } else {?>
    	function daftar(){
    		$('#frm').form('submit',{
    			url: '<?php echo site_url("daftar/daf") ?>',
    			onSubmit: function(){

    				Swal.fire({
    					title: "Menyimpan...",
    					html: "Jangan tutup halaman ini",
    					allowOutsideClick: false,
    					onBeforeOpen: function() {
    						Swal.showLoading()
    					},
    					onClose: function() {
    						clearInterval(t)
    					}
    				})
                //loader
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
            		location.href='<?php echo site_url("daftar/konfirmasi") ?>'
                    // Swal.fire({
                    //     title: obj.title,  
                    //     html: obj.pesan,   
                    //     type: "success",
                    //     allowOutsideClick: false,
                    //     confirmButtonClass: "btn btn-confirm mt-2"
                    // })
                }
            }
        });

    	}
    <?php } ?>

	function dafztar(){
		$("#btn-login").hide();
		$("#btn-loader").show()	;
		$('#frm').form('submit',{
			url: '<?php echo site_url("daftar/daftar"); ?>',				 
			success: function(result){
				console.log(result);
				result = result.replace(/\s+/g, " ");
				obj = $.parseJSON(result);
				console.log(obj.pesan);
				if (obj.success == false ){
					$('#Capctha').text(obj.new);
						Swal.fire({
							title: obj.title,   
							text: obj.pesan,
							type: obj.type,   
							confirmButtonClass: "btn btn-confirm mt-2",
								// footer: '<a href="">Why do I have this issue?</a>'
						})
					$("#btn-login").show();
					$("#btn-loader").hide();

				} else {
					location.href='<?php echo site_url("daftar/reload") ?>'

				}
			}
		});
		return false;
	}



	function validasiFile(){
            var inputFile = document.getElementById('gambar');
            var pathFile = inputFile.value;
            var ekstensiOk = /(\.jpg|\.jpeg|\.png|\.gif|\.ico)$/i;
            // var ekstensiOk = /(\.on)$/i;
            if(!ekstensiOk.exec(pathFile)){
                Swal.fire({
                    type: "error",
                    title: "File tidak diterima",
                    text: "Silakan upload file gambar yang memiliki ekstensi .jpg/.jpeg/.png/.gif/.ico",
                    confirmButtonClass: "btn btn-confirm mt-2",
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
                inputFile.value = '';
                return false;
            } else {
                return true;
            }
    } 

</script>