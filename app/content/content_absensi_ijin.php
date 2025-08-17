<div class="container-fluid">
			<div class="row clearfix">
            <div class="card col-md-8">
            <div class="body">
			<form method="get">				
				<div class="col-sm-3 ">
					<div class="form-group">
						<div class="form-line">
							<input type="text" id="date" name="date" value="<?= $_GET['date']?>" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="Tanggal" required>
						</div>
					</div>
				</div>
				<div class="col-sm-4 ">
					<div class="form-group">
					<?php if($_SESSION['area']=='all') { ?>
						<select name="area" class="form-control show-tick">
							<option value="">-- Pilih Area --</option>
								<?php
									$a=$_GET['area'];
									$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area");
									while($d_a = mysqli_fetch_assoc($sql_a)){
									if($a == $d_a['kode_area']){
									echo '<option value="'.$d_a['kode_area'].'" selected>'.$d_a['area'].'</option>';
										} else {
									echo '<option value="'.$d_a['kode_area'].'">'.$d_a['area'].'</option>';		
										}
									}
								?>
								
						</select>
						<?php ;} else {?>
						<select name="area" class="form-control show-tick">
							
								<?php
									$a=$_GET['area'];
									$sql_a = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM area where kode_area='$_SESSION[area]'");
									while($d_a = mysqli_fetch_assoc($sql_a)){
									
									echo '<option value="'.$d_a['kode_area'].'" selected>'.$d_a['area'].'</option>';
										
									}
								?>
								
						</select>
						<?php ;} ?>
					</div>
				</div>
				<button type="submit" class="btn btn-primary waves-effect">
                <i class="material-icons">search</i>
                <span>FILTER</span>
                </button>
				                       
           </div>    
        </div>
            </div>
			<?php 
					if(isset($_GET['date']) && $_GET['date']){
					?>
            <div class="row clearfix">
			 <div class="card">
                        <div class="header">
                            <h2>
                                DATA SISWA TIDAK MASUK <?php $skr = $_GET['date'] ;  echo $skr;?>
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Status Keanggotaan</th>
                                            <th>Lokasi</th>
											<th>Area</th>
                                            <th>SubArea</th>
                                            <th>Keterangan</th>
											
											
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
									<?php
							
										$s_karyawan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from absensi,karyawan  where absensi.nik=karyawan.nik AND absensi.ijin is not NULL  AND absensi.tanggal='$_GET[date]' AND karyawan.area LIKE '%$_GET[area]'");
										while ($d_karyawan=mysqli_fetch_array($s_karyawan)){
									?>
                                        <tr>
											
                                            <td><?= $d_karyawan['nik'];?></td>
                                            <td><?= $d_karyawan['nama'];?></td>
                                            <td><?= $d_karyawan['job_title'];?></td>
                                            <td><?= $d_karyawan['lokasi'];?></td>
											<td><?= $d_karyawan['area'];?></td>
                                            <td><?= $d_karyawan['sub_area'];?></td>
                                            <td><span class="badge bg-red"><?= $d_karyawan['ijin'];?><span></td>
                                            
                                        </tr>
									<?php ;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
			</div>
			<?php
			}else{ ?>
				<div class="col-md-9">
						
				</div>
						<?php
							}
						
						?>
</div>
