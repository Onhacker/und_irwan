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

.tabel th {
	text-align: center;
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
	<p>Silahkan Perlihatkan Kode Pendaftaran Barcode di bawah ini pada saat Checkin. </p>
	
<p style="text-align: center;"><img style="width: 100px;" src="<?php echo $savename;?>">&nbsp;<br><?php echo $desa->desa ?></p>
<!-- <p style="text-align: center;"><?php echo $desa->desa ?></p> -->
</body>

</html>