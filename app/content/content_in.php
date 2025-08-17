<div class="container-fluid">
    <div class="row clearfix">
	<?php
				/* handle error */
					if (isset($_GET['sukses'])) : ?>
                  <div class="alert bg-green alert-dismissible" role="alert">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                
                    <?=base64_decode($_GET['sukses']);?>
                  </div>
                <?php endif;?>
					<div class="card">
                        <div class="body">
							<div class="row">
							
									<form id="search" method="get">
									<div class="col-md-12">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">phone</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="number" name="hp" class="form-control" placeholder="Cari No Telepon" value="<?= $_GET['hp'];?>">
                                        </div>
										<span class="input-group-addon">
                                            <button type="submit" class="btn bg-purple btn-circle-lg waves-effect waves-circle waves-float">
												<i class="material-icons">search</i>
											</button>
                                        </span>
                                    </div>
									</div>
									</form>
									<form id="laundry_in"  method="POST" action="controller/laundry_in">
									<?php
									$s_pelanggan= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from pelanggan where no_hp='$_GET[hp]'");
									$cek=mysqli_num_rows($s_pelanggan);
									$d_pelanggan = mysqli_fetch_array($s_pelanggan);
									?>
									
									<div class="col-md-4">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">phone</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="number" name="no_hp" class="form-control" value="<?= $_GET['hp'];?>" <?php if($cek==1){echo'readonly="readonly"';} else {echo'';}?> placeholder="HP" required>
                                        </div>
                                    </div>
									</div>
									<div class="col-md-8">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">person</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="nama" class="form-control" value="<?= $d_pelanggan['nama'];?>" <?php if($cek==1){echo'readonly="readonly"';} else {echo'';}?> placeholder="Nama" required>
                                        </div>
                                    </div>
									</div>
									<div class="col-md-12">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">home</i>
                                        </span>
                                        <div class="form-line">
                                            <textarea rows="3" name="alamat" class="form-control no-resize" placeholder="Alamat Rumah" <?php if($cek==1){echo'readonly="readonly"';} else {echo'';}?>><?= $d_pelanggan['alamat'];?></textarea>
                                        </div>
                                    </div>
									</div>
									<div class="col-md-4">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">note_add</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="number" name="nota" class="form-control" placeholder="No Nota" required>
                                        </div>
                                    </div>
									</div>
									<div class="col-md-4">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">local_laundry_service</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="text" name="kilogram" class="form-control" placeholder="Kilogram" required>
                                        </div>
                                    </div>
									</div>
									<div class="col-md-4">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">shopping_cart</i>
                                        </span>
                                        <div class="form-line">
                                            <input type="number" name="total" class="form-control" placeholder="Total" required>
                                        </div>
                                    </div>
									</div>
									<div class="col-md-4">
									<div class="input-group input-group-lg">
                                        <span class="input-group-addon">
                                            <i class="material-icons">date_range</i>
                                        </span>
                                        <div class="form-line">
											<input type="hidden" name="tgl_masuk" class="form-control" value="<?php $skr=date('Y-m-d'); echo $skr;?>">
                                            <input type="text" id="date" name="tgl_selesai" class="datepicker form-control" data-date-format="yyyy/mm/dd" placeholder="Tanggal Selesai" required>
                                        </div>
                                    </div>
									</div>
									<div class="row">
										<div class="col-xs-8 p-t-5">
										  
										</div>
										<div class="col-xs-4">
										   <button type="submit" class="btn bg-green btn-circle-lg waves-effect waves-circle waves-float">
																<i class="material-icons">check</i>
															</button>
										</div>
									</div>
									
                                            
                                        
									</form>
	                        </div>        
                        </div>
                    </div>
					
                
            </div>
           
</div>