<?php
include 'include/koneksi.php';
include 'include/app.php';
$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from karyawan where nik='$_GET[nik]'");
$karyawan = mysqli_fetch_array($s_karyawan);
$t_karyawan = mysqli_num_rows($s_karyawan);
?>
<!DOCTYPE html>
<html>
<head>
  <title><?= $app['nama_aplikasi'];?> - <?= $app['nama_perusahaan'];?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Statistics UI Kit Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<!--// bootstrap-css -->
<!-- css -->
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--// css -->
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- font -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- //font -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
<!-- circle -->
<script src="js/circliful.js"></script>
 <script>
							$( document ).ready(function() { // 6,32 5,38 2,34
								$("#test-circle").circliful({
									animation: 1,
									animationStep: 5,
									foregroundBorderWidth: 15,
									backgroundBorderWidth: 15,
									percent: 71,
									textSize: 28,
									text: 'New Users',
									textStyle: 'font-size: 12px;',
									textColor: '#666'
								});
							});

						</script>
<!-- //circle -->
<!--chart js-->
<script src="js/Chart.js"></script>
<!--//chart js-->
<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#horizontalTab').easyResponsiveTabs({
			type: 'default', //Types: default, vertical, accordion           
			width: 'auto', //auto or any width like 600px
			fit: true   // 100% fit in a container
		});
	});
</script>
<!--Calender -->
  <link rel="stylesheet" href="css/clndr.css" type="text/css" />
  <script src="js/underscore-min.js"></script>
  <script src= "js/moment-2.2.1.js"></script>
  <script src="js/clndr.js"></script>
  <script src="js/site.js"></script>
<!--End Calender-->
<!-- chart-grid-left -->
<link rel="stylesheet" href="css/master.css">
<script src="js/d3.min.js"></script>
<script src="js/xcharts.min.js"></script>
<script src="js/rainbow.min.js"></script>
<!-- //chart-grid-left -->
<!-- fabochart -->
<link href="css/fabochart.css" rel="stylesheet" type="text/css">
<!-- //fabochart -->
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->

