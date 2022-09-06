<div class="tab-pane show" id="profile1">
	<a href="<?php echo site_url("daftar/download") ?>"class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-file-pdf"></i> Download Undangan</a>
	
	<hr>
	<form id="form_cek" method="post"  enctype="multipart/form-data" >

		<div class="form-group mb-3">
			<label class="text-primary"><h4>Masukkan No. HP/ Whatsapp</h4></label>
			<input class='form-control' name="no_hp" type="number" id="no_hp_cek" autocomplete="off">
			<small>Masukkan salah satu nomor No. HP/ Whatsapp yang terdaftar dalam satu desa</small>
		</div>
		<button type="button" onclick="cek()" class="btn btn-primary waves-effect waves-light btn-block">CEK</button>
	</form>
	<p></p>
	 <div class="text-center text-danger" id="spinner_hasil">Memuat Hasil....</div>
	<div id="tampil_cek"></div>
</div>