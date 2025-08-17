<!-- Jquery Core Js -->
    
    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js -->
    <script src="plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Custom Js -->
    <script src="js/pages/forms/basic-form-elements.js"></script>
	<script>
	$('#date').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
	$('#date2').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    </script>
	<!-- Demo Js -->
    <script src="js/demo.js"></script>
	
	 <!-- Jquery DataTable Plugin Js -->
    <script src="plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	 <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/tables/jquery-datatable.js"></script>
	<!-- Edit -->
	<script type="text/javascript">
            $(document).on('click', '.pilihan', function () {
				document.getElementById("nik").value = $(this).attr('a1');
				document.getElementById("nama").value = $(this).attr('a2');
				document.getElementById("job_title").value = $(this).attr('a3');
				document.getElementById("no_telp").value = $(this).attr('a4');
				document.getElementById("jk").value = $(this).attr('a5');
				document.getElementById("agama").value = $(this).attr('a6');
				document.getElementById("lokasi").value = $(this).attr('a7');
				document.getElementById("area").value = $(this).attr('a8');
				document.getElementById("sub_area").value = $(this).attr('a9');
				document.getElementById("date").value = $(this).attr('a10');
				document.getElementById("date2").value = $(this).attr('a11');
				document.getElementById("file").value = $(this).attr('a12');
            });
	</script>
	<!-- Edit Lokasi -->
	<script type="text/javascript">
            $(document).on('click', '.pilih_lokasi', function () {
				document.getElementById("id").value = $(this).attr('l1');
				document.getElementById("kode").value = $(this).attr('l2');
				document.getElementById("lokasi").value = $(this).attr('l3');
            });
	</script>
	<!-- Edit Area -->
	<script type="text/javascript">
            $(document).on('click', '.pilih_area', function () {
				document.getElementById("id_area").value = $(this).attr('area1');
				document.getElementById("kode_area").value = $(this).attr('area2');
				document.getElementById("area").value = $(this).attr('area3');
            });
	</script>
	<!-- Edit Sub Area -->
	<script type="text/javascript">
            $(document).on('click', '.pilih_subarea', function () {
				document.getElementById("id_subarea").value = $(this).attr('subarea1');
				document.getElementById("kode_subarea").value = $(this).attr('subarea2');
				document.getElementById("subarea").value = $(this).attr('subarea3');
            });
	</script>
	<!-- Edit Job Title-->
	<script type="text/javascript">
            $(document).on('click', '.pilih_jobtitle', function () {
				document.getElementById("id_jobtitle").value = $(this).attr('j1');
				document.getElementById("kode_jobtitle").value = $(this).attr('j2');
				document.getElementById("jobtitle").value = $(this).attr('j3');
            });
	</script>
	<!-- Edit absensi---->
	<script type="text/javascript">
            $(document).on('click', '.pilih_absen', function () {
				document.getElementById("nik_pegawai").value = $(this).attr('p1');
				document.getElementById("masuk").value = $(this).attr('p2');
				document.getElementById("pulang").value = $(this).attr('p3');
				document.getElementById("tanggal").value = $(this).attr('p4');
            });
	</script>
	<!-- Edit user---->
	<script type="text/javascript">
            $(document).on('click', '.pilih_user', function () {
				document.getElementById("id_user").value = $(this).attr('u1');
				document.getElementById("username").value = $(this).attr('u2');
				document.getElementById("nama_user").value = $(this).attr('u4');
				document.getElementById("password").value = $(this).attr('u3');
            });
	</script>
	