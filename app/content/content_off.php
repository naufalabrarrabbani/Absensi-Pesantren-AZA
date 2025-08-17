<div class="container-fluid">
			<div class="row clearfix">
			<div class="block-header">
                <h2><?php $tanggal = date('d M Y');
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
								echo $dayList[$day].", ".$tanggal;?></h2>
            </div>
            
            <div class="body">
			 <div class="icon-and-text-button-demo">
                            <a href="content/off.xls">
                                <button type="button" class="btn btn-success waves-effect" data-toggle="modal" data-target="#smallModal">
                                    <i class="material-icons">file_download</i>
                                    <span>FORMAT EXCEL</span>
                                </button> 
							</a>	
								
							</div>               
           </div>    
       
            </div>
		
            <div class="row clearfix">
			 <div class="card">
                        <div class="header">
                            <h2>
                                IMPORT SCHEDULE SISWA OFF DAY <?php $skr = $_GET['date'] ;  echo $skr;?>
                            </h2>
                        </div>
                        <div class="body">
                            <form name="myForm" id="myForm" onSubmit="return validateForm2()" action="controller/off_import.php" method="post" enctype="multipart/form-data">
											<div class="row clearfix">
												<div class="col-sm12 col-xs-12">
														<div class="form-group">
															<div class="form-line">
																<input type="file" id="fileoff" name="fileoff"  class="form-control" required>
															</div>
															
														</div>
														<small>*masukkan file .xls (excel 2003)</small><br/>
														<br/>
														
													</div>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" name="submit"  class="btn btn-success waves-effect" value="Import" />
										</div>
										</form>
										<script type="text/javascript">
										//    validasi form (hanya file .xls yang diijinkan)
											function validateForm2()
											{
												function hasExtension(inputID, exts) {
													var fileName = document.getElementById(inputID).value;
													return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
												}
										 
												if(!hasExtension('fileoff', ['.xls'])){
													alert("Hanya file XLS (Excel 2003) yang diijinkan.");
													return false;
												}
											}
										</script>
                        </div>
                    </div>
			</div>
			
				
</div>
