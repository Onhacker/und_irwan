<script>
	var table;
	$(document).ready(function(){
		$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
		{
			return {
				"iStart": oSettings._iDisplayStart,
				"iEnd": oSettings.fnDisplayEnd(),
				"iLength": oSettings._iDisplayLength,
				"iTotal": oSettings.fnRecordsTotal(),
				"iFilteredTotal": oSettings.fnRecordsDisplay(),
				"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
				"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
			};
		};

		table = $('#example').DataTable({
			"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        // lengthChange: false,
        // dom: 'B<"clear">lfrtip',
        // buttons: ['copy', 'excel', 'pdf', 'colvis'],
        initComplete: function() {
        	var api = this.api();
        	$('.dataTables_filter input').addClass('form-control form-control-sm')
        	$('.dataTables_length select').addClass('form-control form-control-sm')
        	$('#datatable-buttons_filter input')
        	.off('.DT')
        	.on('input.DT', function() {
        		api.search(this.value).draw();
        	});
        },	


        oLanguage: {

        	sProcessing: "Memuat Data...",
        	sSearch: "Cari Data :",
        	sZeroRecords:    "Maaf Data Tidak Ditemukan",
        	sLengthMenu:     "Tampil _MENU_ Data",
        	sEmptyTable:     "Data Tidak Ada",
        	sInfo:           "Menampilkan _START_ sampai _END_ dari _TOTAL_ Data",
        	sInfoEmpty:      "Tidak ada data ditampilkan",
        	sInfoFiltered:   "(Filter dari _MAX_ total Data)",
        },
        processing: true,
        serverSide: true,
        
        ajax: {"url": "<?php echo site_url("cek_desa/get_data")?>", "type": "POST"},
        columns: [
        
        {
        	"data": "id_proyek",
        	"orderable": false
        },
        {"data": "kabupaten"},
        {"data": "prov"},
        {"data": "web"},
        {"data": "tgl_acara"},
        
        ],
        "order": [],
        rowCallback: function(row, data, iDisplayIndex) {
        	var info = this.fnPagingInfo();
        	var page = info.iPage;
        	var length = info.iLength;
        	var index = page * length + (iDisplayIndex + 1);
              $('td:eq(0)', row).html(index); // masukkan index untuk menampilkan no urut
          }

      });
	});

	$("#check-all").click(function () {
		$(".data-check").prop('checked', $(this).prop('checked'));
	});

	
	function reload_table()
	{
		table.ajax.reload(null,false); 
	}


</script>

