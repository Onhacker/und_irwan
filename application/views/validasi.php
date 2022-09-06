<html>
<head>
	<title>
		Laporan
	</title>
	<style>
		* {
			font-size:11px;
		}
		.judul {
			font-size:13px;
			font-weight:bold;
			text-align: center;
		}

		.judulz {
			font-size:9px;
			font-weight:bold;
			text-align: center;
		}
		
		
		
.tabel {
	border-collapse: collapse;
	border-spacing: 0px;
}

.tabel th, .tabel td {
	border: 0px solid #000;
	padding: 2px;
	font-family: "Times New Roman", Times, serif; 
}



.foot {
	font-size: 10px !important;
}



</style> 
</head>

<body>
	<table width="100%">
		<tr>
			<td width="10%"><img style="width: 50px" src="<?php echo FCPATH."assets/images/logo.png"; ?>"></td>
			<td width="90%"><span class="judul">PKPD<br>Pusat Konsultasi Pemerintahan Daerah</span></td>		</tr>
	</table>
	<hr>
	<p style="font-weight: bold;text-align: center;">Data Pendaftaran Online Peserta Training & Edukasi <?php echo ucwords(strtolower($this->fm->web_me()->nama_website))?></p>
	
	<table width="100%">
		<tr>
			<td width="30%">Kegiatan</td>
			<td width="3%">:</td>
			<td width="77%">Training & Edukasi <?php echo ucwords(strtolower($this->fm->web_me()->nama_website))?></td>
		</tr>
		<tr>
			<td>Tempat pelaksanaan</td>
			<td>:</td>
			<td><?php echo ucwords(strtolower($this->fm->web_me()->hotel))?></td>
		</tr>
		<tr>
			<td>Waktu Pelaksanaan</td>
			<td>:</td>
			<td><?php echo ucwords(strtolower($this->fm->web_me()->tgl_acara))?></td>
		</tr>
		<tr>
			<td>Jumlah Pembayaran</td>
			<td>:</td>
			<td>Rp <?php echo uang($this->fm->web_me()->uang)?></td>
		</tr>
	</table>
	<br><br>


	<table width="100%">
		<tr>
			<td width="30%">Desa</td>
			<td width="3%">:</td>
			<td width="77%"><?php echo $desa->desa?></td>
		</tr>
		<tr>
			<td>Kecamatan</td>
			<td>:</td>
			<td><?php echo $kecamatan->kecamatan?></td>
		</tr>
		<tr>
			<td>Kabupaten</td>
			<td>:</td>
			<td><?php echo $kota->kota?></td>
		</tr>
	</table>
	<br><br>

	<table width="100%" class="tabel">
		<tr style="font-weight: bold; text-align: center;">
			<td colspan="3">DATA PESERTA</td>
		</tr>
		<tr style="font-weight: bold; text-align: center;">
			<th width="5%">No</th>
			<th width="50%">Nama</th>
			<th width="25%">Jabatan</th>
			<th width="20%">No.Hp</th>
		</tr>
		<?php 
		$i = 1;
		foreach ($res->result() as $row) : ?>
		<tr>
			<td><?php echo $i++	 ?>.</td>
			<td><?php echo $row->nama ?></td>
			<td><?php echo $row->jabatan ?></td>
			<td><?php echo $row->no_hp ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<br><br>
	<table width="100%">
		<tr>
			<td width="20%">Tanggal Daftar </td>
			<td width="5%">:</td>
			<?php 
            $ar = explode(" ", $ket->tanggal);
            $har = hari_ini($ar[1]);
        ?>
        <td width="75%"><?php echo $har .", ".tgl_df($ket->tanggal) ; ?></td>
		</tr>
		<tr>
			<td>Pembayaran</td>
			<td>:</td>
			<td>Lunas</td>
		</tr>
		<tr>
			<td>Bukti Pelunasan</td>
			<td>:</td>
			<td><img style="height: 300px; width:  200px" src="<?php echo FCPATH."upload/gambar/".$ket->gambar.""; ?>"></td>
		</tr>
	</table>
<hr>
<p style="text-align: left;"><img style="width: 100px;" src="<?php echo $savename;?>">&nbsp;<br><?php echo $desa->desa ?></p>
<!-- <p style="text-align: center;"><?php echo $desa->desa ?></p> -->
</body>

</html>