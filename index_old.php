<?php
include 'include/koneksi.php';
include 'include/app.php';

$skr = date('Y-m-d');
?>
<!Doctype html>
<html lang="en-US">
	<head>
	
		<!-- ==============================================
		Title and basic Metas
		=============================================== -->
        <meta charset="utf-8">
        <title><?= $app['nama_aplikasi'];?> - <?= $app['nama_perusahaan'];?></title>
		<meta name="description" content="Sistem Absensi Siswa SMP IT INSAN GUNA INDONESIA	”.">
		<meta name="author" content="ThemeArt">
		
		<!-- ==============================================
		Mobile Metas
		=============================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- ==============================================
		Fonts and CSS
		=============================================== -->
		<link href="http://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet" type="text/css">
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
		<link href="css1/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="css1/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css1/style.css" rel="stylesheet" type="text/css">
		
		<!-- ==============================================
		JS
		=============================================== -->
		<script src="js/jquery-1.10.2.min.js"></script>
        <script src="js/modernizr.custom.97074.js"></script>
		<script src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
        
		<!--[if lt IE 9]>
			<script src="js/selectivizr.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->

        <!-- ==============================================
		Favicons
		=============================================== -->
       
        <link rel="shortcut icon" href="images/icon/logogl.jpg">

    </head>
    <body>
		<div class="wrapper">
		<div id="loading"></div>
		
		<div id="ascensor">
			<section class="section home">
				<div class="center-box">
					<div class="container">
					<div class="row">
							<div class="socialize">
								<h2 class="h2"><img src="images/logo smp.png" width="16%" alt="Image"> <?= $app['nama_aplikasi'];?></h2>
							</div>
						</div>
						<div class="tile">
						</div>
						<div class="tile tile-item tile-client">
							<a class="ascensorLink tile-nav" href="masuk">
								<h5 class="h5">Masuk</h5>
								<i class="fa fa-sign-in fa-4x"></i>
							</a>
						</div>
						<div class="tile tile-item tile-service">
							<a class="ascensorLink  tile-nav" href="pulang">
								<h5 class="h5">Pulang</h5>
								<i class="fa fa-sign-out fa-4x"></i>
							</a>
						</div>
						
						<script type="text/javascript">
							var detik = <?php echo date('s'); ?>;
							var menit = <?php echo date('i'); ?>;
							var jam   = <?php echo date('H'); ?>;
						 
							function clock()
							{
							if (detik!=0 && detik%60==0) {
								menit++;
								detik=0;
							}
							second = detik;
							 
							if (menit!=0 && menit%60==0) {
								jam++;
								menit=0;
							}
							minute = menit;
							 
							if (jam!=0 && jam%24==0) {
								jam=0;
							}
							hour = jam;
							 
							if (detik<10){
								second='0'+detik;
							}
							if (menit<10){
								minute='0'+menit;
							}
							 
							if (jam<10){
								hour='0'+jam;
							}
							waktu = hour+':'+minute+':'+second;
							 
							document.getElementById("clock").innerHTML = waktu;
							detik++;
						}
					 
						setInterval(clock,1000);
						</script>
						<div class="clearfix"> </div>
						<div class="row">
						<div class="col-sm-12 col-md-12 col-lg-12">
							<div class="about-note">
								
								<p align="center"><h1><div align="center" id="clock"></div></h1></p>
								<p ><h4 align="center"><?php $tanggal = date('d M Y');
								$day = date('D', strtotime($tanggal));
								$dayList = array(
									'Sun' => 'Minggu',
									'Mon' => 'Senin',
									'Tue' => 'Selasa',
									'Wed' => 'Rabu',
									'Thu' => 'Kamis',
									'Fri' => 'Jumat',
									'Sat' => 'Sabtu'
								);
								echo $dayList[$day].", ".$tanggal;?></h4></p>
								<p align="center"><?= $app['nama_perusahaan'];?></p>
							</div>
						</div>
						
					</div>
					<p align="center"><img src="" width="100%" alt=""></p>
				
							
					</div>
				</div>

			</section> <!-- /home -->
			
			<!-- /portfolio -->
			
			<!-- /follow -->
			
		</div> 
		<!-- /ascensor -->
		
		</div> <!-- /wrapper -->
		
		<!-- ==============================================
		JS
		=============================================== -->
		<script src="js/jquery.ascensor.js"></script>
        <script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.mixitup.min.js"></script>
		<script src="js/jquery.hoverdir.js"></script>
		<script src="js/jquery.placeholder.min.js"></script>
        <script src="js/main.js"></script>
		

 </body>
</html>