</head>
<body>
<script language=javascript>
setTimeout("location.href='pulang'", 2000);
</script>	
	<div>
		<div class="container">
			<div class="logo">
				<h1>ABSENSI SUKSES</h1>
			</div>
			<!-- header -->
			
			<!-- //header -->
			<div class="content-grids">
				<!-- content-top-grids -->
				<div class="content-top-grids">
					<div class="col-md-2 content-left">
					</div>
					<div class="col-md-8 content-middle">
						<div class="clock-grids">
							<div class="clock-heading">
								<h3><?= $karyawan['nama'];?></h3>
							</div>
							<div class="clock-center">
								<p  align="center"><img src="app/images/<?= $karyawan['foto'];?>" width="190px" alt="image" /></p>
								<p align="center"><b>NIK : <?= $karyawan['nik'];?></b></p>
							<p align="center"><?php  $d_jt = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from jobtitle where kode_jobtitle ='$karyawan[job_title]'")); echo $d_jt['jobtitle'];?> - <?php  $d_a = mysqli_fetch_array(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from area where kode_area ='$karyawan[area]'")); echo $d_a['area'];?></p>
							</div>
							<div class="clock-bottom">
								<div class="clock">
									<div id="Date"></div>
									<ul>
										<li id="hours"> </li>
										<li id="point">:</li>
										<li id="min"> </li>
										<li id="point">:</li>
										<li id="sec"> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<!-- //content-top-grids -->
				<!-- weather-grids -->
				
				<!-- //weather-grids -->
				<!-- graph-tabs -->
				
				<!-- //graph-tabs -->
				<!-- contact-grids -->
				
				<!-- //contact-grids -->
				<!-- chart-grids -->
				
				<!-- //chart-grids -->
				<!-- footer -->
				
				<!-- //footer -->
				<div class="clearfix"> </div>
				<div class="copyright" >
					<p>© 2018 <?= $app['nama_perusahaan'];?> . All Rights Reserved <img src="images/botom.webp" alt="Image"></p>
				</div>
			</div>
		</div>
	</div>
	<!-- skills-bar -->
	<script src="js/bars.js"></script>
	<!-- //skills-bar -->
	<!-- clock -->
	<script language="javascript" type="text/javascript" src="js/jquery.thooClock.js"></script>  
	<script language="javascript">
		var intVal, myclock;

		$(window).resize(function(){
			window.location.reload()
		});

		$(document).ready(function(){

			var audioElement = new Audio("");

			//clock plugin constructor
			$('#myclock').thooClock({
				size:$(document).height()/1.4,
				onAlarm:function(){
					//all that happens onAlarm
					$('#alarm1').show();
					alarmBackground(0);
					//audio element just for alarm sound
					document.body.appendChild(audioElement);
					var canPlayType = audioElement.canPlayType("audio/ogg");
					if(canPlayType.match(/maybe|probably/i)) {
						audioElement.src = 'alarm.ogg';
					} else {
						audioElement.src = 'alarm.mp3';
					}
					// erst abspielen wenn genug vom mp3 geladen wurde
					audioElement.addEventListener('canplay', function() {
						audioElement.loop = true;
						audioElement.play();
					}, false);
				},
				showNumerals:true,
				brandText:'KSO APS-ISS',
				brandText2:'Indonesia',
				onEverySecond:function(){
					//callback that should be fired every second
				},
				//alarmTime:'15:10',
				offAlarm:function(){
					$('#alarm1').hide();
					audioElement.pause();
					clearTimeout(intVal);
					$('body').css('background-color','#FCFCFC');
				}
			});

		});



		$('#turnOffAlarm').click(function(){
			$.fn.thooClock.clearAlarm();
		});


		$('#set').click(function(){
			var inp = $('#altime').val();
			$.fn.thooClock.setAlarm(inp);
		});

		
		function alarmBackground(y){
				var color;
				if(y===1){
					color = '#CC0000';
					y=0;
				}
				else{
					color = '#FCFCFC';
					y+=1;
				}
				$('body').css('background-color',color);
				intVal = setTimeout(function(){alarmBackground(y);},100);
		}
	</script>

	<!-- //clock -->
	<!-- clock-bottom -->
	<script type="text/javascript">
	$(document).ready(function() {
	// Create two variable with the names of the months and days in an array
	var monthNames = [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "Nopember", "Desember" ]; 
	var dayNames= ["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"]

	// Create a newDate() object
	var newDate = new Date();
	// Extract the current date from Date object
	newDate.setDate(newDate.getDate());
	// Output the day, date, month and year    
	$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

	setInterval( function() {
		// Create a newDate() object and extract the seconds of the current time on the visitor's
		var seconds = new Date().getSeconds();
		// Add a leading zero to seconds value
		$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
		},1000);
		
	setInterval( function() {
		// Create a newDate() object and extract the minutes of the current time on the visitor's
		var minutes = new Date().getMinutes();
		// Add a leading zero to the minutes value
		$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
		},1000);
		
	setInterval( function() {
		// Create a newDate() object and extract the hours of the current time on the visitor's
		var hours = new Date().getHours();
		// Add a leading zero to the hours value
		$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
		}, 1000);
		
	}); 
	</script>
	<!-- clock-bottom -->
	<!--skycons-icons-->
	<script src="js/skycons.js"></script>
		<!--//skycons-icons-->
		<script>
				 var icons = new Skycons({"color": "#FFFFFF"}),
					  list  = [
						"clear-day"
					  ],
					  i;

				  for(i = list.length; i--; )
					icons.set(list[i], list[i]);

				  icons.play();
			</script>
			<script>
				 var icons = new Skycons({"color": "#f5f5f5"}),
					  list  = [
						"clear-night", "partly-cloudy-day",
						"partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
						"fog"
					  ],
					  i;

				  for(i = list.length; i--; )
					icons.set(list[i], list[i]);

				  icons.play();
			</script>
		
		<!-- graph-tabs -->
		<script src="js/jquery.graphly.min.js"></script>
		<link rel="stylesheet" media="screen" href="css/bootstrap-responsive.min.css" />
		<script>
            $(function() {
                 $('#negative-positive-graph-button').click(function() {
                    $('li.active').removeClass('active');
                    $('#negative-positive-graph-button').parent().addClass('active');
                    $('.example:visible').not('#negative-positive-container').fadeOut(300, function() {
                        $('#negative-positive-container').fadeIn(300);
                    });
                });
                $('#line-graph-button').click(function() {
                    $('li.active').removeClass('active');
                    $('#line-graph-button').parent().addClass('active');
                    $('.example:visible').not('#line-graph-container').fadeOut(300, function() {
                        $('#line-graph-container').fadeIn(300);
                    });
                });
                
                $('#custom-colours-button').click(function() {
                    $('li.active').removeClass('active');
                    $('#custom-colours-button').parent().addClass('active');
                    $('.example:visible').not('#custom-colours-container').fadeOut(300, function() {
                        $('#custom-colours-container').fadeIn(300);
                    });
                });
                
                $('#grouped-graph-button').click(function() {
                    $('li.active').removeClass('active');
                    $('#grouped-graph-button').parent().addClass('active');
                    $('.example:visible').not('#grouped-graph-container').fadeOut(300, function() {
                        $('#grouped-graph-container').fadeIn(300);
                    });
                });
            });
        </script>
		<script src="js/line_graph.js"></script>
		<script src="js/custom_colours.js"></script>
		<script src="js/grouped_graph.js"></script>
		<script src="js/negative_positive_graph.js"></script>
		<!-- //graph-tabs -->
		<!-- chart-grid-left -->
		<script>
			(function () {
			var data = [{"xScale":"ordinal","comp":[],"main":[{"className":".main.l1","data":[{"y":15,"x":"2012-11-19T00:00:00"},{"y":11,"x":"2012-11-20T00:00:00"},{"y":8,"x":"2012-11-21T00:00:00"},{"y":10,"x":"2012-11-22T00:00:00"},{"y":1,"x":"2012-11-23T00:00:00"},{"y":6,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]},{"className":".main.l2","data":[{"y":29,"x":"2012-11-19T00:00:00"},{"y":33,"x":"2012-11-20T00:00:00"},{"y":13,"x":"2012-11-21T00:00:00"},{"y":16,"x":"2012-11-22T00:00:00"},{"y":7,"x":"2012-11-23T00:00:00"},{"y":18,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]}],"type":"line-dotted","yScale":"linear"},{"xScale":"ordinal","comp":[],"main":[{"className":".main.l1","data":[{"y":12,"x":"2012-11-19T00:00:00"},{"y":18,"x":"2012-11-20T00:00:00"},{"y":8,"x":"2012-11-21T00:00:00"},{"y":7,"x":"2012-11-22T00:00:00"},{"y":6,"x":"2012-11-23T00:00:00"},{"y":12,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]},{"className":".main.l2","data":[{"y":29,"x":"2012-11-19T00:00:00"},{"y":33,"x":"2012-11-20T00:00:00"},{"y":13,"x":"2012-11-21T00:00:00"},{"y":16,"x":"2012-11-22T00:00:00"},{"y":7,"x":"2012-11-23T00:00:00"},{"y":18,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]}],"type":"cumulative","yScale":"linear"},{"xScale":"ordinal","comp":[],"main":[{"className":".main.l1","data":[{"y":12,"x":"2012-11-19T00:00:00"},{"y":18,"x":"2012-11-20T00:00:00"},{"y":8,"x":"2012-11-21T00:00:00"},{"y":7,"x":"2012-11-22T00:00:00"},{"y":6,"x":"2012-11-23T00:00:00"},{"y":12,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]},{"className":".main.l2","data":[{"y":29,"x":"2012-11-19T00:00:00"},{"y":33,"x":"2012-11-20T00:00:00"},{"y":13,"x":"2012-11-21T00:00:00"},{"y":16,"x":"2012-11-22T00:00:00"},{"y":7,"x":"2012-11-23T00:00:00"},{"y":18,"x":"2012-11-24T00:00:00"},{"y":8,"x":"2012-11-25T00:00:00"}]}],"type":"bar","yScale":"linear"}];
			var order = [0, 1, 0, 2],
			  i = 0,
			  xFormat = d3.time.format('%A'),
			  chart = new xChart('line-dotted', data[order[i]], '#chart', {
				axisPaddingTop: 5,
				dataFormatX: function (x) {
				  return new Date(x);
				},
				tickFormatX: function (x) {
				  return xFormat(x);
				},
				timing: 1250
			  }),
			  rotateTimer,
			  toggles = d3.selectAll('.multi button'),
			  t = 3500;

			function updateChart(i) {
			  var d = data[i];
			  chart.setData(d);
			  toggles.classed('toggled', function () {
				return (d3.select(this).attr('data-type') === d.type);
			  });
			  return d;
			}

			toggles.on('click', function (d, i) {
			  clearTimeout(rotateTimer);
			  updateChart(i);
			});

			function rotateChart() {
			  i += 1;
			  i = (i >= order.length) ? 0 : i;
			  var d = updateChart(order[i]);
			  rotateTimer = setTimeout(rotateChart, t);
			}
			rotateTimer = setTimeout(rotateChart, t);
			}());
		</script>
		<!-- //chart-grid-left -->
		<!-- fabochart -->
		<script src="js/fabochart.js"></script>
		<script>
		$(document).ready(function () {
			data = {
			  '2010' : 300, 
			  '2011' : 200,
			  '2012' : 100,
			  '2013' : 500,
			  '2014' : 400,
			  '2015' : 200
			};

			$("#chart1").faBoChart({
			  time: 500,
			  animate: true,
			  instantAnimate: true,
			  straight: false,
			  data: data,
			  labelTextColor : "#C0392B",
			});
			$("#chart2").faBoChart({
			  time: 2500,
			  animate: true,
			  data: data,
			  straight: true,
			  labelTextColor : "#C0392B",
			});
		});
		</script>
		<!-- //fabochart -->
</body>	
</html>